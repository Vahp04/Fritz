<?php

namespace App\Http\Controllers;

use App\Models\stock_equipos;
use App\Models\tipo_equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
class StockEquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $stockEquipos = stock_equipos::with('tipoEquipo')->orderBy('id', 'asc') 
            ->paginate(10);
    
    // Calcular stock bajo en el controlador
    $stockBajoCount = $stockEquipos->filter(function($equipo) {
        return $equipo->cantidad_disponible < $equipo->minimo_stock;
    })->count();
    
    $tipo_equipo = tipo_equipo::all();
    
    return view('stock.stock', compact('stockEquipos', 'tipo_equipo', 'stockBajoCount'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipo_equipo = tipo_equipo::all(); 
        return view('stock_equipos.create', compact('tipo_equipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'tipo_equipo_id' => 'required|exists:tipo_equipos,id',
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'cantidad_total' => 'required|integer|min:0',
        'cantidad_disponible' => 'required|integer|min:0',
        'cantidad_asignada' => 'required|integer|min:0',
        'minimo_stock' => 'required|integer|min:0',
        'fecha_adquisicion' => 'required|date',
        'valor_adquisicion' => 'required|numeric|min:0',
    ]);

    // Validación personalizada para nuevo equipo
    $validator->after(function ($validator) use ($request) {
        $total = $request->cantidad_total;
        $disponible = $request->cantidad_disponible;
        $asignada = $request->cantidad_asignada;

        // Para nuevo equipo: disponible debe ser igual a total y asignada debe ser 0
        if ($disponible != $total) {
            $validator->errors()->add(
                'cantidad_disponible', 
                'Para un equipo nuevo, la cantidad disponible debe ser igual a la cantidad total'
            );
        }

        if ($asignada != 0) {
            $validator->errors()->add(
                'cantidad_asignada', 
                'Para un equipo nuevo, la cantidad asignada debe ser 0'
            );
        }

        if ($total < 0) {
            $validator->errors()->add(
                'cantidad_total', 
                'La cantidad total no puede ser negativa'
            );
        }
    });

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    stock_equipos::create($request->all());

    return redirect()->route('stock_equipos.index')
        ->with('success', 'Equipo en stock creado exitosamente.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stock_equipos $stock_equipo)
    {
        $tipo_equipo = tipo_equipo::all(); // Corregir el nombre de la variable
        return view('stock_equipos.edit', compact('stock_equipo', 'tipo_equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, stock_equipos $stock_equipo)
{
    $validator = Validator::make($request->all(), [
        'tipo_equipo_id' => 'required|exists:tipo_equipos,id', 
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'cantidad_total' => 'required|integer|min:0',
        'cantidad_disponible' => 'required|integer|min:0',
        'cantidad_asignada' => 'required|integer|min:0',
        'minimo_stock' => 'required|integer|min:0',
        'fecha_adquisicion' => 'required|date',
        'valor_adquisicion' => 'required|numeric|min:0',
    ]);

    // Validación personalizada para edición
    $validator->after(function ($validator) use ($request, $stock_equipo) {
        $total = $request->cantidad_total;
        $disponible = $request->cantidad_disponible;
        $asignada = $request->cantidad_asignada;

        // Verificar que la suma sea correcta
        if ($disponible + $asignada != $total) {
            $validator->errors()->add(
                'cantidad_total', 
                'La suma de cantidad disponible y asignada debe ser igual a la cantidad total'
            );
        }

        // Verificar que no se reduzca la cantidad asignada por debajo de la actual
        if ($asignada < $stock_equipo->cantidad_asignada) {
            $validator->errors()->add(
                'cantidad_asignada', 
                'No puede reducir la cantidad asignada por debajo del valor actual (' . $stock_equipo->cantidad_asignada . ')'
            );
        }

        if ($disponible < 0 || $asignada < 0) {
            $validator->errors()->add(
                'cantidad_disponible', 
                'Las cantidades no pueden ser negativas'
            );
        }

        // Verificar que hay suficiente stock disponible para las asignaciones existentes
        if ($disponible < 0) {
            $validator->errors()->add(
                'cantidad_disponible', 
                'No hay suficiente stock disponible'
            );
        }
    });

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $stock_equipo->update($request->all());

    return redirect()->route('stock_equipos.index')
        ->with('success', 'Equipo en stock actualizado exitosamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stock_equipos $stock_equipo)
    {
        // Verificar si hay asignaciones relacionadas antes de eliminar
        if ($stock_equipo->asignaciones()->count() > 0) {
            return redirect()->route('stock_equipos.index')
                ->with('error', 'No se puede eliminar el equipo porque tiene asignaciones asociadas.');
        }

        $stock_equipo->delete();

        return redirect()->route('stock_equipos.index')
            ->with('success', 'Equipo en stock eliminado exitosamente.');
    }

    /**
     * API: Obtener todos los equipos en stock
     */
    public function apiIndex()
    {
        $stockEquipos = stock_equipos::with('tipo_equipo')->get();
        return response()->json($stockEquipos);
    }

    /**
     * API: Obtener un equipo específico
     */
    public function apiShow($id)
    {
        $stockEquipo = stock_equipos::with('tipo_equipo', 'asignaciones')->find($id);
        
        if (!$stockEquipo) {
            return response()->json(['error' => 'Equipo en stock no encontrado'], 404);
        }

        return response()->json($stockEquipo);
    }

    /**
     * Método para verificar stock bajo
     */
    public function stockBajo()
    {
        $stockBajo = stock_equipos::where('cantidad_disponible', '<=', 'minimo_stock')
            ->with('tipoEquipo')
            ->get();

        return view('stock_equipos.stock-bajo', compact('stockBajo'));
    }

    /**
     * Método para actualizar cantidades automáticamente
     */
    public function actualizarCantidades(Request $request, $id)
    {
        $stockEquipo = stock_equipos::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'cantidad_disponible' => 'required|integer|min:0',
            'cantidad_asignada' => 'required|integer|min:0',
        ]);

        $validator->after(function ($validator) use ($request, $stockEquipo) {
            $disponible = $request->cantidad_disponible;
            $asignada = $request->cantidad_asignada;
            $total = $disponible + $asignada;

            if ($disponible < 0 || $asignada < 0) {
                $validator->errors()->add(
                    'cantidad_disponible', 
                    'Las cantidades no pueden ser negativas'
                );
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stockEquipo->update([
            'cantidad_disponible' => $request->cantidad_disponible,
            'cantidad_asignada' => $request->cantidad_asignada,
            'cantidad_total' => $request->cantidad_disponible + $request->cantidad_asignada,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cantidades actualizadas correctamente',
            'data' => $stockEquipo
        ]);
    }

    /**
     * Método para obtener equipos por tipo
     */
    public function porTipo($tipoId)
    {
        $equipos = stock_equipos::where('tipo_equipo_id', $tipoId)
            ->with('tipo_equipo')
            ->get();

        return response()->json($equipos);
    }

    /**
     * Método para el dashboard - resumen de stock
     */
    public function resumenStock()
    {
        $totalEquipos = stock_equipos::sum('cantidad_total');
        $totalDisponible = stock_equipos::sum('cantidad_disponible');
        $totalAsignado = stock_equipos::sum('cantidad_asignada');
        $stockBajoCount = stock_equipos::whereRaw('cantidad_disponible <= minimo_stock')->count();
        $valorTotal = stock_equipos::sum('valor_adquisicion');

        return response()->json([
            'total_equipos' => $totalEquipos,
            'total_disponible' => $totalDisponible,
            'total_asignado' => $totalAsignado,
            'stock_bajo_count' => $stockBajoCount,
            'valor_total' => $valorTotal
        ]);
    }

    public function search(Request $request)
{
    $query = $request->get('query');
    
    $stock= stock_equipos::with(['tipo_equipo'])
                ->withCount([
                    'equiposAsignados as equipos_totales_count',
                    'equiposAsignadosActivos as equipos_activos_count',
                    'equiposAsignadosDevueltos as equipos_devueltos_count'
                ])
                ->where('marca', 'LIKE', "%{$query}%")
                ->orWhere('modelo', 'LIKE', "%{$query}%")
                ->orWhere('cargo', 'LIKE', "%{$query}%")
                ->get();

    return response()->json($stock);
}

/**
 * Generar PDF de stock de equipos 
 */
/**
 * Generar PDF de stock de equipos 
 */
public function generarPdfStock()
{
    try {
        
        $stockEquipos = stock_equipos::with('tipoEquipo') 
                       ->orderBy('tipo_equipo_id')
                       ->orderBy('marca')
                       ->get();

       
        $totalEquipos = $stockEquipos->sum('cantidad_total');
        $totalDisponible = $stockEquipos->sum('cantidad_disponible');
        $totalAsignado = $stockEquipos->sum('cantidad_asignada');
        
        // CORREGIR: Calcular valor total multiplicando valor_adquisicion por cantidad_total
        $valorTotal = $stockEquipos->sum(function($equipo) {
            return ($equipo->valor_adquisicion ?? 0) * ($equipo->cantidad_total ?? 0);
        });
        
   
        $stockBajo = $stockEquipos->filter(function($equipo) {
            return $equipo->cantidad_disponible <= $equipo->minimo_stock;
        });
        $stockBajoCount = $stockBajo->count();

        
        $equiposPorTipo = [];
        foreach ($stockEquipos as $equipo) {
            $tipoNombre = $equipo->tipoEquipo->nombre ?? 'Sin tipo';
            if (!isset($equiposPorTipo[$tipoNombre])) {
                $equiposPorTipo[$tipoNombre] = 0;
            }
            $equiposPorTipo[$tipoNombre] += $equipo->cantidad_total;
        }

        $data = [
            'stockEquipos' => $stockEquipos,
            'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
            'totalEquipos' => $totalEquipos,
            'totalDisponible' => $totalDisponible,
            'totalAsignado' => $totalAsignado,
            'valorTotal' => $valorTotal,
            'stockBajoCount' => $stockBajoCount,
            'equiposPorTipo' => $equiposPorTipo,
            'stockBajo' => $stockBajo
        ];

        $pdf = PDF::loadView('stock.pdf', $data)
                 ->setPaper('A4', 'landscape')
                 ->setOption('defaultFont', 'sans-serif');

        return $pdf->download('Reporte Stock de Equipos - ' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        \Log::error('Error generando PDF de stock: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        return redirect()->route('stock_equipos.index')
                       ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

/**
 * Ver PDF de stock en el navegador
 */
public function verPdfStock()
{
    try {
        
        $stockEquipos = stock_equipos::with('tipoEquipo') 
                       ->orderBy('tipo_equipo_id')
                       ->orderBy('marca')
                       ->get();

        
        $totalEquipos = $stockEquipos->sum('cantidad_total');
        $totalDisponible = $stockEquipos->sum('cantidad_disponible');
        $totalAsignado = $stockEquipos->sum('cantidad_asignada');
        
        // CORREGIR: Calcular valor total multiplicando valor_adquisicion por cantidad_total
        $valorTotal = $stockEquipos->sum(function($equipo) {
            return ($equipo->valor_adquisicion ?? 0) * ($equipo->cantidad_total ?? 0);
        });
        
       
        $stockBajo = $stockEquipos->filter(function($equipo) {
            return $equipo->cantidad_disponible <= $equipo->minimo_stock;
        });
        $stockBajoCount = $stockBajo->count();

        
        $equiposPorTipo = [];
        foreach ($stockEquipos as $equipo) {
            $tipoNombre = $equipo->tipoEquipo->nombre ?? 'Sin tipo'; 
            if (!isset($equiposPorTipo[$tipoNombre])) {
                $equiposPorTipo[$tipoNombre] = 0;
            }
            $equiposPorTipo[$tipoNombre] += $equipo->cantidad_total;
        }

        $data = [
            'stockEquipos' => $stockEquipos,
            'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
            'totalEquipos' => $totalEquipos,
            'totalDisponible' => $totalDisponible,
            'totalAsignado' => $totalAsignado,
            'valorTotal' => $valorTotal,
            'stockBajoCount' => $stockBajoCount,
            'equiposPorTipo' => $equiposPorTipo,
            'stockBajo' => $stockBajo
        ];

        $pdf = PDF::loadView('stock.pdf', $data)
                 ->setPaper('A4', 'landscape')
                 ->setOption('defaultFont', 'sans-serif');

        return $pdf->stream('reporte-stock-equipos-' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        \Log::error('Error viendo PDF de stock: ' . $e->getMessage());
        return redirect()->route('stock_equipos.index')
                       ->with('error', 'Error al cargar el PDF: ' . $e->getMessage());
    }
}
}
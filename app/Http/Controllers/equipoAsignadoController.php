<?php
namespace App\Http\Controllers;

use App\Models\EquipoAsignado;
use App\Models\Usuarios;
use App\Models\stock_equipos;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipoAsignadoController extends Controller
{
    public function index()
{
    $equiposAsignados = EquipoAsignado::with([
        'usuarios', 
        'usuario', 
        'stock_equipo.tipoEquipo' 
    ]) ->orderBy('id', 'asc') 
        ->paginate(10);
    
    $usuarios = Usuarios::where('activo', true)->get();
    $stock_equipos = stock_equipos::where('cantidad_disponible', '>', 0)
        ->with('tipoEquipo') 
        ->get();
    
    return view('equipoA.equipoA', compact('equiposAsignados', 'usuarios', 'stock_equipos'));
}

    public function create()
    {
        $usuarios = Usuarios::where('activo', true)->get();
        $stock_equipos = stock_equipos::where('cantidad_disponible', '>', 0)
            ->with('tipoEquipo')
            ->get();
        
        return view('equipos_asignados.create', compact('usuarios', 'stock_equipos'));
    }
    
public function store(Request $request)
{
    $stockEquipo = stock_equipos::with('tipoEquipo')->find($request->stock_equipos_id);
    $requiereIP = $stockEquipo->tipoEquipo->requiere_ip ?? true;

    $validator = Validator::make($request->all(), [
        'usuarios_id' => 'required|exists:usuarios,id',
        'stock_equipos_id' => 'required|exists:stock_equipos,id',
        'fecha_asignacion' => 'required|date',
        'ip_equipo' => $requiereIP ? 'required|ip' : 'nullable|ip', // Cambio aquí
        'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_asignacion',
        'observaciones' => 'nullable|string|max:500',
        'estado' => 'required|in:activo,devuelto,obsoleto' 
    ]);

    // Validar que el equipo esté disponible
    $validator->after(function ($validator) use ($request) {
        $stockEquipo = stock_equipos::find($request->stock_equipos_id);
        
        if ($stockEquipo && $stockEquipo->cantidad_disponible <= 0) {
            $validator->errors()->add(
                'stock_equipos_id', 
                'El equipo seleccionado no tiene stock disponible'
            );
        }

        // Verificar si el usuario ya tiene equipos asignados activos
        $asignacionesActivas = EquipoAsignado::where('usuarios_id', $request->usuarios_id)
            ->where('estado', 'activo')
            ->count();

        if ($asignacionesActivas >= 4) {
            $validator->errors()->add(
                'usuarios_id', 
                'El usuario ya tiene el máximo de equipos asignados permitidos'
            );
        }
    });

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Crear la asignación
    $equipoAsignado = EquipoAsignado::create([
        'usuarios_id' => $request->usuarios_id,
        'stock_equipos_id' => $request->stock_equipos_id,
        'fecha_asignacion' => $request->fecha_asignacion,
        'ip_equipo' => $request->ip_equipo,
        'fecha_devolucion' => $request->fecha_devolucion,
        'observaciones' => $request->observaciones,
        'usuario_id' => Auth::id(), 
        'estado' => $request->estado
    ]);

    // Actualizar el stock del equipo si el estado es activo
    if ($request->estado == 'activo') {
        $stockEquipo = stock_equipos::find($request->stock_equipos_id);
        if ($stockEquipo) {
            $stockEquipo->decrement('cantidad_disponible');
            $stockEquipo->increment('cantidad_asignada');
            \Log::info('Stock actualizado en creación:', [
                'equipo_id' => $stockEquipo->id,
                'nueva_cantidad_disponible' => $stockEquipo->cantidad_disponible,
                'nueva_cantidad_asignada' => $stockEquipo->cantidad_asignada
            ]);
        }
    }

    return redirect()->route('equipos_asignados.index')
        ->with('success', 'Equipo asignado exitosamente.');
}

    public function show(EquipoAsignado $equipoAsignado)
    {
        $equipoAsignado->load([
            'usuarios.sede', 
            'usuarios.departamento',
            'usuario',
            'stock_equipo.tipo_equipo'
        ]);
        
        return view('equipos_asignados.show', compact('equipoAsignado'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipoAsignado $equipoAsignado)
    {
        $usuarios = Usuarios::where('activo', true)->get();
        $stock_equipos = stock_equipos::with('tipoEquipo')->get();
        
        return view('equipos_asignados.edit', compact('equipoAsignado', 'usuarios', 'stock_equipos'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)  
{
    \Log::info('=== INICIANDO ACTUALIZACIÓN ===');
    \Log::info('ID recibido:', ['id' => $id]);
    \Log::info('Datos recibidos:', $request->all());

    // Buscar manualmente el equipo asignado
    $equipoAsignado = EquipoAsignado::find($id);
    
    if (!$equipoAsignado) {
        \Log::error('Equipo asignado no encontrado', ['id' => $id]);
        return redirect()->route('equipos_asignados.index')
            ->with('error', 'Asignación no encontrada.');
    }

    \Log::info('Equipo encontrado:', [
        'id' => $equipoAsignado->id, 
        'estado_actual' => $equipoAsignado->estado,
        'stock_equipo_id' => $equipoAsignado->stock_equipos_id
    ]);

    $validator = Validator::make($request->all(), [
        'usuarios_id' => 'required|exists:usuarios,id',
        'stock_equipos_id' => 'required|exists:stock_equipos,id',
        'fecha_asignacion' => 'required|date',
        'ip_equipo' => 'nullable|ip',
        'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_asignacion',
        'observaciones' => 'nullable|string|max:500',
        'estado' => 'required|in:activo,devuelto,obsoleto'
    ]);

    if ($validator->fails()) {
        \Log::error('Errores de validación:', $validator->errors()->toArray());
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $stockEquipo = stock_equipos::find($equipoAsignado->stock_equipos_id);
    $nuevoEstado = $request->estado;
    $estadoAnterior = $equipoAsignado->estado;

    \Log::info('Gestión de stock:', [
        'estado_anterior' => $estadoAnterior,
        'nuevo_estado' => $nuevoEstado,
        'stock_equipo_id' => $stockEquipo->id ?? 'No encontrado'
    ]);

    // CASO 1: Cambio de "devuelto" a "activo" 
    if ($estadoAnterior == 'devuelto' && $nuevoEstado == 'activo') {
        \Log::info('Cambio de DEVUELTO a ACTIVO - restando del stock');
        if ($stockEquipo && $stockEquipo->cantidad_disponible > 0) {
            $stockEquipo->decrement('cantidad_disponible');
            $stockEquipo->increment('cantidad_asignada');
            \Log::info('Stock actualizado - restado:', [
                'nueva_cantidad_disponible' => $stockEquipo->cantidad_disponible,
                'nueva_cantidad_asignada' => $stockEquipo->cantidad_asignada
            ]);
        } else {
            \Log::error('No hay stock disponible para reactivar la asignación');
            return redirect()->back()
                ->with('error', 'No hay stock disponible para reactivar esta asignación.')
                ->withInput();
        }
    }
    
    // CASO 2: Cambio de "activo" a "devuelto" 
    elseif ($estadoAnterior == 'activo' && $nuevoEstado == 'devuelto') {
        \Log::info('Cambio de ACTIVO a DEVUELTO - sumando al stock');
        if ($stockEquipo) {
            $stockEquipo->increment('cantidad_disponible');
            $stockEquipo->decrement('cantidad_asignada');
            \Log::info('Stock actualizado - sumado:', [
                'nueva_cantidad_disponible' => $stockEquipo->cantidad_disponible,
                'nueva_cantidad_asignada' => $stockEquipo->cantidad_asignada
            ]);
        }
    }

    // CASO 3: Si se cambia el equipo asignado
    if ($equipoAsignado->stock_equipos_id != $request->stock_equipos_id) {
        \Log::info('Cambio de equipo asignado:', [
            'equipo_anterior' => $equipoAsignado->stock_equipos_id,
            'equipo_nuevo' => $request->stock_equipos_id
        ]);

        // Liberar el equipo anterior
        if ($estadoAnterior == 'activo') {
            $equipoAnterior = stock_equipos::find($equipoAsignado->stock_equipos_id);
            if ($equipoAnterior) {
                $equipoAnterior->increment('cantidad_disponible');
                $equipoAnterior->decrement('cantidad_asignada');
                \Log::info('Equipo anterior liberado:', [
                    'equipo_id' => $equipoAnterior->id,
                    'nueva_cantidad_disponible' => $equipoAnterior->cantidad_disponible
                ]);
            }
        }

        // Asignar el nuevo equipo
        if ($nuevoEstado == 'activo') {
            $nuevoEquipo = stock_equipos::find($request->stock_equipos_id);
            if ($nuevoEquipo && $nuevoEquipo->cantidad_disponible > 0) {
                $nuevoEquipo->decrement('cantidad_disponible');
                $nuevoEquipo->increment('cantidad_asignada');
                \Log::info('Nuevo equipo asignado:', [
                    'equipo_id' => $nuevoEquipo->id,
                    'nueva_cantidad_disponible' => $nuevoEquipo->cantidad_disponible
                ]);
            } else {
                \Log::error('No hay stock disponible en el nuevo equipo');
                return redirect()->back()
                    ->with('error', 'El nuevo equipo seleccionado no tiene stock disponible.')
                    ->withInput();
            }
        }
    }

    // Actualizar la asignación
    $updated = $equipoAsignado->update([
        'usuarios_id' => $request->usuarios_id,
        'stock_equipos_id' => $request->stock_equipos_id,
        'fecha_asignacion' => $request->fecha_asignacion,
        'ip_equipo' => $request->ip_equipo,
        'fecha_devolucion' => $request->fecha_devolucion,
        'observaciones' => $request->observaciones,
        'estado' => $request->estado
    ]);

    \Log::info('Resultado de update:', ['updated' => $updated]);
    
    if ($updated) {
        \Log::info('Actualización exitosa');
        return redirect()->route('equipos_asignados.index')
            ->with('success', 'Asignación actualizada exitosamente.');
    } else {
        \Log::error('Error en la actualización');
        return redirect()->back()
            ->with('error', 'Error al actualizar la asignación.')
            ->withInput();
    }
}


    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id) 
{
    \Log::info('=== INICIANDO ELIMINACIÓN ===');
    \Log::info('ID recibido:', ['id' => $id]);

    // Buscar manualmente el equipo asignado
    $equipoAsignado = EquipoAsignado::find($id);
    
    if (!$equipoAsignado) {
        \Log::error('Equipo asignado no encontrado', ['id' => $id]);
        return redirect()->route('equipos_asignados.index')
            ->with('error', 'Asignación no encontrada.');
    }

    \Log::info('Equipo encontrado para eliminar:', [
        'id' => $equipoAsignado->id, 
        'estado' => $equipoAsignado->estado,
        'usuario' => $equipoAsignado->usuarios_id,
        'equipo' => $equipoAsignado->stock_equipos_id
    ]);

    if ($equipoAsignado->estado == 'obsoleto') {
        \Log::error('No se puede eliminar equipo obsoleto');
        return redirect()->route('equipos_asignados.index')
            ->with('error', 'No se puede eliminar un equipo marcado como obsoleto.');
    }

    // Si la asignación no está devuelta, actualizar el stock
    if ($equipoAsignado->estado != 'devuelto') {
        $stockEquipo = stock_equipos::find($equipoAsignado->stock_equipos_id);
        if ($stockEquipo) {
            $stockEquipo->increment('cantidad_disponible');
            $stockEquipo->decrement('cantidad_asignada');
            \Log::info('Stock actualizado:', [
                'equipo_id' => $stockEquipo->id,
                'nueva_cantidad_disponible' => $stockEquipo->cantidad_disponible,
                'nueva_cantidad_asignada' => $stockEquipo->cantidad_asignada
            ]);
        }
    }

    // Eliminar la asignación
    $deleted = $equipoAsignado->delete();
    
    \Log::info('Resultado de eliminación:', ['deleted' => $deleted]);

    if ($deleted) {
        \Log::info('Eliminación exitosa');
        return redirect()->route('equipos_asignados.index')
            ->with('success', 'Asignación eliminada exitosamente.');
    } else {
        \Log::error('Error en la eliminación');
        return redirect()->route('equipos_asignados.index')
            ->with('error', 'Error al eliminar la asignación.');
    }
}

   
    public function devolver(EquipoAsignado $equipoAsignado)
    {
        if ($equipoAsignado->estado == 'devuelto') {
            return redirect()->back()->with('error', 'El equipo ya fue devuelto anteriormente.');
        }

        if ($equipoAsignado->estado == 'obsoleto') {
            return redirect()->back()->with('error', 'No se puede devolver un equipo obsoleto.');
        }

        $equipoAsignado->update([
            'estado' => 'devuelto',
            'fecha_devolucion' => now()
        ]);

        // Actualizar stock
        $stockEquipo = stock_equipos::find($equipoAsignado->stock_equipos_id);
        if ($stockEquipo) {
            $stockEquipo->increment('cantidad_disponible');
            $stockEquipo->decrement('cantidad_asignada');
        }

        return redirect()->route('equipos_asignados.index')
            ->with('success', 'Equipo devuelto exitosamente.');
    }


    public function marcarObsoleto(EquipoAsignado $equipoAsignado)
    {
        if ($equipoAsignado->estado == 'obsoleto') {
            return redirect()->back()->with('error', 'El equipo ya está marcado como obsoleto.');
        }

        $equipoAsignado->update([
            'estado' => 'obsoleto',
            'fecha_devolucion' => now()
        ]);

        // Actualizar stock - disminuir disponible, asignada y total
        $stockEquipo = stock_equipos::find($equipoAsignado->stock_equipos_id);
        if ($stockEquipo) {
            $stockEquipo->decrement('cantidad_disponible');
            $stockEquipo->decrement('cantidad_asignada');
            $stockEquipo->decrement('cantidad_total');
        }

        return redirect()->route('equipos_asignados.index')
            ->with('success', 'Equipo marcado como obsoleto exitosamente.');
    }

    /**
     * Obtener equipos asignados por usuario
     */
    public function porUsuario($usuarioId)
    {
        $equiposAsignados = EquipoAsignado::with(['stock_equipo.tipo_equipo', 'usuario'])
            ->where('usuarios_id', $usuarioId)
            ->get();

        return response()->json($equiposAsignados);
    }

    /**
     * Obtener historial de equipos por stock
     */
    public function porStock($stockId)
    {
        $historial = EquipoAsignado::with(['usuarios', 'usuario'])
            ->where('stock_equipos_id', $stockId)
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return response()->json($historial);
    }

    /**
     * Reporte de equipos asignados
     */
    public function reporte(Request $request)
    {
        $query = EquipoAsignado::with(['usuarios', 'stock_equipo.tipo_equipo']);

        // Filtros
        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('fecha_desde') && $request->fecha_desde) {
            $query->where('fecha_asignacion', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta) {
            $query->where('fecha_asignacion', '<=', $request->fecha_hasta);
        }

        $equiposAsignados = $query->get();

        return view('equipos_asignados.reporte', compact('equiposAsignados'));
    }

    /**
     * API: Obtener todas las asignaciones
     */
    public function apiIndex()
    {
        $equiposAsignados = EquipoAsignado::with([
            'usuarios', 
            'usuario', 
            'stock_equipo.tipo_equipo'
        ])->get();

        return response()->json($equiposAsignados);
    }

    /**
     * API: Obtener una asignación específica
     */
    public function apiShow($id)
    {
        $equipoAsignado = EquipoAsignado::with([
            'usuarios.sede',
            'usuarios.departamento',
            'usuario',
            'stock_equipo.tipo_equipo'
        ])->find($id);

        if (!$equipoAsignado) {
            return response()->json(['error' => 'Asignación no encontrada'], 404);
        }

        return response()->json($equipoAsignado);
    }

    /**
     * Estadísticas de asignaciones
     */
    public function estadisticas()
    {
        $totalAsignaciones = EquipoAsignado::count();
        $asignacionesActivas = EquipoAsignado::whereIn('estado', ['activo', 'en_uso'])->count();
        $asignacionesDevueltas = EquipoAsignado::where('estado', 'devuelto')->count();
        $asignacionesObsoletas = EquipoAsignado::where('estado', 'obsoleto')->count();
        
        $asignacionesPorEstado = EquipoAsignado::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get();

        $asignacionesPorMes = EquipoAsignado::selectRaw('YEAR(fecha_asignacion) as año, MONTH(fecha_asignacion) as mes, COUNT(*) as total')
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return response()->json([
            'total_asignaciones' => $totalAsignaciones,
            'asignaciones_activas' => $asignacionesActivas,
            'asignaciones_devueltas' => $asignacionesDevueltas,
            'asignaciones_obsoletas' => $asignacionesObsoletas,
            'asignaciones_por_estado' => $asignacionesPorEstado,
            'asignaciones_por_mes' => $asignacionesPorMes
        ]);
    }

        public function generarPdfAsignaciones()
    {
        try {
            $equiposAsignados = EquipoAsignado::with([
                'usuarios.sede', 
                'usuarios.departamento', 
                'usuario', 
                'stock_equipo.tipoEquipo'
            ])
            ->orderBy('estado')
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

            $totalAsignaciones = $equiposAsignados->count();
            $asignacionesActivas = $equiposAsignados->where('estado', 'activo')->count();
            $asignacionesDevueltas = $equiposAsignados->where('estado', 'devuelto')->count();
            $asignacionesObsoletas = $equiposAsignados->where('estado', 'obsoleto')->count();

            $asignacionesPorTipo = [];
            foreach ($equiposAsignados as $asignacion) {
                $tipoNombre = $asignacion->stock_equipo->tipoEquipo->nombre ?? 'Sin tipo';
                if (!isset($asignacionesPorTipo[$tipoNombre])) {
                    $asignacionesPorTipo[$tipoNombre] = 0;
                }
                $asignacionesPorTipo[$tipoNombre]++;
            }

            $data = [
                'equiposAsignados' => $equiposAsignados,
                'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
                'totalAsignaciones' => $totalAsignaciones,
                'asignacionesActivas' => $asignacionesActivas,
                'asignacionesDevueltas' => $asignacionesDevueltas,
                'asignacionesObsoletas' => $asignacionesObsoletas,
                'asignacionesPorTipo' => $asignacionesPorTipo
            ];

            $pdf = PDF::loadView('equipoA.pdf', $data)
                     ->setPaper('A4', 'landscape')
                     ->setOption('defaultFont', 'sans-serif');

            return $pdf->download('Reporte Equipos Asignados - ' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Error generando PDF de asignaciones: ' . $e->getMessage());
            return redirect()->route('equipos_asignados.index')
                           ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Ver PDF de asignaciones 
     */
    public function verPdfAsignaciones()
    {
        try {
            $equiposAsignados = EquipoAsignado::with([
                'usuarios.sede', 
                'usuarios.departamento', 
                'usuario', 
                'stock_equipo.tipoEquipo'
            ])
            ->orderBy('estado')
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

            $totalAsignaciones = $equiposAsignados->count();
            $asignacionesActivas = $equiposAsignados->where('estado', 'activo')->count();
            $asignacionesDevueltas = $equiposAsignados->where('estado', 'devuelto')->count();
            $asignacionesObsoletas = $equiposAsignados->where('estado', 'obsoleto')->count();

            $asignacionesPorTipo = [];
            foreach ($equiposAsignados as $asignacion) {
                $tipoNombre = $asignacion->stock_equipo->tipoEquipo->nombre ?? 'Sin tipo';
                if (!isset($asignacionesPorTipo[$tipoNombre])) {
                    $asignacionesPorTipo[$tipoNombre] = 0;
                }
                $asignacionesPorTipo[$tipoNombre]++;
            }

            $data = [
                'equiposAsignados' => $equiposAsignados,
                'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
                'totalAsignaciones' => $totalAsignaciones,
                'asignacionesActivas' => $asignacionesActivas,
                'asignacionesDevueltas' => $asignacionesDevueltas,
                'asignacionesObsoletas' => $asignacionesObsoletas,
                'asignacionesPorTipo' => $asignacionesPorTipo
            ];

            $pdf = PDF::loadView('equipoA.pdf', $data)
                     ->setPaper('A4', 'landscape')
                     ->setOption('defaultFont', 'sans-serif');

            return $pdf->stream('Reporte Equipos Asignados - ' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Error viendo PDF de asignaciones: ' . $e->getMessage());
            return redirect()->route('equipos_asignados.index')
                           ->with('error', 'Error al cargar el PDF: ' . $e->getMessage());
        }
    }

    /**
 * Generar PDF de equipos asignados por usuario
 */
public function generarPdfPorUsuario($usuarioId)
{
    try {
        $usuario = Usuarios::with(['sede', 'departamento'])->find($usuarioId);
        
        if (!$usuario) {
            return redirect()->route('equipos_asignados.index')
                ->with('error', 'Usuario no encontrado.');
        }

        $equiposAsignados = EquipoAsignado::with([
            'stock_equipo.tipoEquipo',
            'usuario'
        ])
        ->where('usuarios_id', $usuarioId)
        ->orderBy('estado')
        ->orderBy('fecha_asignacion', 'desc')
        ->get();

        $totalEquipos = $equiposAsignados->count();
        $equiposActivos = $equiposAsignados->where('estado', 'activo')->count();
        $equiposDevueltos = $equiposAsignados->where('estado', 'devuelto')->count();
        $equiposObsoletos = $equiposAsignados->where('estado', 'obsoleto')->count();

        $data = [
            'usuario' => $usuario,
            'equiposAsignados' => $equiposAsignados,
            'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
            'totalEquipos' => $totalEquipos,
            'equiposActivos' => $equiposActivos,
            'equiposDevueltos' => $equiposDevueltos,
            'equiposObsoletos' => $equiposObsoletos,
        ];

        $pdf = PDF::loadView('equipoA.pdf-usuario', $data)
                 ->setPaper('A4', 'portrait')
                 ->setOption('defaultFont', 'sans-serif');

        $nombreArchivo = 'Equipos_Asignados_' . str_replace(' ', '_', $usuario->nombre) . '_' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf';

        return $pdf->download($nombreArchivo);

    } catch (\Exception $e) {
        \Log::error('Error generando PDF por usuario: ' . $e->getMessage());
        return redirect()->route('equipos_asignados.index')
                       ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

/**
 * Ver PDF de equipos por usuario 
 */
public function verPdfPorUsuario($usuarioId)
{
    try {
        $usuario = Usuarios::with(['sede', 'departamento'])->find($usuarioId);
        
        if (!$usuario) {
            return redirect()->route('equipos_asignados.index')
                ->with('error', 'Usuario no encontrado.');
        }

        $equiposAsignados = EquipoAsignado::with([
            'stock_equipo.tipoEquipo',
            'usuario'
        ])
        ->where('usuarios_id', $usuarioId)
        ->orderBy('estado')
        ->orderBy('fecha_asignacion', 'desc')
        ->get();

        $totalEquipos = $equiposAsignados->count();
        $equiposActivos = $equiposAsignados->where('estado', 'activo')->count();
        $equiposDevueltos = $equiposAsignados->where('estado', 'devuelto')->count();
        $equiposObsoletos = $equiposAsignados->where('estado', 'obsoleto')->count();

        $data = [
            'usuario' => $usuario,
            'equiposAsignados' => $equiposAsignados,
            'fechaGeneracion' => now()->timezone('America/Caracas')->format('d/m/Y H:i:s'),
            'totalEquipos' => $totalEquipos,
            'equiposActivos' => $equiposActivos,
            'equiposDevueltos' => $equiposDevueltos,
            'equiposObsoletos' => $equiposObsoletos,
        ];

        $pdf = PDF::loadView('equipoA.pdf-usuario', $data)
                 ->setPaper('A4', 'portrait')
                 ->setOption('defaultFont', 'sans-serif');

        $nombreArchivo = 'Equipos_Asignados_' . str_replace(' ', '_', $usuario->nombre) . '_' . now()->timezone('America/Caracas')->format('Y-m-d') . '.pdf';

        return $pdf->stream($nombreArchivo);

    } catch (\Exception $e) {
        \Log::error('Error viendo PDF por usuario: ' . $e->getMessage());
        return redirect()->route('equipos_asignados.index')
                       ->with('error', 'Error al cargar el PDF: ' . $e->getMessage());
    }
}
}
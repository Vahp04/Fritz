<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\sede;
use App\Models\departamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $usuarios = Usuarios::with(['sede', 'departamento', 'equiposAsignados'])
                           ->withCount([
                               'equiposAsignados as equipos_totales_count',
                               'equiposAsignadosActivos as equipos_activos_count',
                               'equiposAsignadosDevueltos as equipos_devueltos_count'
                           ])
                           ->orderBy('id', 'asc') 
                           ->paginate(10); 
    
    $sedes = Sede::all();
    $departamentos = Departamento::all();

    
    
    return view('usuarios.index', compact('usuarios', 'sedes', 'departamentos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sedes = Sede::all();
        $departamentos = Departamento::all();
        return view('usuarios.create', compact('sedes', 'departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios',
            'RDP' => 'required|string|max:255|unique:usuarios',
            'sede_id' => 'required|exists:sedes,id',
            'departamento_id' => 'required|exists:departamentos,id'
        ]);

        Usuarios::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cargo' => $request->cargo,
            'correo' => $request->correo,
            'RDP' => $request->RDP,
            'sede_id' => $request->sede_id,
            'departamento_id' => $request->departamento_id
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
public function show($id)
{
    $usuario = Usuarios::with(['sede', 'departamento', 'equiposAsignados'])
                      ->withCount([
                          'equiposAsignados as equipos_totales_count',
                          'equiposAsignadosActivos as equipos_activos_count',
                          'equiposAsignadosDevueltos as equipos_devueltos_count'
                      ])
                      ->findOrFail($id);
    
    return view('usuarios.show', compact('usuario'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $sedes = Sede::all();
        $departamentos = Departamento::all();
        
        return view('usuarios.edit', compact('usuario', 'sedes', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'RDP' => 'required|string|max:255|unique:usuarios,RDP,' . $usuario->id,
            'sede_id' => 'required|exists:sedes,id',
            'departamento_id' => 'required|exists:departamentos,id'
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cargo' => $request->cargo,
            'correo' => $request->correo,
            'RDP' => $request->RDP,
            'sede_id' => $request->sede_id,
            'departamento_id' => $request->departamento_id
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

public function destroy($id)
{
    $usuario = Usuarios::findOrFail($id);

    if ($usuario->equiposAsignadosActivos()->exists()) {
        return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar el usuario porque tiene equipos activos asignados.');
    }

    $usuario->delete();

    return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
}

    public function getBySede($sedeId)
{
    $usuarios = Usuarios::with(['departamento', 'equiposAsignados'])
                       ->withCount([
                           'equiposAsignados as equipos_totales_count',
                           'equiposAsignadosActivos as equipos_activos_count',
                           'equiposAsignadosDevueltos as equipos_devueltos_count'
                       ])
                       ->where('sede_id', $sedeId)
                       ->get();
    
    return response()->json($usuarios);
}

public function getByDepartamento($departamentoId)
{
    $usuarios = Usuarios::with(['sede', 'equiposAsignados'])
                       ->withCount([
                           'equiposAsignados as equipos_totales_count',
                           'equiposAsignadosActivos as equipos_activos_count',
                           'equiposAsignadosDevueltos as equipos_devueltos_count'
                       ])
                       ->where('departamento_id', $departamentoId)
                       ->get();
    
    return response()->json($usuarios);
}

public function search(Request $request)
{
    $query = $request->get('query');
    
    $usuarios = Usuarios::with(['sede', 'departamento', 'equiposAsignados'])
                ->withCount([
                    'equiposAsignados as equipos_totales_count',
                    'equiposAsignadosActivos as equipos_activos_count',
                    'equiposAsignadosDevueltos as equipos_devueltos_count'
                ])
                ->where('nombre', 'LIKE', "%{$query}%")
                ->orWhere('apellido', 'LIKE', "%{$query}%")
                ->orWhere('cargo', 'LIKE', "%{$query}%")
                ->orWhere('correo', 'LIKE', "%{$query}%")
                ->orWhere('RDP', 'LIKE', "%{$query}%")
                ->get();

    return response()->json($usuarios);
}

    public function getEstadisticas()
    {
        $totalUsuarios = Usuarios::count();
        $usuariosConEquipos = Usuarios::has('equiposAsignados')->count();
        $usuariosSinEquipos = $totalUsuarios - $usuariosConEquipos;
        
        $usuariosPorSede = Usuarios::with('sede')
                                  ->selectRaw('sede_id, COUNT(*) as total')
                                  ->groupBy('sede_id')
                                  ->get();
        
        $usuariosPorDepartamento = Usuarios::with('departamento')
                                          ->selectRaw('departamento_id, COUNT(*) as total')
                                          ->groupBy('departamento_id')
                                          ->get();

        return response()->json([
            'total_usuarios' => $totalUsuarios,
            'usuarios_con_equipos' => $usuariosConEquipos,
            'usuarios_sin_equipos' => $usuariosSinEquipos,
            'usuarios_por_sede' => $usuariosPorSede,
            'usuarios_por_departamento' => $usuariosPorDepartamento
        ]);
    }

public function generarPdf()
{
    \Log::info('=== GENERAR PDF INICIADO ===');
    
    try {
        // Obtener todos los usuarios con relaciones y contadores
        $usuarios = Usuarios::with(['sede', 'departamento'])
                           ->withCount([
                               'equiposAsignados as equipos_totales_count',
                               'equiposAsignadosActivos as equipos_activos_count',
                               'equiposAsignadosDevueltos as equipos_devueltos_count'
                           ])
                           ->get();

        \Log::info('Usuarios encontrados: ' . $usuarios->count());

        $data = [
            'usuarios' => $usuarios, // Esto es una colección, no un array
            'fechaGeneracion' => now()->format('d/m/Y H:i:s'),
            'totalUsuarios' => $usuarios->count(),
            'totalConEquipos' => $usuarios->where('equipos_activos_count', '>', 0)->count(),
            'totalSinEquipos' => $usuarios->where('equipos_activos_count', 0)->count()
        ];

        $pdf = PDF::loadView('usuarios.pdf', $data)
                 ->setPaper('A4', 'landscape')
                 ->setOption('defaultFont', 'sans-serif');

        \Log::info('=== PDF GENERADO EXITOSAMENTE ===');
        return $pdf->download('Reporte de Usuarios - ' . now()->format('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        \Log::error('ERROR generando PDF: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        return redirect()->route('usuarios.index')
                       ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

public function verPdf()
{
    \Log::info('=== VER PDF INICIADO ===');
    
    try {
        // Obtener todos los usuarios con relaciones y contadores
        $usuarios = Usuarios::with(['sede', 'departamento'])
                           ->withCount([
                               'equiposAsignados as equipos_totales_count',
                               'equiposAsignadosActivos as equipos_activos_count',
                               'equiposAsignadosDevueltos as equipos_devueltos_count'
                           ])
                           ->get();

        $data = [
            'usuarios' => $usuarios, // Esto es una colección, no un array
            'fechaGeneracion' => now()->format('d/m/Y H:i:s'),
            'totalUsuarios' => $usuarios->count(),
            'totalConEquipos' => $usuarios->where('equipos_activos_count', '>', 0)->count(),
            'totalSinEquipos' => $usuarios->where('equipos_activos_count', 0)->count()
        ];

        $pdf = PDF::loadView('usuarios.pdf', $data)
                 ->setPaper('A4', 'landscape')
                 ->setOption('defaultFont', 'sans-serif');

        return $pdf->stream('Reporte de Usuarios - ' . now()->format('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        \Log::error('ERROR viendo PDF: ' . $e->getMessage());
        return redirect()->route('usuarios.index')
                       ->with('error', 'Error al cargar el PDF: ' . $e->getMessage());
    }
}
}
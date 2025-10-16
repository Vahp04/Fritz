<?php

namespace App\Http\Controllers;

use App\Models\sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    
    public function index()
    {
        $sedes = sede::withCount('usuarios')->get();
        return view('sede.sede', compact('sedes'));
    }


    public function create()
    {
        return view('sedes.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:sedes',
            'ubicacion' => 'required|string|max:500',
        ]);

        sede::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
        ]);

        return redirect()->route('sedes.index')->with('success', 'Sede creada exitosamente.');
    }


    public function show($id)
    {
        $sede = sede::with('usuarios')->findOrFail($id);
        return view('sedes.show', compact('sede'));
    }


    public function edit($id)
    {
        $sede = sede::findOrFail($id);
        return view('sedes.edit', compact('sede'));
    }

    public function update(Request $request, $id)
    {
        $sede = sede::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:sedes,nombre,' . $sede->id,
            'ubicacion' => 'required|string|max:500',
        ]);

        $sede->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
        ]);

        return redirect()->route('sedes.index')->with('success', 'Sede actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $sede = sede::findOrFail($id);

        if ($sede->usuarios()->exists()) {
            return redirect()->route('sedes.index')->with('error', 'No se puede eliminar la sede porque tiene usuarios asociados.');
        }

        $sede->delete();

        return redirect()->route('sedes.index')->with('success', 'Sede eliminada exitosamente.');
    }


    public function getUsuarios($id)
    {
        $sede = sede::with('usuarios')->findOrFail($id);
        return response()->json([
            'sede' => $sede,
            'usuarios' => $sede->usuarios
        ]);
    }

    public function getEstadisticas()
    {
        $estadisticas = sede::withCount('usuarios')->get();
        
        return response()->json([
            'total_sedes' => $estadisticas->count(),
            'total_usuarios' => $estadisticas->sum('usuarios_count'),
            'sedes' => $estadisticas
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $sedes = sede::where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('ubicacion', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($sedes);
    }
}
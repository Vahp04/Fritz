<?php

namespace App\Http\Controllers;

use App\Models\departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
   
    public function index()
{
 
    $departamentos = Departamento::withCount('usuarios')->get();
    
    return view('departamento.departamento', compact('departamentos'));
}

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:departamentos',
        ]);

        departamento::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
    }

    public function show($id)
    {
        $departamento = departamento::findOrFail($id);
        return view('departamentos.show', compact('departamento'));
    }

    public function edit($id)
    {
        $departamento = departamento::findOrFail($id);
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, $id)
    {
        $departamento = departamento::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:departamentos,nombre,' . $departamento->id,
        ]);

        $departamento->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
    }


    public function destroy($id)
    {
        $departamento = departamento::findOrFail($id);

 
        if ($departamento->usuarios()->exists()) {
            return redirect()->route('departamentos.index')->with('error', 'No se puede eliminar el departamento porque tiene usuarios asociados.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
    }


    public function getUsuarios($id)
    {
        $departamento = departamento::with('usuarios')->findOrFail($id);
        return response()->json([
            'departamento' => $departamento,
            'usuarios' => $departamento->usuarios
        ]);
    }


    public function toggleStatus($id)
    {
        $departamento = departamento::findOrFail($id);
        // Si tu modelo tiene campo 'activo', descomenta esto:
        // $departamento->update(['activo' => !$departamento->activo]);
        
        // $status = $departamento->activo ? 'activado' : 'desactivado';
        // return redirect()->route('departamentos.index')->with('success', "Departamento {$status} exitosamente.");
        
        return redirect()->route('departamentos.index')->with('info', 'Función de activar/desactivar no implementada.');
    }
}
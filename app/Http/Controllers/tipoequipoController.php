<?php

namespace App\Http\Controllers;

use App\Models\tipo_equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        $tiposEquipo = tipo_equipo::withCount('stockEquipo')->get();
        return view('tipo_equipo.tipo_equipo', compact('tiposEquipo'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipo_equipo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipo_equipos',
            'descripcion' => 'nullable|string',
            'requiere_ip' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        tipo_equipo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'requiere_ip' => $request->requiere_ip
        ]);

        return redirect()->route('tipo_equipo.index')
            ->with('success', 'Tipo de equipo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
  public function show(tipo_equipo $tipo_equipo)
    {
        $tipo_equipo->loadCount('stockEquipo');
        return view('tipo_equipo.show', compact('tipo_equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tipo_equipo $tipo_equipo)
    {
        return view('tipo_equipo.edit', compact('tipo_equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
       public function update(Request $request, tipo_equipo $tipo_equipo)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipo_equipos,nombre,' . $tipo_equipo->id,
            'descripcion' => 'nullable|string',
            'requiere_ip' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

         $tipo_equipo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'requiere_ip' => $request->requiere_ip
        ]);

        return redirect()->route('tipo_equipo.index')
            ->with('success', 'Tipo de equipo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
       public function destroy(tipo_equipo $tipo_equipo)
    {
        // Verificar si hay stock_equipos relacionados antes de eliminar
        if ($tipo_equipo->stockEquipo()->count() > 0) {
            return redirect()->route('tipo_equipo.index')
                ->with('error', 'No se puede eliminar el tipo de equipo porque tiene equipos en stock asociados.');
        }

        $tipo_equipo->delete();

        return redirect()->route('tipo_equipo.index')
            ->with('success', 'Tipo de equipo eliminado exitosamente.');
    }

    /**
     * API: Obtener todos los tipos de equipo (para AJAX o APIs)
     */
    public function apiIndex()
    {
        $tiposEquipo = tipo_equipo::all();
        return response()->json($tiposEquipo);
    }

    /**
     * API: Obtener un tipo de equipo específico
     */
    public function apiShow($id)
    {
        $tipoEquipo = tipo_equipo::find($id);
        
        if (!$tipoEquipo) {
            return response()->json(['error' => 'Tipo de equipo no encontrado'], 404);
        }

        return response()->json($tipoEquipo);
    }
}
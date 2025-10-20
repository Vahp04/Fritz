<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuario.usuario', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:usuario,name', 
        'email' => 'required|email|unique:usuario,email', 
        'password' => 'required|min:6|confirmed',
        'activo' => 'boolean'
    ]);

  
    $name = trim($request->name);
    $password = trim($request->password);
    $email = trim($request->email);

    $usuario = Usuario::create([
        'name' => $name,
        'email' => $email,
        'password' => $password, 
        'activo' => true
    ]);

    return redirect()->route('usuario.index')->with('success', 'Usuario creado exitosamente.');
}

public function update(Request $request, $id)
{
    $usuario = Usuario::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:usuario,name,' . $usuario->id,
        'email' => 'required|email|unique:usuario,email,' . $usuario->id,
        'password' => 'nullable|min:6|confirmed',
        'activo' => 'boolean'
    ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'activo' => $request->activo ?? $usuario->activo
        ];


        if ($request->password) {
            $data['password'] = $request->password;
        }

        $usuario->update($data);

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // No permitir eliminar al usuario actual
        if (Auth::id() == $id) {
            return redirect()->route('usuario.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Activar/Desactivar usuario
     */
    public function toggleStatus($id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('usuario.index')->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->update(['activo' => !$usuario->activo]);

        $status = $usuario->activo ? 'activado' : 'desactivado';
        return redirect()->route('usuario.index')->with('success', "Usuario {$status} exitosamente.");
    }
}
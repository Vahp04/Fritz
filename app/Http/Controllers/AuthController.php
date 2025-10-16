<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Usuarios;
use App\Models\Sede;
use App\Models\Departamento;
use App\Models\EquipoAsignado; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('login.login');
    }


public function login(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'password' => 'required|min:6'
    ]);

    $name = trim($request->name);
    $password = trim($request->password);

    $usuario = Usuario::where('name', $name)->first();

    if ($usuario && $password === $usuario->password) {
        
        if (!$usuario->activo) {
            return back()->withErrors([
                'name' => 'Tu cuenta está desactivada. Contacta al administrador.'
            ]);
        }
        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'name' => 'Las credenciales no coinciden con nuestros registros.'
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function dashboard()
    {
 
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'message' => 'Por favor inicia sesión para acceder al dashboard.'
            ]);
        }
        
    
        $usuario = Auth::user();
        

        $totalUsuarios = Usuarios::count();
        $totalSedes = Sede::count();
        $totalDepartamentos = Departamento::count();
        $totalEquiposAsignados = EquipoAsignado::where('estado', 'activo')->count();

        \Log::info('Dashboard accessed by user:', [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email,
            'stats' => [
                'usuarios' => $totalUsuarios,
                'sedes' => $totalSedes,
                'departamentos' => $totalDepartamentos,
                'equipos' => $totalEquiposAsignados
            ]
        ]);
        
        return view('dashboard.index', compact(
            'usuario',
            'totalUsuarios',
            'totalSedes', 
            'totalDepartamentos',
            'totalEquiposAsignados'
        ));
    }

    
}
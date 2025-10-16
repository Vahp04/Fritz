<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'correo',
        'RDP',
        'sede_id',
        'departamento_id'
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }


    public function equiposAsignados()
    {
        return $this->hasMany(EquipoAsignado::class, 'usuarios_id');
    }

      // SOLO equipos ACTIVOS (no devueltos ni obsoletos)
    public function equiposAsignadosActivos()
    {
        return $this->hasMany(EquipoAsignado::class, 'usuarios_id')
                    ->where('estado', 'activo');
    }

    // Equipos DEVUELTOS
    public function equiposAsignadosDevueltos()
    {
        return $this->hasMany(EquipoAsignado::class, 'usuarios_id')
                    ->where('estado', 'devuelto');
    }

    public function asignacionesRealizadas()
    {
        return $this->hasMany(EquipoAsignado::class, 'usuario_id');
    }
}
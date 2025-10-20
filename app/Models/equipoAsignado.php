<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoAsignado extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuarios_id',
        'stock_equipos_id',
        'fecha_asignacion',
        'ip_equipo',
        'fecha_devolucion',
        'observaciones',
        'usuario_id',
        'estado'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_devolucion' => 'datetime'
    ];

      // Relación con el usuario asignado (Usuarios)
    public function usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'usuarios_id');
    }

    // Relación con el usuario que realizó la asignación (Usuario - auth)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con el equipo en stock
    public function stock_equipo()
    {
        return $this->belongsTo(stock_equipos::class, 'stock_equipos_id');
    }

    // Alias para compatibilidad con la vista
    public function usuarioAsignado()
    {
        return $this->belongsTo(Usuarios::class, 'usuarios_id');
    }

    public function usuarioAsignador()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function stockEquipo()
    {
        return $this->belongsTo(stock_equipos::class, 'stock_equipos_id');
    }
}

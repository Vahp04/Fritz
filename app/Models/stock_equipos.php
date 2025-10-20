<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_equipos extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_equipo_id',
        'marca',
        'modelo',
        'descripcion',
        'cantidad_total',
        'cantidad_disponible',
        'cantidad_asignada',
        'minimo_stock',
        'fecha_adquisicion',
        'valor_adquisicion',
    ];

    protected $casts = [

        'fecha_adquisicion'=> 'date',
        'valor_adquisicion'=> 'decimal:2'
    ];

    public function tipoEquipo(){
       return $this->belongsTo(tipo_equipo::class, 'tipo_equipo_id');
    }

    public function asignaciones(){
        return $this->hasMany(EquipoAsignado::class);
    }
}

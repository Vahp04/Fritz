<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_equipo extends Model
{
   use HasFactory;

   protected $fillable = [
    'nombre',
    'descripcion',
    'requiere_ip',
   
   ];
   protected $casts = [
        'requiere_ip' => 'boolean' 
    ];
   public function stockEquipo(){
    return $this->hasMany(stock_equipos::class, 'tipo_equipo_id');
   }
}

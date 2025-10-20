<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_equipo extends Model
{
   use HasFactory;

   protected $fillable = [
    'nombre',
    'descripcion'
   ];
   public function stockEquipo(){
    return $this->hasMany(stock_equipos::class);
   }
}

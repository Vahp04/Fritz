<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'nombre'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class);
    }
}

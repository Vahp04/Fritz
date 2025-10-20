<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cargo');
            $table->string('correo');
            $table->string('RDP');
            $table->timestamps();
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['sede_id']);
            $table->dropForeign(['departamento_id']);
            
             $table->dropColumn(['nombre', 'apellido', 'cargo', 'correo', 'RDP', 'sede_id', 'departamento_id']);
        });
    }
};

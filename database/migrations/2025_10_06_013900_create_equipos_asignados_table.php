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
        Schema::create('equipos_asignados', function (Blueprint $table) {
                  $table->id();
            $table->foreignId('usuarios_id')
                  ->constrained('usuarios')
                  ->onDelete('cascade');
            $table->foreignId('stock_equipo_id')
                  ->constrained('stock_equipos')
                  ->onDelete('cascade');
            $table->dateTime('fecha_asignacion');
            $table->dateTime('fecha_devolucion')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('usuario_id')
                  ->constrained('usuario')
                  ->onDelete('cascade');
            $table->enum('estado', ['activo', 'devuelto', 'perdido'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos_asignados');
    }
};

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
        Schema::create('stock_equipos', function (Blueprint $table) {
             $table->id();
            $table->foreignId('tipo_equipo_id')
                  ->constrained('tipo_equipos')
                  ->onDelete('cascade');
            $table->string('marca');
            $table->string('modelo');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad_total')->default(0);
            $table->integer('cantidad_disponible')->default(0);
            $table->integer('cantidad_asignada')->default(0);
            $table->integer('minimo_stock')->default(0);
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('valor_adquisicion', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_equipos');
    }
};

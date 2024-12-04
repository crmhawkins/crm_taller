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
        Schema::create('reservas_coche', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coche_sustitucion_id')->nullable();
            $table->foreign('coche_sustitucion_id')->references('id')->on('coches_sustitucion');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas_coche');
    }
};

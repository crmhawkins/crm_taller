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
        Schema::create('piezas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo');
            $table->string('fabricante');
            $table->string('foto')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('nota')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('suppliers');
            $table->string('numero_serie')->nullable();
            //categoria
            $table->unsignedBigInteger('categoria_id')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};

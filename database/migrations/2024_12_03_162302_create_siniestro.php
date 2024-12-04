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
        Schema::create('siniestro', function (Blueprint $table) {
            $table->id();
            $table->string('identificador')->nullable();
            //fecha del siniestro
            $table->date('fecha')->nullable();
            $table->string('poliza')->nullable();
            $table->unsignedBigInteger('coche_id')->nullable();
            $table->foreign('coche_id')->references('id')->on('coches');
            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clients');
            //descripcion del siniestro
            $table->text('descripcion')->nullable();
            //daños
            $table->text('daños')->nullable();
            //Estado del siniestro
            //coste reparacion
            $table->decimal('coste_reparacion', 10, 2)->nullable();
            //fecha de reparacion
            $table->date('inicio_reparacion')->nullable();
            $table->date('fin_reparacion')->nullable();

            //monto a cargo de la aseguradora
            $table->decimal('monto_aseguradora', 10, 2)->nullable();
            //monto a cargo del cliente
            $table->decimal('monto_cliente', 10, 2)->nullable();

            //comentarios
            $table->text('comentarios')->nullable();

            //prioridad
            $table->string('prioridad')->nullable();

            //tipo de siniestro

            //softdelete
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniestro');
    }
};

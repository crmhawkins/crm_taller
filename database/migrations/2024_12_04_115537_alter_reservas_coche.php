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
        //add column km_actual
        Schema::table('reservas_coche', function (Blueprint $table) {
            $table->integer('km_actual')->nullable();
            //km entregado
            $table->integer('km_entregado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas_coche', function (Blueprint $table) {
            $table->dropColumn('km_actual');
            $table->dropColumn('km_entregado');
        });
    }
};

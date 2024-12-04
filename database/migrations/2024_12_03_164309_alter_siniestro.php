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
        Schema::table('siniestro', function (Blueprint $table) {
            $table->unsignedBigInteger('seguro_id')->nullable();
            $table->foreign('seguro_id')->references('id')->on('seguros');
            $table->unsignedBigInteger('tipo_siniestro_id')->nullable();
            $table->foreign('tipo_siniestro_id')->references('id')->on('tipo_siniestro');
            $table->unsignedBigInteger('estado_siniestro_id')->nullable();
            $table->foreign('estado_siniestro_id')->references('id')->on('estados_siniestro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siniestro', function (Blueprint $table) {
            $table->dropForeign(['seguro_id']);
            $table->dropColumn('seguro_id');
            $table->dropForeign(['tipo_siniestro_id']);
            $table->dropColumn('tipo_siniestro_id');
            $table->dropForeign(['estado_siniestro_id']);
            $table->dropColumn('estado_siniestro_id');
        });
    }
};

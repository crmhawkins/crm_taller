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
        //add column siniestro_id to budgets table
        Schema::table('budgets', function (Blueprint $table) {
            $table->unsignedBigInteger('siniestro_id')->nullable();
            $table->foreign('siniestro_id')->references('id')->on('siniestro');
            //add visita_id to budgets table
            $table->unsignedBigInteger('visita_id')->nullable();
            $table->foreign('visita_id')->references('id')->on('visita_coche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['siniestro_id']);
            $table->dropColumn('siniestro_id');
            $table->dropForeign(['visita_id']);
            $table->dropColumn('visita_id');
        });
    }
};

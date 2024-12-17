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
        //add column pieza_id to budget_concepts
        Schema::table('budget_concepts', function (Blueprint $table) {
            $table->unsignedBigInteger('pieza_id')->nullable();
            $table->foreign('pieza_id')->references('id')->on('piezas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop column pieza_id from budget_concepts
        Schema::table('budget_concepts', function (Blueprint $table) {
            $table->dropColumn('pieza_id');
        });
    }
};

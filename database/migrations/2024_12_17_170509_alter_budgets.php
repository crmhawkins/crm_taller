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
        //add column km_coche
        Schema::table('budgets', function (Blueprint $table) {
            $table->integer('km_coche')->nullable();
            $table->unsignedBigInteger('coche_id')->nullable();
            $table->foreign('coche_id')->references('id')->on('coches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('km_coche');
            $table->dropColumn('coche_id');
        });
    }
};

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
        //add column firma to budgets table
        Schema::table('budgets', function (Blueprint $table) {
            $table->text('firma')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop column firma
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('firma');
        });
    }
};

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
        //alter table appointments add column client_id int
        Schema::table('appointments', function (Blueprint $table) {
            //add column estado
            $table->string('estado')->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};

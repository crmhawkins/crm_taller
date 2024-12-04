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
        //alter table siniestro add column peritaje boolean

        Schema::table('siniestro', function (Blueprint $table) {
            $table->boolean('peritaje')->default(false);
            //peritaje externo o interno
            $table->boolean('peritaje_externo')->default(false);

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop column peritaje
        Schema::table('siniestro', function (Blueprint $table) {
            $table->dropColumn('peritaje');
            $table->dropColumn('peritaje_externo');
        });
    }
};

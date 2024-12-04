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
        Schema::create('coches_sustitucion', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->string('seguro')->nullable();
            $table->string('marca')->nullable();
            $table->string('vin')->nullable();
            $table->string('modelo')->nullable();
            $table->integer('kilometraje')->nullable();
            $table->string('color')->nullable();
            $table->year('anio')->nullable();

            // Use soft delete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coches_sustitucion');
    }
};

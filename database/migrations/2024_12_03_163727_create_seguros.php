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
        Schema::create('seguros', function (Blueprint $table) {
            $table->id();
            //identificador del seguro
            $table->string('identificador')->nullable();
            //aseguradora
            $table->string('aseguradora')->nullable();
            //responsable
            $table->string('responsable')->nullable();
            //telefono
            $table->string('telefono')->nullable();
            //notas
            $table->text('notas')->nullable();
            //precio
            $table->decimal('precio', 10, 2)->default(0);
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
        Schema::dropIfExists('seguros');
    }
};

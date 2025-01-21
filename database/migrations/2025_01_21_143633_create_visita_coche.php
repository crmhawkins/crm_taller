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
        Schema::create('visita_coche', function (Blueprint $table) {
            $table->id();
            //coche id
            $table->unsignedBigInteger('coche_id');
            $table->foreign('coche_id')->references('id')->on('coches');
            //fecha ingreso
            $table->date('fecha_ingreso')->nullable();
            //fecha salida
            $table->date('fecha_salida')->nullable();
            //kilometraje
            $table->integer('kilometraje')->nullable();
            //color
            $table->string('color')->nullable();
            //boolean ingreso en grua
            $table->boolean('ingreso_grua')->default(false);
            //trabajo a realizar
            $table->text('trabajo_a_realizar')->nullable();
            //trabajo realizado
            $table->text('observaciones')->nullable();
            //boolean airbag
            $table->boolean('airbag')->default(false);
            //boolean motor
            $table->boolean('motor')->default(false);
            //boolean abs
            $table->boolean('abs')->default(false);
            //boolean aceite
            $table->boolean('aceite')->default(false);
            //boolean batería
            $table->boolean('bateria')->default(false);
            //boolean cinturon
            $table->boolean('cinturon')->default(false);
            //boolean parking
            $table->boolean('parking')->default(false);
            //boolean luces
            $table->boolean('luces')->default(false);
            //boolean neumaticos
            $table->boolean('neumaticos')->default(false);
            //boolean temperatura
            $table->boolean('temperatura')->default(false);

            //inventario

            //boolean Gato
            $table->boolean('gato')->default(false);

            //boolean Herramientas
            $table->boolean('herramientas')->default(false);

            //boolean triángulos
            $table->boolean('triangulos')->default(false);

            //boolean tapas
            $table->boolean('tapas')->default(false);

            //boolean llanta
            $table->boolean('llanta')->default(false);

            //boolean extintor
            $table->boolean('extintor')->default(false);

            //boolean antena
            $table->boolean('antena')->default(false);

            //boolean emblemas
            $table->boolean('emblemas')->default(false);

            //boolean tapones
            $table->boolean('tapones')->default(false);

            //boolean cables
            $table->boolean('cables')->default(false);

            //boolean radio
            $table->boolean('radio')->default(false);

            //boolean encendedor
            $table->boolean('encendedor')->default(false);

            //nivel de gasolina en porcentaje
            $table->integer('nivel_gasolina')->nullable();

            //foto daños
            $table->text('foto_daños')->nullable();


            //soft delete
            $table->softDeletes();

            //timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visita_coche');
    }
};

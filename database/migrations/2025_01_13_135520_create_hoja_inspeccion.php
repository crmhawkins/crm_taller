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
        Schema::create('hoja_inspeccion', function (Blueprint $table) {
            $table->id();
            //fecha
            $table->date('fecha')->nullable();
            //matricula
            $table->string('matricula')->nullable();
            //coche id
            $table->foreignId('coche_id')->constrained('coches');
            //nivel aceite num 1 2 o 3
            $table->integer('nivel_aceite')->nullable();
            //observaciones aceite
            $table->text('observaciones_aceite')->nullable();
            
            //nivel liquido refrigerante
            $table->integer('nivel_liquido_refrigerante')->nullable();
            //observaciones liquido refrigerante
            $table->text('observaciones_liquido_refrigerante')->nullable();

            //nivel liquido frenos y embrague
            $table->integer('nivel_liquido_frenos_embrague')->nullable();
            //observaciones liquido frenos y embrague
            $table->text('observaciones_liquido_frenos_embrague')->nullable();

            //nivel limpiaparabrisas
            $table->integer('nivel_limpiaparabrisas')->nullable();
            //observaciones limpiaparabrisas
            $table->text('observaciones_nivel_limpiaparabrisas')->nullable();

            //estado correas
            $table->boolean('estado_correas')->nullable();
            //observaciones correas
            $table->text('observaciones_correas')->nullable();

            //intermitente
            $table->boolean('intermitente')->nullable();
            //observaciones intermitente
            $table->text('observaciones_intermitente')->nullable();

            //frenado
            $table->boolean('frenado')->nullable();
            //observaciones frenado
            $table->text('observaciones_frenado')->nullable();

            //marcha atras
            $table->boolean('marcha_atras')->nullable();
            //observaciones marcha atras
            $table->text('observaciones_marcha_atras')->nullable();

            //luces
            $table->boolean('luces')->nullable();
            //observaciones luces
            $table->text('observaciones_luces')->nullable();

            //reglaje faros
            $table->boolean('reglaje_faros')->nullable();
            //observaciones reglaje faros
            $table->text('observaciones_reglaje_faros')->nullable();

            //antinieblas
            $table->boolean('antinieblas')->nullable();
            //observaciones antinieblas
            $table->text('observaciones_antinieblas')->nullable();

            //estado neumaticos
            $table->boolean('estado_neumaticos')->nullable();
            //observaciones estado neumaticos
            $table->text('observaciones_estado_neumaticos')->nullable();

            //presion neumaticos
            $table->boolean('presion_neumaticos')->nullable();
            //observaciones presion neumaticos
            $table->text('observaciones_presion_neumaticos')->nullable();

            //amortiguadores
            $table->boolean('amortiguadores')->nullable();
            //observaciones amortiguadores
            $table->text('observaciones_amortiguadores')->nullable();

            //holguras
            $table->boolean('holguras')->nullable();
            //observaciones holguras
            $table->text('observaciones_holguras')->nullable();

            //desgastes frenos
            $table->boolean('desgastes_frenos')->nullable();
            //observaciones desgastes frenos
            $table->text('observaciones_desgastes_frenos')->nullable();

            //tension freno mano
            $table->boolean('tension_freno_mano')->nullable();
            //observaciones tension freno mano
            $table->text('observaciones_tension_freno_mano')->nullable();

            //fugas
            $table->boolean('fugas')->nullable();
            //observaciones fugas
            $table->text('observaciones_fugas')->nullable();

            //limpiaparabrisas
            $table->boolean('limpiaparabrisas')->nullable();
            //observaciones limpiaparabrisas
            $table->text('observaciones_limpiaparabrisas')->nullable();

            //cinturones de seguridad
            $table->boolean('cinturones_seguridad')->nullable();
            //observaciones cinturones de seguridad
            $table->text('observaciones_cinturones_seguridad')->nullable();

            //firma cliente
            $table->boolean('firma_cliente')->nullable();
            
            //soft delete
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_inspeccion');
    }
};

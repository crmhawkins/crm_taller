@extends('layouts.app')

@section('titulo', 'Editar Hoja de Inspección')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')

<div class="page-heading card" style="box-shadow: none !important">

    {{-- Titulos --}}
    <div class="page-title card-body p-3">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3><i class="bi bi-file-earmark-text"></i> Editar Hoja de Inspección</h3>
                <p class="text-subtitle text-muted">Formulario para editar la hoja de inspección para {{ $coche->matricula }}</p>
            </div>

            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hojas_inspeccion.index', $coche->id) }}">Hojas de Inspección</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form id="formularioInspeccion" action="{{ route('hojas_inspeccion.update', [$coche->id, $hojaInspeccion->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <style>
                        .container {
                            border: 1px solid #000;
                            padding: 15px;
                            border-radius: 20px;
                        }

                        h1{
                            font-size: 20px;
                            font-weight: bold;
                        }

                        .header{
                            margin-bottom: 20px;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        }
                        .header-form{
                            display: flex;
                            flex-direction: row;
                            gap: 10px;
                        }

                        .header-form div{
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            gap: 5px;
                        }

                        table{
                            width: 100%;
                            border-collapse: separate;
                            border-spacing: 0;
                            padding: 10px;

                            border: 1px solid #000;
                            border-radius: 10px;
                        }

                        .punto{
                            border: 1px solid #000;
                            border-radius: 100%;
                            width: 50px;
                            text-align: center;
                        }

                        .name{
                            padding-right: 10px;
                            text-align: right;
                            border-bottom: 1px solid #000;
                            font-size: 18px;
                            width: 500px;
                        }

                        input[type="checkbox"]{
                        width: 30px; /*Desired width*/
                        height: 30px; /*Desired height*/
                        cursor: pointer;
                        }
                        tr{
                            padding: 10px;
                        }

                        .grupo{
                            margin-bottom: 20px;
                        }

                        .imagen-header{
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                            align-items: center;
                        }

                        .p-footer{
                            font-size: 14px;
                            display: block;
                            width: 80%;
                            margin: 0 auto;
                        }

                        /* Estilo para los radio buttons cuadrados */
                        input[type="radio"] {
                            -webkit-appearance: none;
                            -moz-appearance: none;
                            appearance: none;
                            width: 30px;
                            height: 30px;
                            border: 1px solid #000;
                            border-radius: 0; /* Sin borde redondeado para que sea cuadrado */
                            outline: none;
                            cursor: pointer;
                            position: relative;
                        }

                        input[type="radio"]:checked::before {
                            content: '';
                            position: absolute;
                            top: 2px;
                            left: 2px;
                            width: 25px;
                            height: 25px;
                            background-color: #000; /* Color del check */
                        }

                        

                        /* Estilos para impresión */
                        @media print {
                            body * {
                                visibility: hidden;
                                background-color: #fff !important;
                            }
                            .page-title{
                                display: none;
                            }

                            .contenedor{
                                background-color: #fff !important;
                                padding: 0px !important;
                                margin: 0px !important;
                            }

                            #main{
                                background-color: #fff !important;
                            }

                            #topbar{
                                display: none;
                            }

                            .card{
                                background-color: #fff !important;
                                padding: 0px !important;
                                margin: 0px !important;
                            }

                            .card-body{
                                padding: 0px !important;
                                background-color: #fff !important;
                                margin: 0px !important;
                            }
                            
                            #formularioInspeccion, #formularioInspeccion * {
                                visibility: visible;
                                background-color: #fff !important;
                            }
                            #formularioInspeccion {
                                position: relative;
                                left: 0;
                                top: 0;
                                width: 100%;
                                margin-bottom: 20px !important;
                                padding: 0px !important;
                                margin: 0px !important;
                                background-color: #fff !important;
                            }
                            td{
                                width: 5% !important;
                            }

                            .name{
                                max-width: 200px !important;
                                width: 200px !important;
                                font-size: 12px !important;
                            }

                            .punto{
                                width: 40px !important;
                                height: 40px !important;
                                font-size: 12px !important;
                            }

                            section{
                                padding: 0px !important;
                                margin: 0px !important;
                                background-color: #fff !important;
                                width: 100% !important;
                            }

                            .container{
                                padding: 15px !important;
                                margin: 0px !important;
                                background-color: #fff !important;
                                width: 100% !important;
                                max-width: 90% !important;
                                margin: 0 auto !important;
                            }

                            .observaciones{
                                width: 30% !important;
                            }
                            
                            .actualizar{
                            display: none;
                        }

                        .borrar{
                            display: none;
                        }
                            .imprimir{
                                display: none;
                            }
                        }
                    </style>

                    <button type="button" onclick="window.print()" class="btn btn-secondary mb-3 imprimir">Imprimir</button>

                    <div class="imagen-header">
                        <div>

                        </div>
                        <div>
                            <img src="{{ asset('assets/images/sergurcaixa.png') }}" alt="Logo de Inspección">                            
                        </div>
                    </div>
                    <div class="container">
                        <div class="header">
                            <div>
                                <h1>INSPECCIÓN GRATUITA 20 PUNTOS</h1>
                                <h2>de seguridad, desgaste y mantenimiento</h2>
                            </div>

                            <div class="header-form">
                                <div>
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="{{ $hojaInspeccion->fecha }}" required>
                                </div>
                                
                                <div>
                                    <label for="Matricula">Matrícula</label>
                                    <input type="text" name="matricula" class="form-control" value="{{ $hojaInspeccion->matricula }}" required>
                                </div>
                                
                            </div>
                        </div>

                        <div class="grupo">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">Bajo el capot</th>
                                        <th>Bien</th>
                                        <th>Mal</th>
                                        <th>Fuga</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="punto">1</td>
                                        <td class="name">NIVEL ACEITE MOTOR -></td>
                                        <td><input type="radio" name="nivel_aceite" value="1" {{ $hojaInspeccion->nivel_aceite == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_aceite" value="2" {{ $hojaInspeccion->nivel_aceite == 2 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_aceite" value="3" {{ $hojaInspeccion->nivel_aceite == 3 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_aceite" value="{{ $hojaInspeccion->observaciones_aceite }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">2</td>
                                        <td class="name">NIVEL LÍQUIDO REFRIGERANTE -></td>
                                        <td><input type="radio" name="nivel_liquido_refrigerante" value="1" {{ $hojaInspeccion->nivel_liquido_refrigerante == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_liquido_refrigerante" value="2" {{ $hojaInspeccion->nivel_liquido_refrigerante == 2 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_liquido_refrigerante" value="3" {{ $hojaInspeccion->nivel_liquido_refrigerante == 3 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_liquido_refrigerante" value="{{ $hojaInspeccion->observaciones_liquido_refrigerante }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">3</td>
                                        <td class="name">NIVEL LÍQUIDO DE FRENO Y EMBRAGUE -></td>
                                        <td><input type="radio" name="nivel_liquido_frenos_embrague" value="1" {{ $hojaInspeccion->nivel_liquido_frenos_embrague == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_liquido_frenos_embrague" value="2" {{ $hojaInspeccion->nivel_liquido_frenos_embrague == 2 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_liquido_frenos_embrague" value="3" {{ $hojaInspeccion->nivel_liquido_frenos_embrague == 3 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_liquido_frenos_embrague" value="{{ $hojaInspeccion->observaciones_liquido_frenos_embrague }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">4</td>
                                        <td class="name">NIVEL LÍQUIDO LIMPIAPARABRISAS -></td>
                                        <td><input type="radio" name="nivel_limpiaparabrisas" value="1" {{ $hojaInspeccion->nivel_limpiaparabrisas == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_limpiaparabrisas" value="2" {{ $hojaInspeccion->nivel_limpiaparabrisas == 2 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="nivel_limpiaparabrisas" value="3" {{ $hojaInspeccion->nivel_limpiaparabrisas == 3 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_nivel_limpiaparabrisas" value="{{ $hojaInspeccion->observaciones_nivel_limpiaparabrisas }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">5</td>
                                        <td class="name">ESTADO CORREAS AUXILIARES -></td>
                                        <td><input type="radio" name="estado_correas" value="1" {{ $hojaInspeccion->estado_correas == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="estado_correas" value="0" {{ $hojaInspeccion->estado_correas == 0 ? 'checked' : '' }}></td>
                                        <td></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_correas" value="{{ $hojaInspeccion->observaciones_correas }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grupo">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">Iluminación</th>
                                        <th>Bien</th>
                                        <th>Mal</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="punto">6</td>
                                        <td class="name">INTERMITENTES/EMERGENCIA -></td>
                                        <td><input type="radio" name="intermitente" value="1" {{ $hojaInspeccion->intermitente == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="intermitente" value="0" {{ $hojaInspeccion->intermitente == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_intermitente" value="{{ $hojaInspeccion->observaciones_intermitente }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">7</td>
                                        <td class="name">FRENADO -></td>
                                        <td><input type="radio" name="frenado" value="1" {{ $hojaInspeccion->frenado == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="frenado" value="0" {{ $hojaInspeccion->frenado == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_frenado" value="{{ $hojaInspeccion->observaciones_frenado }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">8</td>
                                        <td class="name">MARCHA ATRÁS -></td>
                                        <td><input type="radio" name="marcha_atras" value="1" {{ $hojaInspeccion->marcha_atras == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="marcha_atras" value="0" {{ $hojaInspeccion->marcha_atras == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_marcha_atras" value="{{ $hojaInspeccion->observaciones_marcha_atras }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">9</td>
                                        <td class="name">POSICIÓN/CORTA/LARGA -></td>
                                        <td><input type="radio" name="luces" value="1" {{ $hojaInspeccion->luces == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="luces" value="0" {{ $hojaInspeccion->luces == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_luces" value="{{ $hojaInspeccion->observaciones_luces }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">10</td>
                                        <td class="name">REGLAJE FAROS -></td>
                                        <td><input type="radio" name="reglaje_faros" value="1" {{ $hojaInspeccion->reglaje_faros == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="reglaje_faros" value="0" {{ $hojaInspeccion->reglaje_faros == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_reglaje_faros" value="{{ $hojaInspeccion->observaciones_reglaje_faros }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">11</td>
                                        <td class="name">ANTINIEBLAS -></td>
                                        <td><input type="radio" name="antinieblas" value="1" {{ $hojaInspeccion->antinieblas == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="antinieblas" value="0" {{ $hojaInspeccion->antinieblas == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_antinieblas" value="{{ $hojaInspeccion->observaciones_antinieblas }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grupo">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">Neumáticos(incluida rueda repuesto)</th>
                                        <th>Bien</th>
                                        <th>Mal</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="punto">12</td>
                                        <td class="name">ESTADO -></td>
                                        <td><input type="radio" name="estado_neumaticos" value="1" {{ $hojaInspeccion->estado_neumaticos == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="estado_neumaticos" value="0" {{ $hojaInspeccion->estado_neumaticos == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_estado_neumaticos" value="{{ $hojaInspeccion->observaciones_estado_neumaticos }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">13</td>
                                        <td class="name">PRESIÓN -></td>
                                        <td><input type="radio" name="presion_neumaticos" value="1" {{ $hojaInspeccion->presion_neumaticos == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="presion_neumaticos" value="0" {{ $hojaInspeccion->presion_neumaticos == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_presion_neumaticos" value="{{ $hojaInspeccion->observaciones_presion_neumaticos }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grupo">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">Frenado|Suspensión|Dirección|Transmisión|Escape</th>
                                        <th>Bien</th>
                                        <th>Mal</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="punto">14</td>
                                        <td class="name">AMORTIGUADORES -></td>
                                        <td><input type="radio" name="amortiguadores" value="1" {{ $hojaInspeccion->amortiguadores == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="amortiguadores" value="0" {{ $hojaInspeccion->amortiguadores == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_amortiguadores" value="{{ $hojaInspeccion->observaciones_amortiguadores }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">15</td>
                                        <td class="name">(rótulas, silentblocks, junta hom.) HOLGURAS -></td>
                                        <td><input type="radio" name="holguras" value="1" {{ $hojaInspeccion->holguras == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="holguras" value="0" {{ $hojaInspeccion->holguras == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_holguras" value="{{ $hojaInspeccion->observaciones_holguras }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">16</td>
                                        <td class="name">(pastillas, discos, zapatas) DESGASTE FRENOS -></td>
                                        <td><input type="radio" name="desgastes_frenos" value="1" {{ $hojaInspeccion->desgastes_frenos == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="desgastes_frenos" value="0" {{ $hojaInspeccion->desgastes_frenos == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_desgastes_frenos" value="{{ $hojaInspeccion->observaciones_desgastes_frenos }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">17</td>
                                        <td class="name">TENSIÓN FRENO DE MANO -></td>
                                        <td><input type="radio" name="tension_freno_mano" value="1" {{ $hojaInspeccion->tension_freno_mano == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="tension_freno_mano" value="0" {{ $hojaInspeccion->tension_freno_mano == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_tension_freno_mano" value="{{ $hojaInspeccion->observaciones_tension_freno_mano }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">18</td>
                                        <td class="name">(líquidos, gases de escape) FUGAS -></td>
                                        <td><input type="radio" name="fugas" value="1" {{ $hojaInspeccion->fugas == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="fugas" value="0" {{ $hojaInspeccion->fugas == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_fugas" value="{{ $hojaInspeccion->observaciones_fugas }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grupo">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">Otros elementos</th>
                                        <th>Bien</th>
                                        <th>Mal</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="punto">19</td>
                                        <td class="name">(accionamiento y escobillas) LIMPIAPARABRISAS -></td>
                                        <td><input type="radio" name="limpiaparabrisas" value="1" {{ $hojaInspeccion->limpiaparabrisas == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="limpiaparabrisas" value="0" {{ $hojaInspeccion->limpiaparabrisas == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_limpiaparabrisas" value="{{ $hojaInspeccion->observaciones_limpiaparabrisas }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="punto">20</td>
                                        <td class="name">(anclaje y recogida) CINTURONES DE SEGURIDAD -></td>
                                        <td><input type="radio" name="cinturones_seguridad" value="1" {{ $hojaInspeccion->cinturones_seguridad == 1 ? 'checked' : '' }}></td>
                                        <td><input type="radio" name="cinturones_seguridad" value="0" {{ $hojaInspeccion->cinturones_seguridad == 0 ? 'checked' : '' }}></td>
                                        <td class="observaciones">
                                            <input type="text" class="form-control" name="observaciones_cinturones_seguridad" value="{{ $hojaInspeccion->observaciones_cinturones_seguridad }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grupo">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                <div style="border: 1px solid #000; width: 40%; height: 100px; text-align: center; padding-top: 40px;">
                                    Sello del Taller
                                </div>
                                <div style="width: 40%; text-align: center;">
                                    <canvas id="firmaCliente" width="300" height="150" style="border: 1px solid #000; width: 100%; height: 200px;"></canvas>
                                    <p>Firma del Cliente</p>
                                </div>
                            </div>
                        </div>

                        <div class="grupo">
                            <p class="p-footer">
                                La inspección ha sido practicada de forma visual sin realizar otras operaciones específicas que pudieran ser requeridas para la confirmación de la
                                situación de los elementos inspeccionados. Esta inspección no sustituye en ningún caso las operaciones establecidas en el mantenimiento
                                programado del vehículo ni corrige necesariamente posibles averías ya existentes o futuras.
                            </p>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3 actualizar">Actualizar</button>
                </form>

                <form id="deleteForm" action="{{ route('hojas_inspeccion.destroy', [$coche->id, $hojaInspeccion->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger mt-3 borrar" onclick="confirmDelete()">Borrar</button>
                </form>

                <script>
                    function confirmDelete() {
                        if (confirm('¿Estás seguro de que deseas borrar esta hoja de inspección?')) {
                            document.getElementById('deleteForm').submit();
                        }
                    }
                </script>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
    @include('partials.toast')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('firmaCliente');
            const signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 3,
                penColor: "rgb(0, 0, 0)"
            });

            // Ajustar el tamaño del canvas al tamaño del contenedor
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Borrar la firma existente
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // Cargar firma guardada si existe
            const savedSignature = "{{ $hojaInspeccion->firma_cliente ?? '' }}";
            if (savedSignature) {
                const image = new Image();
                image.onload = function() {
                    signaturePad.clear();
                    canvas.getContext('2d').drawImage(image, 0, 0);
                };
                image.src = savedSignature;
            }

            document.getElementById('formularioInspeccion').addEventListener('submit', function (e) {
                if (!signaturePad.isEmpty()) {
                    const signatureData = signaturePad.toDataURL();
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'firma_cliente';
                    input.value = signatureData;
                    this.appendChild(input);
                }
            });
        });
    </script>
@endsection 
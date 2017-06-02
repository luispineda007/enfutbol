@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/iCheck/all.css')!!}
    <style>
        span>i{
            padding:4px 0;
        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4><b>Editar equipo</b></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        {!!Form::open(['id'=>'formEquipo', 'autocomplete'=>'off', 'class'=>'form-horizontal'])!!}
                        <div class="col-xs-12 col-md-6 text-right" id="divFoto">
                            <img src="/images/torneos/escudos/{!!$equipo->getEscudo->url!!}" width="180px" height="180px" id="escudo" class="manito img-bordered" data-toggle='tooltip' data-placement='bottom' title="Cambiar Escudo">
                        </div>

                        <div class="col-xs-12 col-xs-offset-3 col-md-6 col-md-offset-0">
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Torneo: </label>
                                <label class="col-md-9 control-label" style="text-align: left">{{ucwords(strtolower($torneo->nombre))}}</label>
                            </div>

                            <div class="form-group">
                                <label for="capitan" class="col-md-3 control-label">Capitan:</label>
                                <label class="col-md-9 control-label" style="text-align: left">{{ucwords(strtolower($equipo->getCapitan->getPersona->nombres))}}</label>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Genero: </label>
                                <label class="col-md-9 control-label" style="text-align: left">{{$genero}}</label>
                            </div>

                            <div class="form-group">
                                <label for="nombre" class="col-md-3 control-label">Equipo:</label>
                                @if($torneo->estado == "A")
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del torneo.." value="{{$equipo->nombre}}" required>
                                    </div>
                                @else
                                    <label class="col-sm-9 control-label" style="text-align: left">{{$equipo->nombre}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 text-center" style="margin-top:15px">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Guardar <i class="fa fa-check hidden" id="icono"></i></button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1" style="margin-top: 15px" id="seccionJugadores">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> <b> Jugadores del equipo <small>(Max. {{$torneo->max_jugadores}})</small></b> </h3>
                                <span class="icon pull-right">
                                    <span style="color: #ff524b;"><i class="fa fa-user-times manito" data-toggle='tooltip' data-placement='top' title="Eliminar seleccionados" id="borrarDeEquipo"></i></span>
                                    <span style="color: #00a65a;"><i class="fa fa-user-plus manito" data-toggle='tooltip' data-placement='top' title="Agregar nuevo jugador" id="addPersona"></i></span>
                                </span>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered table-hover">
                                        <tbody id="participantes">
                                        @foreach($equipo->getJugadores as $integrante)
                                            <tr class="fila">
                                                <td class="integranteEquipo">{{$integrante->identificacion}}</td>
                                                <td>{{$integrante->getUsuarioJugador($integrante->identificacion)[0]->nombres}}</td>
                                                <td data-integrante="{{$integrante->id}}" class="text-center">
                                                    <input type="checkbox" class="minimal deleteJugador">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            @if(count($equipo->getJugadores) < $torneo->max_jugadores)

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    {!!Html::script('plugins/iCheck/icheck.min.js')!!}
    <script>

        $(function () {
            $('input[type="checkbox"].deleteJugador').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                increaseArea: '-10%'
            });
        });

        $("#borrarDeEquipo").click(function(){
            var total = true;
            $('.deleteJugador:checked').each(function (index, val) {
                if(totalJugadores >4){
                    console.log("");
//                    var elemento = $(this).parents("li");
//                    selectJugadorEnEquipo(elemento.data("jugador"), "");
//                    $(elemento).hide("drop", [], 600);
//                    setTimeout(function () {
//                        $(elemento).remove();
//                    }, 650);
//                    --totalJugadores;
//                    validarInsertJugador(totalJugadores);
//                    $( "#sortableEquipo" ).sortable( "enable" );
                }
                else
                    total = false;
            });
            if(!total) {
                $("#modal-title").html("Atencion!").parents('.modal-header').addClass('alert-warning');
                $("#content").html("El equipo no puede contener menos de 4 jugadores");
                $("#botonModal").addClass('btn-warning');
                $("#notifModal").modal("show");
            }
        });

    </script>
@endsection
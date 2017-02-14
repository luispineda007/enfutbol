@extends('layouts.principal')

@section('css')
    <style>
        .pointer{
            cursor: pointer;
        }
        .panel-torneo, .nuevo{
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease;
        }
        .panel-torneo:hover, .nuevo:hover{
            -webkit-transform:scale(1.13);
            -moz-transform:scale(1.13);
            -ms-transform:scale(1.13);
            -o-transform:scale(1.13);
            transform:scale(1.13);
            z-index: 1000000;
        }
        .nuevo:hover{
            color: blue;
        }
        .editProfPic{
            position:absolute;
            top:15px;
            z-index:1;
            text-align: right;
            right: 10px;
        }
        .eliminar{
            background-color: white;
            border-radius: 50%;
            padding: 5px;
        }
        .eliminar:hover{
            background-color: rgb(251, 255, 255);
            cursor: pointer;
        }
        .panel-torneo{
            position: relative;
        }
        .confirmation .popover-content {
            width: 100%;
        }

        .btn-xs{
            padding: 4px 10px;
        }
        .confirmation-content{
            color: #0c0c0c;
            font-size: 13px;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Mis torneos</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12" id="albums">
                            <div class="col-xs-6 col-sm-6 col-md-3" id="padreNuevo">
                                <div class="panel panel-default pointer nuevo">
                                    <div class="panel-body" style="padding: 69px 0;">
                                        <center>
                                            <i class="fa fa-plus-square fa-4x"></i>
                                            <div style="padding-top: 5px">Crear Torneo</div>
                                        </center>
                                    </div>
                                </div>
                            </div>

                            @foreach($torneos as $torneo)
                                <div class="col-xs-6 col-sm-6 col-md-3">
                                    <div class="panel pointer panel-torneo" data-torneo="{{$torneo->id}}" data-total="{{count($torneo->getEquipos)}}">
                                        @if($torneo->estado == 'A')
                                            <div class="editProfPic">
                                                <i class='fa fa-trash fa-2x eliminar manito' aria-hidden='true' data-toggle='confirmation' data-singleton="true" data-placement='left' title='Eliminar?'  data-content="Esta accion no se podra deshacer, continuar?:" data-btn-ok-label="Si" data-btn-cancel-label="No"></i>
                                            </div>
                                        @endif
                                        <div class="torneo">
                                            <div class="panel-body" style="padding: 0;">
                                                <center>
                                                    <img src="/images/torneos/{{$torneo->url_logo}}" width="100%" height="158px">
                                                </center>
                                            </div>
                                            <div class="panel-footer">
                                                <b>{{$torneo->nombre}}</b><br>
                                                Estado: {{($torneo->estado == 'A')?'Abierto':'Cerrado'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body" id="content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" id="botonModal">Entendido!</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="plugins/bootstrapConfirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
    <script>
        $(function(){
            $(".torneo").on('click', function(){
                window.location = '/adminTorneo/' + $(this).parent().data('torneo');
            });

            $(".eliminar").each(function(){
                $(this).confirmation({
                    onConfirm: function () {
                        if($(this).parents('.panel-torneo').data('total') == 0)
                            eliminarTorneo($(this).parents('.panel-torneo'));
                        else{
                            $("#modal-title").html("Atencion!").parents('.modal-header').addClass('alert-warning');
                            $("#content").html('Este torneo ya contiene equipos inscritos para participar, para continuar con la eliminacion del torneo, primero se deben borrar los equipos participantes.');
                            $("#botonModal").addClass('btn-warning');
                            $("#notifModal").modal("show");
                        }

                    }
                });
            });
        });

        $("#padreNuevo").on('click', '.nuevo', function(){
            window.location = '{{route('torneoNuevo')}}';
        });

        function eliminarTorneo(elemento){
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('deleteTorneo')}}',
                data:{id:elemento.data('torneo')},
                success: function(data){
                    if (data=="exito")
                        elemento.parent().remove();
                },
                error: function (data) {

                }
            });
        }
    </script>
@endsection
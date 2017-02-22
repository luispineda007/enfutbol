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

        .info-box:hover{
            opacity: 0.5;
        }

        .info-box-select{
            box-shadow: 8px 8px 8px #646464;
        }

        .h1 .small, .h1 small, .h2 .small, .h2 small, .h3 .small, .h3 small, .h4 .small, .h4 small, .h5 .small, .h5 small, .h6 .small, .h6 small, h1 .small, h1 small, h2 .small, h2 small, h3 .small, h3 small, h4 .small, h4 small, h5 .small, h5 small, h6 .small, h6 small {
            font-weight: 400;
            line-height: 1;
            color: #98ea2f;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
        <div class="col-md-12">
            <div class="box {{($dias>=30)?"box-success":(($dias<30&&$dias>10)?"box-warning":"box-danger")}} collapsed-box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">suscripción a torneos {!!  ($dias<60)?(($dias<0)?"<small>( Vencida )</small>":"<small>( Quedan ".$dias." dias )</small>"):""!!}  </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-4" style="margin-top: 7px;">Valor suscripción: <b> ${{number_format($servicio->valor,2,",",".")}}</b></div>
                    <div class="col-sm-4" style="margin-top: 7px;">Fecha vencimineto: <b>{{$servicio->fecha_fin}}</b></div>
                    <div class="col-sm-4"><button id="solipago" type="button" class="btn btn-primary btn-flat">Solicitar un nuevo pago</button> </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        </div></div>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Mis torneos</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12" id="albums">

                            @if($servicio->estado=="X")
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
                                                <b>{{$torneo->nombre}}</b> {{($torneo->genero=='M')?'(Masculino)':'(Femenino)'}}<br>
                                                Estado: {{($torneo->estado == 'A')?'Abierto':'Cerrado'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                @else

                                <div class="callout callout-danger">
                                    <h4>Suscripción vencida!</h4>

                                    <p>Para seguir utilizando el servicio de Torneos es necesario bla bla bla .</p>
                                </div>
                            @endif
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


    <div class="modal fade" id="solisitudPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="exampleModalLabel">Solicitud de póximo pago</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-xs-12" style="margin-bottom: 15px">
                                Selecciona el plan que prefieras
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-red pointer info-box-select" data-plan="1 Mes">
                                    <span class="info-box-icon"><i class="fa fa-hand-pointer-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">1 Mes</span>
                                        <span class="info-box-number">$50.000</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <span class="progress-description">
                                            0% descuesto
                                          </span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-aqua pointer" data-plan="3 Meses">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">3 Meses</span>
                                        <span class="info-box-number">$130.000</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <span class="progress-description">
                                            2% descuesto
                                          </span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-yellow pointer" data-plan="6 Meses">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">6 Meses</span>
                                        <span class="info-box-number">$260.000</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <span class="progress-description">
                                            5% descuesto
                                          </span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->
                            </div>
                            <div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12">
                                <div class="info-box bg-green pointer" data-plan="12 Meses">
                                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">12 Meses</span>
                                        <span class="info-box-number">$500.000</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <span class="progress-description">
                                            10% descuesto
                                          </span>
                                    </div><!-- /.info-box-content -->
                                </div><!-- /.info-box -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                El plan selecciona es de <b id="plan">1 Mes</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12" id="alertModal">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="enviarSolicitud">Enviar Solicitud</button>
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

            $("#solipago").click(function () {
                $("#solisitudPago").modal("show");
            });

            var plan="1 Mes";
            $(".info-box").click(function () {
                $(".info-box").removeClass("info-box-select");
                $(this).addClass("info-box-select");
                $("#plan").html($(this).data("plan"));
                plan=$(this).data("plan");

            });

            $("#enviarSolicitud").click(function () {
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('solicidarPago')}}',
                    data:{plan:plan},
                    success: function(data){
                        if(data.bandera){
                            $("#solisitudPago").modal("hide");
                        }else{

                            var html = "<div class='alert alert-warning alert-dismissable'> " +
                                "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> " +
                                "<strong>UPS!</strong> " +data.mensaje+
                                "</div>";


                            $("#alertModal").html(html);
                        }

                    },
                    error: function (data) {

                    }
                });
            });

        });//fin Ready

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

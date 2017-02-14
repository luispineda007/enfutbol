@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}
    <style>
        .nuevo:hover{
            color: blue;
        }
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }
        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .image-preview-input-title {
            margin-left:2px;
        }
        .pointer, .aceptar, .rechazar{
            cursor: pointer;
        }
        textarea{
            resize: none;
        }
        .premiado{
            margin-top: 5px;
        }
        .popover{
            background-color: white !important;
            /*width: 100% !important;*/
        }
        .popover-title {
            background-color: #337ab7 !important;
            color: white !important;
        }

        .editProfPic{
            position:absolute;
            top:15px;
            z-index:1;
            text-align: right;
            /*padding-top: 9px;*/
            /*color: #a10000;*/
            right: 10px;
            /*margin-right: 20px;*/
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
        .panel-equipo{
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
        .panel-equipo, .nuevo{
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease;
        }
        .panel-equipo:hover, .nuevo:hover{
            -webkit-transform:scale(1.13);
            -moz-transform:scale(1.13);
            -ms-transform:scale(1.13);
            -o-transform:scale(1.13);
            transform:scale(1.13);
            z-index: 1000000;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Administrar torneo</h4>
                </div>
                <div class="panel-body">
                    @if($torneo->estado == 'A')
                        {!!Form::open(['id'=>'formTorneo', 'autocomplete'=>'off', 'class'=>'form-horizontal'])!!}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="col-md-2 control-label">Nombre</label>
                                    <div class="col-md-10">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-trophy"></i>
                                            </div>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del torneo.." value="{{$torneo->nombre}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="col-md-2 control-label">Descripción</label>
                                    <div class="col-md-10">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-comments"></i>
                                            </div>
                                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Caracteristicas del torneo.." required>{!!$torneo->descripcion!!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url_logo" class="col-md-2 control-label">Imagen</label>
                                    <div class="col-md-10">
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                        <span class="input-group-btn">
                                            <!-- image-preview-clear button -->
                                            <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                <span class="glyphicon glyphicon-remove"></span> Cancelar
                                            </button>
                                            <!-- image-preview-input -->
                                            <div class="btn btn-default image-preview-input">
                                                <span class="glyphicon glyphicon-folder-open"></span>
                                                <span class="image-preview-input-title">Cambiar</span>
                                                <input type="file" accept="image/png, image/jpeg, image/gif" name="url_logo" id="url_logo"/>
                                            </div>
                                        </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 text-center">
                                <img src="/images/torneos/{!!$torneo->url_logo!!}" width="70%" height="195px" id="imagen">
                            </div>

                            <div class="col-xs-12 text-center" style="margin-top:15px">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar <i class="fa fa-check hidden" id="icono"></i></button>
                                </div>
                            </div>
                        {!!Form::close()!!}
                    @else
                        {{--Mostrar administracion de fases de torneo--}}
                    @endif

                    <div class="col-xs-12">
                        <h2 style="margin-bottom: 15px">Equipos inscritos</h2>
                        <div class="col-xs-4 col-sm-4 col-md-2" id="padreNuevo">
                            <div class="panel panel-default pointer nuevo">
                                <div class="panel-body" style="padding: 49px 0;">
                                    <center>
                                        <i class="fa fa-plus-square fa-4x"></i>
                                        <div style="padding-top: 5px">Registrar Equipo</div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        @foreach($torneo->getEquipos_torneo as $equipo)
                            <div class="col-xs-4 col-sm-4 col-md-2">
                                <div class="panel pointer panel-equipo" data-equipo="{{$equipo->getEquipo->id}}">

                                    <div class="editProfPic">
                                        <i class='fa fa-trash fa-2x eliminar manito' aria-hidden='true' data-toggle='confirmation' data-singleton="true" data-placement='left' title='Eliminar?'  data-content="Esta accion no se podra deshacer, continuar?:" data-btn-ok-label="Si" data-btn-cancel-label="No"></i>
                                    </div>

                                    <div class="equipo">
                                        <div class="panel-body" style="padding: 0;">
                                            <center>
                                                <img src="/images/torneos/escudos/{{$equipo->getEquipo->getEscudo->url}}" width="100%" height="140px">
                                            </center>
                                        </div>
                                        <div class="panel-footer">
                                            <b>{{$equipo->getEquipo->nombre}}</b><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(isset($torneo->getSolicitudes))
                        @if(count($torneo->getSolicitudes) > 0)
                            <div class="col-xs-12">
                                <h2 style="margin-bottom: 15px">Solicitudes de inscripcion</h2>

                                <table id="solicitudes" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Equipo</th>
                                        <th class="text-center">Capitan</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($torneo->getSolicitudes as $solicitud)
                                        <tr>
                                            <td>{{$solicitud->getEquipo->nombre}}</td>
                                            <td>{{$solicitud->getCapitan->getPersona->nombres}}</td>
                                            <td>{{($solicitud->estado == 'P')?'Pendiente':'Rechazada'}}</td>
                                            <td class="text-center" data-solicitud="{{$solicitud->id}}">
                                                <i class="fa fa-check-circle-o fa-2x aceptar" title="Aceptar"></i>
                                                @if($solicitud->estado == 'P')
                                                    &nbsp;<i class="fa fa-times-circle-o fa-2x rechazar" title="Rechazar"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
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
    {!!Html::script('plugins/bootstrapConfirmation/bootstrap-confirmation.min.js')!!}
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}
    <script>
        $(function() {
            $('#solicitudes').DataTable( {
                "language": {
                    "lengthMenu": "Mostrar  _MENU_ Solicitudes por Página",
                    "zeroRecords": "Ningun registro",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay solicitudes",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            } );

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

            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview',
                style: 'font-size: initial;'
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Vista previa</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.image-preview-clear').click(function(){
                $('.image-preview').attr("data-content","").popover('hide');
                $('.image-preview-filename').val("");
                $('.image-preview-clear').hide();
                $('.image-preview-input input:file').val("");
                $(".image-preview-input-title").text("Cambiar");
            });
            // Create the preview image
            $(".image-preview-input input:file").change(function (){
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".image-preview-input-title").text("Cambiar");
                    $(".image-preview-clear").show();
                    $(".image-preview-filename").val(file.name);
                    img.attr('src', e.target.result);
                    $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                };
                reader.readAsDataURL(file);
            });


        });

        $("#formTorneo").on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('torneo_id', '{{$torneo->id}}');
            $.ajax({
                type: "POST",
                url: '{{route('updateTorneo')}}',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function (data) {
                    if(data.estado){
                        $("#icono").removeClass('hidden');
                        if(data.mensaje != 'exito'){
                            $("#imagen").attr('src', '/images/torneos/' + data.mensaje);
                            $('.image-preview').attr("data-content","").popover('hide');
                            $('.image-preview-filename').val("");
                            $('.image-preview-clear').hide();
                            $('.image-preview-input input:file').val("");
                            $(".image-preview-input-title").text("Cambiar");
                        }
                    }
                    else {
                        $("#modal-title").html("Error!").parents('.modal-header').addClass('alert-danger');
                        $("#content").html(data.mensaje);
                        $("#botonModal").addClass('btn-danger');
                        $("#notifModal").modal("show");
                    }
                },
                error: function () {

                }
            });
        });

        $(document).on('click', '#close-preview', function(){
            $('.image-preview').popover('hide');
            // Hover befor close the preview
            $('.image-preview').hover(
                    function () {
                        $('.image-preview').popover('show');
                    },
                    function () {
                        $('.image-preview').popover('hide');
                    }
            );
        });
    </script>
@endsection
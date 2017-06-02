@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
    {!!Html::style('plugins/iCheck/all.css')!!}
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <style>
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
        .pointer{
            cursor: pointer;
        }
        textarea{
            resize: none;
        }
        .premiado{
            margin-top: 5px;
        }
        .popover{
            background-color: white;
            width: 100%;
        }
        .popover-title {
            background-color: #337ab7;
            color: white;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                <div class="panel-heading">
                    <h4>Crear torneo</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        {!!Form::open(['id'=>'formTorneo', 'autocomplete'=>'off', 'class'=>'form-horizontal'])!!}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="col-md-2 control-label">Nombre</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-trophy"></i>
                                        </div>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del torneo.." required>
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
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Caracteristicas del torneo.." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max_equipos" class="col-md-2 control-label">Equipos</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <select class="form-control" id="max_equipos" name="max_equipos" required>
                                            <option value="" selected disabled>Maximo participantes..</option>
                                            <option value="8">8 equipos</option>
                                            <option value="12">12 equipos</option>
                                            <option value="16">16 equipos</option>
                                            <option value="32">32 equipos</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max_jugadores" class="col-md-2 control-label">Jugadores</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="number" name="max_jugadores" id="max_jugadores" class="form-control" placeholder="Total por equipo..." min="4" max="20" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="vlr_inscripcion" class="col-md-2 control-label">Inscripción</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-usd"></i>
                                        </div>
                                        <input type="number" name="vlr_inscripcion" id="vlr_inscripcion" class="form-control" placeholder="Costo de la inscripción.." min="0" required>
                                    </div>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="maxFecha_inscripcion" id="maxFecha_inscripcion" class="form-control pointer" placeholder="Fecha maxima inscripción.." min="0" onkeypress="return false;" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipo_cancha" class="col-md-2 control-label">Cancha</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-futbol-o"></i>
                                        </div>
                                        <select class="form-control" id="tipo_cancha" name="tipo_cancha" required>
                                            <option value="5">Futbol 5</option>
                                            <option value="6">Futbol 6</option>
                                            <option value="7">Futbol 7</option>
                                            <option value="8">Futbol 8</option>
                                            <option value="9">Futbol 9</option>
                                            <option value="10">Futbol 10</option>
                                            <option value="11">Futbol 11</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        @if(Auth::user()->getSitio)

                            <div class="form-group">
                                <label for="privacidad" class="col-md-7 control-label">El torneo pertenece a este sitio </label>
                                <div class="col-md-5">
                                    <div class="checkbox">
                                        <label><input type="radio" name="sitio_id" class="rsitio" value="1" checked>&nbsp; Si</label>
                                        <label><input type="radio" name="sitio_id" class="rsitio" value="0"> &nbsp;No</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="col-md-2 control-label">Genero</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-venus-mars"></i>
                                        </div>
                                        <select class="form-control" id="genero" name="genero" required>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="privacidad" class="col-md-2 control-label">Privacidad</label>
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        <label><input type="radio" name="privacidad" class="minimal" value="A" checked>&nbsp; Abierto</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="radio" name="privacidad" class="minimal" value="C"> &nbsp;Cerrado</label>
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
                                                <input type="file" accept="image/png, image/jpeg, image/gif" name="url_logo" id="url_logo" required/>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="premiacion" class="col-md-2 control-label">Premiación</label>
                                <div class="col-md-10">

                                    <label class="col-xs-12 col-lg-5 premiado text-center" for="campeon"><i class="fa fa-circle"></i>&nbsp; Campeon</label>
                                    <div class="col-xs-12 col-lg-7">
                                        <input class="form-control" type="text" name="campeon" id="campeon" required>
                                    </div>

                                    <label class="col-xs-12 col-lg-5 premiado text-center" for="subcampeon"><i class="fa fa-circle"></i>&nbsp; 2do Lugar</label>
                                    <div class="col-xs-12 col-lg-7">
                                        <input class="form-control" type="text" name="subcampeon" id="subcampeon" required>
                                    </div>

                                    <label class="col-xs-12 col-lg-5 premiado text-center" for="p3"><i class="fa fa-circle"></i>&nbsp; 3er Lugar</label>
                                    <div class="col-xs-12 col-lg-7">
                                        <input class="form-control" type="text" name="p3" id="p3" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="departamento" class="col-sm-2 control-label">Ubicación</label>
                                <div class="col-sm-10">
                                    {!!Form::select('departamento', $arrayDepartamento, $departamento, ['class'=>"form-control", 'id' => 'departamento'])!!}
                                    {!!Form::select('municipio_id', [], null, ['class'=>"form-control", 'id'=>'municipio_id'])!!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nombre" class="col-md-2 control-label">Lugar</label>
                                <div class="col-md-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-trophy"></i>
                                        </div>
                                        @if(Auth::user()->getSitio)
                                            <input type="text" class="form-control" id="lugar" name="lugar" value="{{Auth::user()->getSitio->nombre}}" disabled>
                                            @else
                                            <input type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar donde se jugara el torneo" required>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    {!!Html::script('plugins/iCheck/icheck.min.js')!!}
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <script>
        var nombreSitio = "";
        $(function() {
            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Clear",
                format: "yyyy-mm-dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $('#maxFecha_inscripcion').datepicker({
                autoclose: true,
                todayHighlight:true,
                startDate:'+3d',
                language: 'es'
            });

            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview',
                style: 'font-size: initial;'
            });
            closebtn.attr("class","close pull-right");
            $('.image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Vista previa</strong>"+$(closebtn)[0].outerHTML,
                content: "Selecciona una imagen",
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

            $('input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $('input[type="radio"].rsitio').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            }).on('ifChecked', function(event){
                if ($(this)[0].value==0) {
                    $( "#lugar" ).prop( "disabled", false );
                    $( "#lugar" ).val("");
                }else{
                    $( "#lugar" ).prop( "disabled", true );
                    $( "#lugar" )[0].value=nombreSitio;
                    console.log(nombreSitio);
                }

            });

            llenarMunicipios();
            $('#municipio_id').val('{{$municipio}}');


            nombreSitio = $("#lugar").val();
        });/// FIN READY

        $("#departamento").change(function () {
            llenarMunicipios();
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

        $('#formTorneo').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: '{{route('insertTorneo')}}',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function (data) {
                    console.log(data.estado);
                    if(data.estado){
                        window.location = '/adminTorneo/'+data.mensaje;
                    }
                },
                error: function () {

                }
            });

        });

        function llenarMunicipios(){
            $.ajax({
                type: "POST",
                context: document.body,
                url: '{{route('municipios')}}',
                data: { 'id' : $("#departamento").val()},
                async: false,
                success: function (data) {
                    $("#municipio_id").empty();
                    $.each(data,function (index,valor) {
                        $("#municipio_id").append('<option value='+index+'>'+valor+'</option>');
                    });
                },
                error: function (data) {
                }
            });
        }
    </script>
@endsection
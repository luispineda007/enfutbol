@extends('layouts.frontEnd.principal')

@section('css')
    <title>Perfil Usuario</title>
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <!-- Bootstrap time Picker -->
    {!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}
    <!-- DataTables -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link href="plugins/bootstrapFileInput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />


    <style>

        .sitios{
            background-color: #ededed;
            border-radius: 5px;
            padding: 15px 0px 15px 0px;
        }
        .sitios h2{
            margin: 0 0 15px 0
        }
        .sitios h4{
            margin: 0 0 10px 0
        }

        #fh5co-work {
            background-color: transparent;
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            width: 100%;
            background-color: #A4D792;
            color: #161616;
            overflow: hidden;
        }

        #fh5co-work .gradient {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
/*            z-index: 2;*/
            opacity: .9;
            -webkit-backface-visibility: hidden;
            background-color: #A4D792;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zd…AiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjdnNnZykiIC8+PC9zdmc+);
            background-image: -webkit-gradient(linear, 0% 0%, 100% 100%, color-stop(0, #21825c), color-stop(1, #a4d792));
            background-image: -webkit-linear-gradient(top left, #21825c 0%, #a4d792 100%);
            background-image: linear-gradient(to bottom right, #21825c 0%, #a4d792 100%);
            background-image: -ms-linear-gradient(top left, #21825c 0%, #a4d792 100%);
        }

        @media screen and (min-width: 768px) {

            .portada{
                width: 100%;
                height: 270px;
            }
        }

        #sitios{
            z-index: 10000;
        }

        .js .to-animate {
            opacity: 100;
        }
        #fh5co-work a {
             color: rgba(0, 0, 0, 0.5);
            text-decoration: underline;
        }
        #fh5co-work a:hover {
            color: rgba(148, 148, 148, 0.63);
            text-decoration: underline;
        }

        #sitios a{
            color: rgba(255, 255, 255, 0.5);
            text-decoration: underline;
        }

        .section-heading {
            padding-bottom: 5px;
            margin-bottom: 5px;

        }
         #fh5co-work {
            padding: 4em 0;
        }





        @media (max-width: 768px) {
            #divFotoPerfil{
                margin: 0px 25% 15px 25%;
            }
        }
        /*       @media (min-width: 768px) and (max-width: 992px) {
                   #divFotoPerfil{
                       margin: 0px 25% 15px 25%;
                   }
               }
               @media (min-width: 992px) and (max-width: 1200px) {
                   #divFotoPerfil{
                       margin: 0px 0% 15px 50%;
                   }
               }
               @media (min-width: 1200px) {
                   #divFotoPerfil{
                       margin: 0px 0% 15px 50%;
                   }
               }*/





    </style>




@endsection


@section('header')
    <header role="banner" id="fh5co-header" class="navbar-fixed-top fh5co-animated slideInDown">
        <div class="container">
            <!-- <div class="row"> -->
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <!-- Mobile Toggle Menu Button -->
                    <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle " data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                    <a class="navbar-brand" href="{{route("home")}}">enFutbol</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li ><a href="{{route("home")}}" ><span>Inicio</span></a></li>
                        <li><a href="{{route("buscar")}}"><span>Buscar</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-about" data-nav-section="services"><span>Aliados</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-contact" data-nav-section="contact"><span>Contacto</span></a></li>
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="work"><span>Perfil</span></a></li>
                    </ul>
                </div>
            </nav>
            <!-- </div> -->
        </div>
    </header>

@endsection


@section('content')

    <section id="fh5co-work" data-section="work" class="work" style="background-image: url({{URL::to('images/full_image_2.jpg')}});">
        <div class="gradient"></div>
        <div class="container">
            <div class="row">


                <div class="panel panel-default" style="position: relative;">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 style="margin-bottom: 12px;">Usuario: {{Auth::user()->user}}<a class="btn btn-default pull-right" href="{{route('logout')}}" role="button" style="text-decoration: none;">Cerrar Sesión</a></h3>
                            </div>

                        </div>


                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-12 text-right" id="divFotoPerfil">
                                        <form class="text-center" method="post" enctype="multipart/form-data" id="nuevo">
                                            <div class="kv-avatar" id="conteFU">
                                                <input id="avatar-1" name="avatar-1" type="file" class="file-loading" accept='image/*'>
                                            </div>
                                        </form>
                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none; margin-top: 15px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">

                                {!!Form::model( $persona,['id'=>'formActualizarJugador','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

                                <h2 class="text-center" >Actualiza tu información</h2>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nombres', 'Nombre',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::text('nombres',null,['class'=>'form-control','placeholder'=>"Nombres y Apellidos...", 'required', 'onkeypress' => 'return justletters(event)', 'maxlength="35"'])!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('fecha_nacimiento', 'Fecha',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-birthday-cake"></i>
                                                    </div>
                                                    {!!Form::text('fecha_nacimiento',null,['class'=>'form-control pull-right manito','placeholder'=>"Fecha de Nacimiento",'readonly'])!!}
                                                    {{--<input type="text" name="fecha_nacimiento" class="form-control pull-right" id="fecha_nacimiento" placeholder="Fecha de Nacimiento" readonly>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('telefono', 'No. Movil',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    {!!Form::text('telefono',null,['class'=>'form-control','placeholder'=>"Número celular...",'required',"minlength"=>"10","maxlength"=>"10","onkeypress"=>"return justNumbers(event)"])!!}
                                                    {{--<input type="text" name="telefono" id="telefono" class="form-control"  minlength="10" maxlength="10" onkeypress="return justNumbers(event)" placeholder="Número celular...">--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('departamento', 'Departamento',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::select('departamento', $arrayDepartamento, $departamento, ['class'=>"form-control",'placeholder' => 'Seleccione un Departamento', 'required'])!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6" id="divMunicipio">
                                        <div class="form-group">
                                            {!! Form::label('id_municipio', 'Municipio',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::select('id_municipio', $arrayMunicipio, $persona->id_municipio, ['class'=>"form-control",'placeholder' => 'Pick a size...', 'required'])!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1" id="alertJugador">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 ">
                                        <button class="btn btn-success center-block" type="submit">Actualizar Información</button>
                                    </div>

                                </div>

                                {!!Form::close()!!}


                                {!!Form::open(['id'=>'formActualizarPass','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}


                                <h2 class="text-center" style="margin-top: 35px;">Cambiar tu cantraseña</h2>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('passwordA', 'Contraseña',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::password('passwordA',['class'=>'form-control','placeholder'=>"Contraseña actual"])!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="contrasenas">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group passNueva">
                                            {!! Form::label('password', 'Nueva',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::password('password',['class'=>'form-control','placeholder'=>"Nueva contraseña", 'disabled', 'required' ])!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group passNueva">
                                            {!! Form::label('passwordC', 'Confirmar',['class'=>'col-sm-4 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!!Form::password('passwordC',['class'=>'form-control','placeholder'=>"Confirmar contraseña",'disabled' , 'required'])!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1" id="alert">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 ">
                                        <button class="btn btn-success center-block" type="submit">Cambiar Contraseña</button>
                                    </div>
                                </div>

                                </div>


                                {!!Form::close()!!}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <!-- bootstrap datepicker -->
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <script src="plugins/bootstrapFileInput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/fileinput.min.js"></script>
    <script src="plugins/bootstrapFileInput/js/locales/es.js"></script>

    <script>




        var banderaC = false;

        $(function () {


            cargarAvatarFileInput("{{Auth::user()->avatar}}");

            $("#fh5co-header").addClass("navbar-fixed-top fh5co-animated slideInDown");



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
            $('#fecha_nacimiento').datepicker({
                autoclose: true,
                todayHighlight:true,
                startDate:'+0d',
                language: 'es'
            }).on('changeDate', function () {


            });


            $("#departamento").change(function () {
                if($("#departamento").val()==""){
                    $("#divMunicipio").addClass("hidden").removeClass("show");
                }else{
                    $("#divMunicipio").addClass("show").removeClass("hidden");
                    //alert("el id es "+$("#departamento").val());
                    $.ajax({
                        type: "POST",
                        context: document.body,
                        url: '{{route('municipios')}}',
                        data: { 'id' : $("#departamento").val()},
                        success: function (data) {
                            $("#id_municipio").empty();
                            $.each(data,function (index,valor) {
                                $("#id_municipio").append('<option value='+index+'>'+valor+'</option>')
                            });

                        },
                        error: function (data) {
                        }
                    });
                }
            });



            var formActualizarJugador = $("#formActualizarJugador");
            formActualizarJugador.submit(function(e){
                e.preventDefault();
                    $.ajax({
                        type:"POST",
                        context: document.body,
                        url: '{{route('updateJugador')}}',
                        data:formActualizarJugador.serialize(),
                        success: function(data){
                            if (data=="exito") {
                                $("#alertJugador").empty();
                                $("#alertJugador").append(alert("success","Perfecto","su datos fueron actualizados exitosamente", 'fa-check'));
                            }
                            else {
                                $("#alertJugador").empty();
                                $("#alertJugador").append(alert("danger","Error" ," interno por favor intentar más tarde", 'fa-key'));
                            }
                        },
                        error: function(){
                            console.log('ok');
                        }
                    });


            });
            var formActualizarPass = $("#formActualizarPass");
            formActualizarPass.submit(function(e){
                e.preventDefault();


                if($("#password").val()!=""){

                    if($("#password").val()==$("#passwordC").val()){
                        $("#alert").empty();
                        $(".passNueva").each(function (index, item) {
                            $(this).removeClass("has-error");
                        });

                        $.ajax({
                            type:"POST",
                            context: document.body,
                            url: '{{route('cambiarPassword')}}',
                            data:formActualizarPass.serialize(),
                            success: function(data){
                                if (data.bandera) {
                                    $("#alert").empty();
                                    $("#alert").append(alert("success","Perfecto",data.mensaje, 'fa-key'));
                                    //console.log("exito");
                                }
                                else {
                                    $("#alert").empty();
                                    $("#alert").append(alert("danger","Error" ,data.mensaje, 'fa-key'));
                                }
                            },
                            error: function(){
                                console.log('ok');
                            }
                        });
                    }else{
                        $("#alert").empty();
                        $("#alert").append(alert("danger","Error" ,"La contraseña no coinciden", 'fa-key'));

                        $(".passNueva").each(function (index, item) {
                            $(this).addClass("has-error");
                        })
                    }
                }
            });


            $("#passwordA").change(function () {


                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('validarPassword')}}',
                    data: { 'password' : $("#passwordA").val()},
                    success: function (data) {
                        if(data.bandera){
                            $("#alert").empty();
                            $("#password").removeAttr('disabled');
                            $("#passwordC").removeAttr('disabled');
                        }else{
                            $("#alert").empty();
                            $("#alert").append(alert("danger","Error" ,data.mensaje, 'fa-key'));

                        }
                    },
                    error: function (data) {
                    }
                });

            });



        });

        function cargarAvatarFileInput(ruta){

            $("#conteFU").removeClass("centrar");
            $("#avatar-1").fileinput({
                maxFileSize: 2048,
                uploadUrl : 'avatarUsuario',
                uploadAsync : false,
                overwriteInitial: true,
                showClose: false,
                showCaption: false,
                dropZoneEnabled: false,
                language: "es",
                showUpload: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'Deshacer cambios',
                previewFileType: 'image',
                allowedFileTypes: ['image'],
                allowedFileExtensions: ['jpg', 'gif', 'png'],
                uploadExtraData : {id:"", sitio:"", actual: ruta},
//                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="dist/img/'+ruta+'" class="img-rounded img-responsive" alt="Imagen de perfil">',
//                resizeImage: true,
                previewSettings:{ image: {width: "200px", height: "160px"}}
            }).on('fileuploaded', function(e, params) {
                $("#conteFU").empty();
                $("#conteFU").append('<input id="avatar-1" name="avatar-1" type="file" class="file-loading" accept="image/*">');
                ppRoute = params.response.nueva;
                cargarAvatarFileInput(ppRoute);
            }).on('change', function(event) {
                $("#conteFU").addClass("centrar");
            });
        }



        //contraseña actual incorrecta.    <i class='fa fa-key' aria-hidden='true'></i>
        function alert(tipo,estado,mensaje ,fontawesome) {
            html='<div class="alert alert-'+tipo+' text-center" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<i class="fa '+fontawesome+'" aria-hidden="true"></i><strong>'+estado+' :  </strong>'+mensaje+
                '</div>';

            return html;
        }


    </script>

@endsection
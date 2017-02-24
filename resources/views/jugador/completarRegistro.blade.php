@extends('layouts.frontEnd.principal')

@section('css')
    <title>Registrate</title>
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <style>
        input[type="date"]{
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
        }

        .contenido{
            margin-bottom: 90px;
        }

        #fh5co-home, #fh5co-home .text-wrap {
            height: 100%;
        }
        .animated{
            color:white;
        }
        .cargando{
            font-size: 16px;
        }
        .titulo{
            margin: 5px;
            color: black;
        }
    </style>

@endsection

@section('header')

    <header role="banner" id="fh5co-header" class="navbar-fixed-top fh5co-animated slideInDown">
        <div class="container">
            <!-- <div class="row"> -->
            <nav class="navbar navbar-default">
                <div class="navbar-header hidden-md">
                    <!-- Mobile Toggle Menu Button -->
                    <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle " data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                    <a class="navbar-brand" href="{{route("home")}}">enFutbol.com</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li ><a href="{{route("home")}}" ><span>Inicio</span></a></li>
                        <li><a href="{{route("buscar")}}"><span>Buscar</span></a></li>
                        <!-- <li class="hidden-sm"><a href="{{route("home")}}#fh5co-work" ><span>Work</span></a></li> -->
                        <!-- <li><a href="{{route("home")}}#fh5co-services" data-nav-section="services"><span>Services</span></a></li> -->
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="home"><span>Registro</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-contact" data-nav-section="contact"><span>Contacto</span></a></li>
                    </ul>
                </div>
            </nav>
            <!-- </div> -->
        </div>
    </header>
@endsection

@section('content')
    <section id="fh5co-home" data-section="home" style="background-image: url(images/full_image_2.jpg);" >
        <div class="gradient"></div>
        <div class="container">
            <div class="text-wrap contenido">
                <div class="row">
                    <div class="panel panel-default" style="position: relative;">
                        <div class="panel-heading">
                            <h1 class="to-animate fadeInUp animated text-center titulo">Registrate</h1>
                        </div>
                        <div class="panel-body">
                            {!!Form::open(['id'=>'formRegistrarJugador','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('identificacion', 'No. Identificación',['class'=>'col-sm-4 control-label', 'style'=>'']) !!}
                                        <div class="col-sm-8">
                                            {!!Form::text('identificacion',null,['class'=>'form-control','placeholder'=>"Número de Identificación...", 'onkeypress' => 'return justNumbers(event)', 'maxlength'=>'15', 'minlength'=>'7', 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('nombres', 'Nombre',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            {!!Form::text('nombres',null,['class'=>'form-control','placeholder'=>"Nombres y Apellidos...", 'required', 'onkeypress' => 'return justletters(event)', 'maxlength=35'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('fecha_nacimiento', 'Fecha Nacimiento',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-birthday-cake"></i>
                                                </div>
                                                <input type="text" name="fecha_nacimiento" class="form-control pull-right" id="fecha_nacimiento" placeholder="Selecciona una fecha..." readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('sexo', 'Sexo',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            {!!Form::select('sexo', ['M' => 'Masculino', 'F' => 'Femenino'], null, ['class'=>"form-control",'placeholder' => 'Selecciona una opcion...', 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('telefono', 'No. Movil',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input type="text" name="telefono" id="telefono" class="form-control" required minlength="10" maxlength="10" onkeypress="return justNumbers(event)" placeholder="Número celular...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        {!! Form::label('departamento', 'Departamento',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            {!!Form::select('departamento', $arrayDepartamento, null, ['class'=>"form-control",'placeholder' => 'Seleccione un Departamento', 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden" id="divMunicipio">
                                    <div class="form-group">
                                        {!! Form::label('id_municipio', 'Municipio',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            {!!Form::select('id_municipio', ['L' => 'Large', 'S' => 'Small'], null, ['class'=>"form-control",'placeholder' => 'Pick a size...', 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1" id="error">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary center-block" type="submit" id="submitForm">Guardar! <i class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>
                                        <span class="sr-only">Loading...</span> </button>

                                </div>
                            </div>
                        {!!Form::close()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slant"></div>
    </section>

@endsection

@section('js')
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.date.extensions.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.extensions.js')!!}
    <script>
        $(function(){
/*            $("#correo").blur(function(){
                expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if ($(this).val() != ""){
                    if (!expr.test($(this).val())) {
                        $(this).parent().addClass("has-error");
                        $(this).focus();
                        $("#submitForm").attr("disabled", 'disabled');
                    }
                    else {
                        $(this).parent().removeClass("has-error");
                        $(this).parent().addClass("has-success");
                        $("#submitForm").removeAttr("disabled");
                    }
                }
                else {
                    $(this).parent().removeClass("has-error");
                    $(this).parent().removeClass("has-success");
                    $("#submitForm").attr("disabled", 'disabled');
                }
            });*/
            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Clear",
                format: "yyyy/mm/dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $('#fecha_nacimiento').datepicker({
                autoclose: true,
                language: 'es',
                endDate:'-1095d'
            });


            $("[data-mask]").inputmask();

            var formulario = $("#formRegistrarJugador");
            formulario.submit(function(e){
                e.preventDefault();
                $(".cargando").removeClass("hidden");
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('completarRegistro')}}',
                    data:formulario.serialize(),
                    success: function(data){
                        if (data.bandera) {
                            $(".cargando").addClass("hidden");
                            $("#error").html('<div class="alert alert-success">' +
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                    '<strong>Perfecto!</strong> Los datos de tu cuenta fueron almacenados correctamente.' +
                                    '</div>');
                        }else{
                            $("#error").html('<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> ' +data.mensaje+
                                '</div>');
                        }

                    },
                    error: function (data) {
                        var respuesta =JSON.parse(data.responseText);
                        var arr = Object.keys(respuesta).map(function(k) { return respuesta[k] });
                        var error='<ul>';
                        for (var i=0; i<arr.length; i++)
                            error += "<li>"+arr[i][0]+"</li>";
                        error += "</ul>";
                        $(".cargando").addClass("hidden");
                        $("#error").html('<div class="alert alert-danger">' +
                                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                            '<strong>Error!</strong> Corrige los siguientes errores para continuar el registro:' +
                                            '<p>'+error+'</p>' +
                                        '</div>');
//                        $("#error").css("display", "block");
                    }
                });
            });

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
    </script>
@endsection
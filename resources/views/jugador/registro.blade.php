@extends('layouts.frontEnd.principal')

@section('css')
    <title>Registrate</title>

    <style>


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
                    <div class="col-sm-8 col-sm-offset-2">
                    <div class="panel panel-default" style="position: relative;">
                        <div class="panel-heading">
                            <h1 class="to-animate fadeInUp animated text-center titulo">Registrate</h1>
                        </div>
                        <div class="panel-body">
                            {!!Form::open(['id'=>'formRegistrarJugador','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}



                            <div class="row" style="margin-bottom: 20px">
                                <div class="col-sm-11">
                                    <div class="form-group">
                                        {!! Form::label('user', 'Usuario',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" placeholder="Ej: nombre.apellido" name="user" id="user" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-11">
                                    <div class="form-group">
                                        {!! Form::label('correo', 'E-Mail',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type="email" class="form-control" placeholder="ejemplo@enFutbol.com" name="email" id="correo" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-11">
                                    <div class="form-group">
                                        {!! Form::label('password', 'Contraseña',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="contraseña" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-11">
                                    <div class="form-group">
                                        {!! Form::label('cpassword', 'Confirmar',['class'=>'col-sm-4 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                <input type="password" id="ccontrasena" name="ccontrasena" class="form-control" placeholder="Confirmar contraseña" required>
                                            </div>
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
                                    <button class="btn btn-primary center-block" type="submit" disabled id="submitForm">Guardar! <i class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>
                                        <span class="sr-only">Loading...</span> </button>

                                </div>
                            </div>
                        {!!Form::close()!!}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="slant"></div>
    </section>

@endsection

@section('js')

    <script>
        $(function(){
            $("#correo").blur(function(){
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
            });

            var formulario = $("#formRegistrarJugador");
            formulario.submit(function(e) {
                e.preventDefault();
                if ($("#contrasena").val() == $("#ccontrasena").val()) {


                $(".cargando").removeClass("hidden");
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('addJugador')}}',
                    data: formulario.serialize(),
                    success: function (data) {
                        if (data == "exito") {
                            $(".cargando").addClass("hidden");
                            $("#error").html('<div class="alert alert-success">' +
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                    '<strong>Perfecto!</strong> El Usuario fue creado revisa tu correo electronico para activar tu cuenta.' +
                                    '</div>');
                            formulario.reset();
                        }
                        else {
                            //alert("Se genero un error Interno");
                        }
                    },
                    error: function (data) {
                        var respuesta = JSON.parse(data.responseText);
                        var arr = Object.keys(respuesta).map(function (k) {
                            return respuesta[k]
                        });
                        var error = '<ul>';
                        for (var i = 0; i < arr.length; i++)
                            error += "<li>" + arr[i][0] + "</li>";
                        error += "</ul>";
                        $(".cargando").addClass("hidden");
                        $("#error").html('<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> Corrige los siguientes errores para continuar el registro:' +
                                '<p>' + error + '</p>' +
                                '</div>');
//                        $("#error").css("display", "block");
                    }
                });
            }else{
                    $("#error").html('<div class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            '<strong>Error!</strong> Las contraseñas ingresadas NO coinciden ' +

                            '</div>');
                }
            });

        });

    </script>
@endsection
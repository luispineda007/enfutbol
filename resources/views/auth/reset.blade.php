@extends('layouts.frontEnd.principal')

@section('css')
    <title>Olvide mi contraseña</title>

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
                    @if(!Auth::guest())
                        <a href="#" onclick="return false;" class="perfilUserCol  perfilUser hidden-sm hidden-md hidden-lg pull-right" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0"><img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;"></a>
                    @endif
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li ><a href="{{route("home")}}" ><span>Inicio</span></a></li>
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="work"><span>Buscar</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-contact" data-nav-section="contact"><span>Contact</span></a></li>
                        @if(Auth::guest())
                            <li><a href="{{route('myLoginModal')}}"   data-modal=""  ><span>Iniciar Sesión</span></a></li>
                        @else
                            <li><a href="{{route('logout')}}"><span>Cerrar Sesión</span></a></li>
                            <li  class="hidden-xs "><a href="#" onclick="return false;" class="perfilUser" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0"><img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;"></a></li>

                        @endif
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
                <div class="col-md-12 section-heading text-center">

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>Ingresa el correo asociado a tu cuenta</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    {!!Form::open(['route' => 'postReset','id'=>'canchastipo','class'=>'form-horizontal', 'method'=>'POST'])!!}

                                    {!! Form::hidden('token',$token,null) !!}

                                    <div class="form-group">
                                        {!! Form::label('correo', 'E-Mail',['class'=>'col-sm-3 control-label']) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                {{--{!! Form::text("email",null,['value'=>"{{old('email')}}",'class'=>'form-control']) !!}--}}
                                                <input type="email" id="correo" class="form-control" name="email" value="{{ old('email') }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group passNueva">
                                                {!! Form::label('password', 'Nueva',['class'=>'col-sm-4 control-label']) !!}
                                                <div class="col-sm-8">
                                                    {!!Form::password('password',['class'=>'form-control','placeholder'=>"Nueva contraseña",  'required' ])!!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group passNueva">
                                                {!! Form::label('password_confirmation', 'Confirmar',['class'=>'col-sm-4 control-label']) !!}
                                                <div class="col-sm-8">
                                                    {!!Form::password('password_confirmation',['class'=>'form-control','placeholder'=>"Confirmar contraseña" , 'required'])!!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration: none; color: #000;">&times;</a>
                                            <strong>Ups!</strong> Favor corregir los siguientes errores.<br><br>
                                            <ul class="text-left">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::submit('Restableser Contraseña!',['class'=>'btn btn-primary center-block']) !!}
                                        </div>
                                    </div>
                                    {!!Form::close()!!}


                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function() {
            $("#correo").blur(function () {
                expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if ($(this).val() != "") {
                    if (!expr.test($(this).val())) {
                        $(this).parent().addClass("has-error");
                        $(this).focus();
                    }
                    else {
                        $(this).parent().removeClass("has-error");
                        $(this).parent().addClass("has-success");
                    }
                }
                else {
                    $(this).parent().removeClass("has-error");
                    $(this).parent().removeClass("has-success");
                }
            });


/*            var formulario = $("#canchastipo");

            formulario.submit(function (e) {
                e.preventDefault();

                console.log(formulario.serialize());

            });*/



        });
    </script>
@endsection
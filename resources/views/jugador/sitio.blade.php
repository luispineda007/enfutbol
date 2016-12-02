@extends('layouts.frontEnd.principal')

@section('css')
    <title>Explorar Sitio</title>
    @if(isset($map))
        <script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}
    @endif

    {!!Html::style('plugins/sliceBox/css/slicebox.css')!!}
    {{--{!!Html::style('plugins/sliceBox/css/demo.css')!!}--}}
    {!!Html::style('plugins/sliceBox/css/custom.css')!!}
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">--}}
    <style>
        /*input[type="date"]{*/
            /*display: block;*/
            /*width: 100%;*/
            /*height: 34px;*/
            /*padding: 6px 12px;*/
            /*font-size: 14px;*/
            /*line-height: 1.42857143;*/
            /*color: #555;*/
            /*background-color: #fff;*/
            /*background-image: none;*/
            /*border: 1px solid #ccc;*/
        /*}*/

        .contenido{
            margin-bottom: 90px;
        }

        #fh5co-home, #fh5co-home .text-wrap, .imgSlider,  #sb-slider, .sb-current{
            height: 100%;
        }
        .imgSlider{
            width: 100%;
            height: 100%;
        }
        .der{
            border-bottom-right-radius: 9px;
            border-top-right-radius: 9px;
        }
        .izq{
            border-bottom-left-radius: 9px;
            border-top-left-radius: 9px;
        }
        .sb-slider{
            margin: 0;
        }
        .horario{
            padding-left: 0;
        }
        .pequeño{
            color: #bbbbbb;
            font-size: 14px;
        }
        .grande, .contenedor{
            background-color: #f5f2ff;
            cursor: default;
            /*padding-top: 5px;*/
        }
        .inter{
            line-height: 20px;
        }
        .opcion{
            background-color: #292929;
            padding: 5px;
        }
        .opcion:hover{
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        .mapa:hover .fa-map-marker{
            color: red;
        }

        .face:hover .fa-facebook-square{
            color: #354c98;
        }

        p{
            margin-bottom: 7px;
        }
        .mail:hover .fa-envelope{
            color: #f9de37;
        }

        .abierto{
            color: green;
        }

        .cerrado{
            color: red;
        }
        h1, h2{
            margin-bottom: 10px;
        }
        hr {
            /*display: block;*/
            border-style: inset;
            border-width: 1px;
        }
        .redondo{
            height: 37px;
            width: 37px;
            border: 2px solid #000000;
            border-radius: 50%;
            padding-right: 0px;
            font-size: 22px;
            margin-right: 10px;
        }
        .redondo{
            transition: all 0.5s ease;
        }
        .prim:hover{
            background-color: #354c98;
            color: white;
        }
        .twitt:hover{
            background-color: #55acee;
            color: white;
        }
        .correo:hover{
            background-color: #000000;
            color: white;
        }
        .contenedor{
            border: 1px solid #858585;
            border-radius: 5px;
            padding: 20px 15px 20px 15px;
        }
        .icono{
            width: 55px;
            height: 55px;
            border-radius: 15%;
            padding: 4px;
            cursor: default;
            border: 5px solid #059223;
            opacity: 1;
            transition: all 0.5s ease;
        }
        .cancha{
            width: 100px;
            height: 120px;

        }
        .opacar{
            opacity: 0.6;
        }
        .icono{
            margin-bottom: 20px;
        }
        @media (max-width: 499px) {
            #conteSlider{
                height: 320px;
            }
            #conteInfo{
                margin-top: 30px;
            }
            .detalleSitio{
                margin-top: 15px;
            }
            .cancha{
                margin-top: 20px;
            }
            .cancha{
                margin-bottom:5px;
            }
            .icono {
                margin-top: 20px;
                width: 45px;
                height: 45px;
            }
        }
        @media (min-width: 500px) and (max-width: 767px) {
            #conteSlider{
                height: 400px;
            }
            #conteInfo{
                margin-top: 30px;
            }
            .prim{
                margin-left: 10px;
            }
            .detalleSitio{
                margin-top: 15px;
            }
            .icono, .cancha{
                margin-top: 20px;
            }
            .cancha{
                margin-bottom:5px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            #conteSlider, .grande{
                height: 350px;
            }
            .grande{
                font-size: medium;
            }
            .intervalo{
                padding-left: 15px;
                padding-right: 0px;
            }
            .horario{
                padding-right: 0;
            }
            .prim{
                margin-left: 10px;
            }
            .detalleSitio{
                margin-top: 30px;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            #conteSlider, .grande{
                height: 450px;
            }
            .intervalo{
                padding-left: 40px;
            }
            .prim{
                margin-left: 40px;
            }
            #getMap{
                height: 190px;
            }
            .detalleSitio{
                margin-top: 30px;
            }
        }
        @media (min-width: 1200px){
            #conteSlider, .grande{
                height: 450px;
            }
            .intervalo{
                padding-left: 40px;
            }
            .prim{
                margin-left: 83px;
            }
            #getMap{
                height: 190px;
            }
            .detalleSitio{
                margin-top: 30px;
            }
        }
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
                        <a href="#" onclick="return false;" class="perfilUserCol  perfilUser hidden-sm hidden-md hidden-lg pull-right" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0">
                            @if(Auth::user()->rol=="admin")
                                <img src="{{URL::to('images/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                            @else
                                <img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                            @endif
                        </a>
                    @endif
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li ><a href="{{route("home")}}" ><span>Inicio</span></a></li>
                        <li><a href="{{route("buscar")}}"><span>Buscar</span></a></li>
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="home"><span>Sitio</span></a></li>
                        <li><a href="#" data-nav-section="contact"><span>Contacto</span></a></li>
                        @if(Auth::guest())
                            <li><a href="{{route('myLoginModal')}}"   data-modal=""  ><span>Iniciar Sesión</span></a></li>
                        @else
                            {{--<li><a href="{{route('logout')}}"><span>Cerrar Sesión</span></a></li>--}}
                            <li  class="hidden-xs ">
                                <a href="#" onclick="return false;" class="perfilUser" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0">
                                    @if(Auth::user()->rol=="admin")
                                        <img src="{{URL::to('images/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                                    @else
                                        <img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                                    @endif
                                </a>
                            </li>

                        @endif
                    </ul>
                </div>
            </nav>
            <!-- </div> -->
        </div>
    </header>
@endsection

@section('content')
    <section id="fh5co-home" data-section="home" style="background-image: url({{URL::to('images/full_image_2.jpg')}});" >
        <div class="gradient"></div>
        <div class="container">
            <div class="text-wrap contenido">
                <b><h1>{{$sitio->nombre}}</h1></b>
                {{--Estrellas del sitio--}}

                <div class="row">
                    <div class="col-sm-8">
                        <div class="wrapper" id="conteSlider">
                            <ul id="sb-slider" class="sb-slider">
                                @for($i=0;$i<count($sitio->getGaleria);$i++)
                                    @if($sitio->getGaleria[$i]->tipo != "portada")
                                        <li>
                                            <img src="../images/{{$sitio->getGaleria[$i]->foto}}" alt="image{{$i}}" class="imgSlider">
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                            <div id="shadow" class="shadow"></div>
                            <div id="nav-arrows" class="nav-arrows">
                                <a href="#">Next</a>
                                <a href="#">Previous</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4" id="conteInfo">
                        <div class="hidden-xs grande der">
                            <img class="img-rounded manito mapita" src="../images/editMap2.png" width="100%" data-toggle="tooltip" data-placement="auto bottom" title="Ubicar en mapa" id="getMap">
                            <div class="col-xs-12 intervalo" style="padding-top: 8px">{{$sitio->direccion}}<br> {{$municipio}}</div>



                            <div class="col-xs-12" style="padding-top: 10px">
                                <b>Horarios:</b>
                            </div>

                            @if($dia == "semana")
                                <div class="{{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['semana'], $hora))?'abierto':'cerrado'}}">
                                    <div class="col-sm-8 intervalo">Lunes a Viernes:</div>
                                    <div class="col-sm-4 horario">{{($sitio->getHorario["semana"]!="")?$sitio->getHorario["semana"]:"Cerrado"}}</div>
                                </div>
                            @else
                                <div class="col-sm-8 intervalo">Lunes a Viernes:</div>
                                <div class="col-sm-4 horario">{{($sitio->getHorario["semana"]!="")?$sitio->getHorario["semana"]:"Cerrado"}}</div>
                            @endif

                            @if($dia == "sabado")
                                <div class=" {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['sabado'], $hora))?'abierto':'cerrado'}}">
                                    <div class="col-sm-8 intervalo">Sabados:</div>
                                    <div class="col-sm-4 horario">{{($sitio->getHorario["sabado"]!="")?$sitio->getHorario["sabado"]:"Cerrado"}}</div>
                                </div>
                            @else
                                <div class="col-sm-8 intervalo">Sabados:</div>
                                <div class="col-sm-4 horario">{{($sitio->getHorario["sabado"]!="")?$sitio->getHorario["sabado"]:"Cerrado"}}</div>
                            @endif

                            @if($dia == "festivo")
                                <div class=" {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['festivo'], $hora))?'abierto':'cerrado'}}">
                                    <div class="col-sm-8 intervalo">Domingos:</div>
                                    <div class="col-sm-4 horario">{{($sitio->getHorario["festivo"]!="")?$sitio->getHorario["festivo"]:"Cerrado"}}</div>
                                </div>
                            @else
                                <div class="col-sm-8 intervalo">Domingos:</div>
                                <div class="col-sm-4 horario">{{($sitio->getHorario["festivo"]!="")?$sitio->getHorario["festivo"]:"Cerrado"}}</div>
                            @endif

                            <div class="col-xs-10 col-xs-offset-1" style="padding-top: 13px">

                                <div class="col-xs-4 redondo prim manito facebook" style="padding-left: 10px;" data-toggle="tooltip" data-placement="auto bottom" title="Ver perfil del sitio">
                                    <i class="fa fa-facebook"></i>
                                </div>

                                <div class="col-xs-4 redondo manito twitt" style="padding-left: 7px;" data-toggle="tooltip" data-placement="auto bottom" title="Ver pagina del sitio">
                                    <i class="fa fa-twitter"></i>
                                </div>

                                <div class="col-xs-4 redondo manito correo" style="padding-left: 6px;" data-toggle="tooltip" data-placement="auto bottom" title="Enviar mensaje al sitio">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>

                        </div>

                        <div class="hidden-md hidden-lg hidden-sm pequeño manito">
                            {{--<div class="row">--}}
                            <div class="col-xs-3 text-center opcion izq mapa mapita" data-toggle="tooltip" data-placement="auto bottom" title="Ubicar sitio en el mapa">
                                <div class="inter">
                                    <i class="fa fa-map-marker"></i><br>
                                    Mapa
                                </div>
                            </div>
                            <a href="#fullHoras" class="pequeño">
                                <div class="col-xs-3 text-center opcion" data-toggle="tooltip" data-placement="auto bottom" title="Ver todos los horarios">
                                    <div class="inter">
                                        <i class="fa fa-clock-o"></i><br>
                                        @if($dia == "sabado")
                                            {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['sabado'], $hora))?'Abierto':'Cerrado'}}
                                        @elseif($dia == "festivo")
                                            {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['festivo'], $hora))?'Abierto':'Cerrado'}}
                                        @else
                                            {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['semana'], $hora))?'Abierto':'Cerrado'}}
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <div class="col-xs-3 text-center opcion mail" data-toggle="tooltip" data-placement="auto bottom" title="Contactar con el sitio">
                                <div class="inter">
                                    <i class="fa fa-envelope"></i><br>
                                    E-mail
                                </div>
                            </div>
                            <div class="col-xs-3 text-center opcion der face facebook" data-toggle="tooltip" data-placement="auto bottom" title="Ver perfil del sítio">
                                <div class="inter">
                                    <i class="fa fa-facebook-square"></i><br>
                                    Facebook
                                </div>
                            </div>
                            {{--</div>--}}
                        </div>
                    </div>
                </div>

                <div class="row detalleSitio">
                    <div class="col-sm-12">
                        <div class="contenedor">
                            <h2><b>Detalles del sitio</b></h2>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Servicios Ofrecidos</b>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        @if($sitio->servicios!="")
                                            @for($i=0;$i<count($sitio->servicios);$i++)
                                                <div class="{{12/count($sitio->servicios >4)?'col-xs-3':'col-xs-2'}} col-sm-2 text-center">
                                                    <img src="../images/icons/{{$sitio->servicios[$i]}}.png" class="icono" data-toggle="tooltip" data-placement="auto bottom" id="{{$sitio->servicios[$i]}}">
                                                </div>
                                            @endfor
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Descripción</b>
                                </div>
                                <div class="col-sm-9">
                                    {!!($sitio->info_adicional!="")?$sitio->info_adicional:"Canchas sinteticas en excelentes condiciones, consulta nuestra disponibilidad seleccionando tu tipo de cancha favorito!"!!}
                                </div>
                            </div>

                            <hr class="hidden-md hidden-lg hidden-sm">
                            <div class="row hidden-md hidden-lg hidden-sm" id="fullHoras">
                                <div class="col-sm-3">
                                    <b>Ubicacion</b>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-xs-12 intervalo" style="padding-top: 8px">{{$sitio->direccion}}<br> {{$municipio}}</div>
                                </div>
                            </div>

                            <hr class="hidden-md hidden-lg hidden-sm">
                            <div class="row hidden-md hidden-lg hidden-sm" id="fullHoras">
                                <div class="col-sm-3">
                                    <b>Horarios de atencion</b>
                                </div>
                                <div class="col-sm-9">
                                    @if($dia == "semana")
                                        <div class="{{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['semana'], $hora))?'abierto':'cerrado'}}" data-toggle="tooltip" data-placement="auto bottom" title="{{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['semana'], $hora))?'Abierto ahora!':'Cerrado ahora'}}">
                                            <div class="col-sm-8 intervalo"><b>Lunes a Viernes:</b> {{($sitio->getHorario["semana"]!="")?$sitio->getHorario["semana"]:"Cerrado"}}</div>
                                        </div>
                                    @else
                                        <div class="col-sm-8 intervalo">Lunes a Viernes: {{($sitio->getHorario["semana"]!="")?$sitio->getHorario["semana"]:"Cerrado"}}</div>
                                    @endif

                                    @if($dia == "sabado")
                                        <div class=" {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['sabado'], $hora))?'abierto':'cerrado'}}" data-toggle="tooltip" data-placement="auto bottom" tittle="{{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['sabado'], $hora))?'Abierto ahora!':'Cerrado ahora'}}">
                                            <div class="col-sm-8 intervalo"><b>Sabados:</b> {{($sitio->getHorario["sabado"]!="")?$sitio->getHorario["sabado"]:"Cerrado"}}</div>
                                        </div>
                                    @else
                                        <div class="col-sm-8 intervalo">Sabados: {{($sitio->getHorario["sabado"]!="")?$sitio->getHorario["sabado"]:"Cerrado"}}</div>
                                    @endif

                                    @if($dia == "festivo")
                                        <div class=" {{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['festivo'], $hora))?'abierto':'cerrado'}}" data-toggle="tooltip" data-placement="auto bottom" title="{{(\App\Http\Controllers\UsuariosController::validarHoraDentroRango($sitio->getHorario['festivo'], $hora))?'Abierto ahora!':'Cerrado ahora'}}">
                                            <div class="col-sm-8 intervalo"><b>Domingos:</b> {{($sitio->getHorario["festivo"]!="")?$sitio->getHorario["festivo"]:"Cerrado"}}</div>
                                        </div>
                                    @else
                                        <div class="col-sm-8 intervalo">Domingos: {{($sitio->getHorario["festivo"]!="")?$sitio->getHorario["festivo"]:"Cerrado"}}</div>
                                    @endif
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                {!!Form::open(['route' => 'getCanchaXtipo', 'id'=>'formulario']) !!}
                                    <input type="text" value="{{$sitio->id}}" hidden name="sitio" id="sitio">
                                {!! Form::close() !!}
                                <div class="col-sm-3">
                                    <b>Canchas</b>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        @foreach($tipos as $tipo)
                                            <div class="col-xs-6 col-sm-3 text-center">
                                                <img src="../images/icons/fut{{$tipo->tipo}}.png" class="cancha manito" id="tipo{{$tipo->tipo}}" data-tipo="{{$tipo->tipo}}" data-toggle="tooltip" data-placement="auto bottom" title="Futbol {{$tipo->tipo}}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="mapaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ubicacion del sitio</h4>
                </div>
                <div class="modal-body">
                    @if(isset($map))
                        {!!$map['html']!!}
                    @else
                        dlsdjljjsdflkds
                    @endif
                </div>
                <div id="info"></div>
                <div class="modal-footer">
                    <div id="getinfo" class="hidden"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!!Html::script('plugins/sliceBox/js/modernizr.custom.46884.js')!!}
    {!!Html::script('plugins/sliceBox/js/jquery.slicebox.js')!!}
    <script charset="UTF-8">
        var slicebox;
        function ajuste(){
            var ancho= $(window).width();
            if (ancho == 976){
                $(".pequeño").css('display', 'none');
                $("#conteInfo").css('margin-bottom', '15px');
            }
            else {
                $(".pequeño").css('display', 'block');
            }
        }
        $(function () {
            ajuste();
            $(window).resize(function(){
               ajuste();
            });

            $(".mapita").on('click', function(){
                $("#mapaModal").modal("show");
            });

            $("#mapaModal").on("shown.bs.modal", function () {
                var currentCenter = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(currentCenter);
            });

            $(".facebook").click(function() {
                if ("{{$sitio->facebook}}" != "")
                    window.open("{{$sitio->facebook}}");
                else
                    window.open("https://www.facebook.com");
            });

            $(".twitt").click(function() {
                if ("{{$sitio->twitter}}" != "")
                    window.open("{{$sitio->twitter}}");
                else
                    window.open("https://twitter.com/?lang=es");
            });

            var servicios = "{{json_encode($sitio->servicios)}}";
            servicios = servicios.replace(/&quot;/gi, '');
            servicios = servicios.replace('[', '');
            servicios = servicios.replace(']', '');
            servicios = servicios.split(',');
            $.each(servicios, function(index, elemento){
                if(elemento != ""){
                    switch (elemento){
                        case "bano":
                            $("#bano").attr('title', "Baños");
                        break;
                        case "cafe":
                            $("#cafe").attr('title', "Cafetería");
                        break;
                        case "infantil":
                            $("#infantil").attr('title', "Zona Infantil");
                        break;
                        case "parqueo":
                            $("#parqueo").attr('title', "Parqueadero");
                        break;
                        case "piscina":
                            $("#piscina").attr('title', "Piscina");
                        break;
                        case "wifi":
                            $("#wifi").attr('title', "Wi-fi");
                        break;
                        case "restaurant":
                            $("#restaurant").attr('title', "Restaurante");
                        break;
                        case "bar":
                            $("#bar").attr('title', "Bar");
                        break;
                        case "gym":
                            $("#gym").attr('title', "Gimnasio");
                        break;
                        case "estadero":
                            $("#estadero").attr('title', "Estadero");
                        break;
                        case "extremo":
                            $("#extremo").attr('title', "Deportes Extremos");
                        break;

                    }
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
            var Page = (function() {
                var $navArrows = $( '#nav-arrows' ).hide(),
                        $shadow = $( '#shadow' ).hide(),
                        slicebox = $( '#sb-slider' ).slicebox( {
                            onReady : function() {

                                $navArrows.show();
                                $shadow.show();

                            },
                            orientation : 'r',
                            cuboidsRandom : true,
                            disperseFactor : 30,
                            autoplay : true,
                            interval: 4000
                        } ),

                        init = function() {

                            initEvents();

                        },
                        initEvents = function() {
                            // add navigation events
                            $navArrows.children( ':first' ).on( 'click', function() {

                                slicebox.next();
                                slicebox.play();
                                return false;

                            } );
                            $navArrows.children( ':last' ).on( 'click', function() {

                                slicebox.previous();
                                slicebox.play();
                                return false;

                            } );
                        };

                return { init : init };

            })();
            Page.init();


            $(".cancha").click(function() {
                var tipo = $(this).attr("data-tipo");
                $("#tipo").remove();
                $("#formulario").append('<input type="text" value="'+tipo+'" hidden name="tipo" id="tipo">');
                $("#formulario").submit();
            });

            {{--if(sessionStorage.getItem('sitio') == "{{$sitio->id}}"){--}}
                {{--$(".cancha").addClass("opacar");--}}
                {{--$("#tipo"+sessionStorage.getItem('tipo')).removeClass("opacar");--}}
            {{--}--}}

        });
    </script>
@endsection
@extends('layouts.frontEnd.principal')

@section('css')
    <title>Buscar Sitios</title>
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <!-- Bootstrap time Picker -->
    {!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}
    <!-- DataTables -->
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}



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
            margin-bottom: 25px;

        }
         #fh5co-work {
            padding: 4em 0;
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
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="work"><span>Buscar</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-about" data-nav-section="services"><span>Aliados</span></a></li>
                        <li><a href="{{route("home")}}#fh5co-contact" data-nav-section="contact"><span>Contacto</span></a></li>
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

    <section id="fh5co-work" data-section="work" class="work" style="background-image: url({{URL::to('images/full_image_2.jpg')}});">
        <div class="gradient"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center">

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>Permítenos encontrar la cancha que necesitas:</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">

                            {!!Form::open(['route' => 'getCanchasBusqueda','id'=>'canchastipo','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('tipo', 'Tipo de Cancha',['class'=>'hidden-xs hidden-sm']) !!}

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        {!!Form::select('tipo', ['11' => 'Futbol 11', '10' => 'Futbol 10', '9' => 'Futbol 9', '8' => 'Futbol 8', '7' => 'Futbol 7', '6' => 'Futbol 6', '5' => 'Futbol 5'], $tipo, ['class'=>"form-control",'placeholder' => 'Selecciona un tipo..', 'required'])!!}
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('fecha', 'Fecha',['class'=>'hidden-xs hidden-sm']) !!}

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="fecha" class="form-control pull-right manito" id="fecha" placeholder="Fecha.." readonly value="{{$fecha}}">

                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label class='hidden-xs hidden-sm'>Hora</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input id="hora" name="hora" type="text" class="form-control timepicker manito" readonly placeholder="Hora.." value="{{$hora}}" >
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>

                            {!!Form::close()!!}
                        </div>
                    </div>
                </div>

                <div class="row row-bottom-padded-sm" id="sitios">
                    {{--<div class="row">--}}
                        <div class="col-xs-12">
                            @if($tipo)
                            <h3 id="tituloResultado"> Resultados de la Busqueda</h3>
                                @else
                                <h3 id="tituloResultado"> Nuestros sitios recomendados</h3>
                            @endif
                        </div>

                    {{--</div>--}}

                    <div id="itemSitios">

                    @if(empty($sitios))

                            <div class="row">
                                <div class="col-xs-12">
                                    <h3 class="text-center">No encontramos un lugar en donde jugar en esta  hora y fecha</h3>
                                </div>

                            </div>
                    @else



                    @endif


                    @foreach($sitios as $sitio)
                        <div class="col-md-4 col-sm-6 col-xxs-12">
                            <a href="sitio/{{$sitio["id_sitio"]}}"  class="fh5co-project-item to-animate perfiSitio" data-id="{{$sitio["id_sitio"]}}">
                                <img src="images/{{$sitio["portada"]}}" alt="Image" class="img-responsive portada">
                                <div class="fh5co-text">
                                    <h2>{{$sitio["nombre"]}}</h2>
                                    @if($tipo!="")
                                        <span > <b>{{$sitio["dispo"]}}</b> {{($sitio["dispo"]==1)?"cancha disponible":"canchas disponibles"}} </span>
                                    @else

                                        @for($i=0;$i<$sitio["ranking"];$i++)
                                            <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #f59831"></span>
                                        @endfor
                                        @for($i=$sitio["ranking"];$i<5;$i++)
                                            <span class="glyphicon glyphicon-star-empty" aria-hidden="true" style="color: #fecf93"></span>
                                        @endfor

                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <!-- bootstrap datepicker -->
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <!-- bootstrap time picker -->
    {!!Html::script('plugins//timepicker/bootstrap-timepicker.min.js')!!}
    <!-- DataTables -->
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}

    <script>
    var tipo, fecha, hora;
        $(function () {
            sitiosCanchas(0,"2016-02-02","12");


            $("#fh5co-header").addClass("navbar-fixed-top fh5co-animated slideInDown");

            $(".timepicker").timepicker({
                showInputs: false,
                showSeconds: false,
                showMeridian: false,
                minuteStep:60,
                defaultTime:false
            }).on('hide.timepicker', function(e) {
                if($("#tipo").val()!=""&&$("#fecha").val()!="") {

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),e.time.hours);
                    //console.log('funcioc( ' + $("#tipo").val() + "  , " + $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , " + e.time.hours + " )");
                }
            }).on('show.timepicker', function(e) {

                if($('#hora').val()=="")
                    $('#hora').timepicker('setTime', '12:00');
            });

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
            $('#fecha').datepicker({
                autoclose: true,
                todayHighlight:true,
                startDate:'+0d',
                endDate:'+15d',
                language: 'es'
            }).on('changeDate', function () {

                if($("#tipo").val()!=""&&$("#hora").val()!=""){

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });

            $("#tipo").change(function () {

                if($("#hora").val()!=""&&$("#fecha").val()!=""){

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });


        });

        /*        $('#hora').on('changeTime.timepicker', function(e) {
         console.log('The hour is ' + e.time.hours+"----"+ $("#fecha").getDates);
         });*/


        function sitiosCanchas(tipoBuscar,fechaBuscar,horaBuscar) {
            tipo = tipoBuscar;
            fecha= fechaBuscar;
            hora = horaBuscar;
            if(tipoBuscar&&fechaBuscar&&horaBuscar!=null){


               //console.log('funcioc( ' + tipo+"  , "+ fecha + " , "+ hora +" )");
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route("getCanchasBusqueda")}}',
                    data:{"tipo":tipoBuscar,"fecha":fechaBuscar,"hora":horaBuscar,"ajax":true},
                    success: function(data){
                        console.log(data);
                        console.log(data.fecha);

                        if(data.fecha){
                            $("#itemSitios").empty();
                            $("#tituloResultado").html("Resultados de la Busqueda");
                            if(data.sitios.length==0){
                                var html = "<div class='row'>"+
                                        "<div class='col-xs-12'>"+
                                        "<h3 class='text-center'>No encontramos un lugar en donde jugar en esta  hora y fecha</h3>"+
                                        "</div>"+
                                        "</div>";
                                $("#itemSitios").append(html);
                            }else{
                                $(data.sitios).each(function (index,elemento) {
                                    console.log(elemento);

                                    console.log(elemento["id_sitio"]);

                                    var dispoCancha = (elemento["dispo"]==1)?' cancha disponible':' canchas disponibles';

                                    var html =  "<div class='col-md-4 col-sm-6 col-xxs-12'>"+
                                            "<a href='#' onclick='return false;' class='fh5co-project-item to-animate perfiSitio' data-id='"+elemento["id_sitio"]+"'>"+
                                            "<img src='images/"+elemento["portada"]+"' alt='Image' class='img-responsive portada'>"+
                                            "<div class='fh5co-text'>"+
                                            "<h2>"+elemento["nombre"]+"</h2>"+
                                            "<span ><b>"+elemento["dispo"]+"</b>"+ dispoCancha+" </span>"+
                                            "</div>"+
                                            "</a>"+
                                            "</div>";

                                    $("#itemSitios").append(html);



                                });
                            }

                        }

                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            }


        }

        $("#sitios").on("click",".perfiSitio",function () {
            sessionStorage.setItem("sitio",$(this).data("id"));
            sessionStorage.setItem("tipo",tipo);
            sessionStorage.setItem("fecha",fecha);
            sessionStorage.setItem("hora",hora);
            window.location="sitio/"+$(this).data("id");
        });




    </script>

@endsection
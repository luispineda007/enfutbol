@extends('layouts.frontEnd.principal')

@section('css')
    <title>Mis Reservas</title>
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <!-- Bootstrap time Picker -->
    {!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}
    <!-- DataTables -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">


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

        .btn-danger:hover, .btn-danger:active, .btn-danger:focus {
            background: rgba(255, 88, 83, 0.66) !important;
            color: #ffffff !important;
            outline: none !important;
        }
        
        .btn-danger{
            color: #d3d3d3 !important;
        }
        .cargando{
            font-size: 16px;
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
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="work"><span>Mis Reservas</span></a></li>
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


                <div class="panel panel-default" style="position: relative;">
{{--                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 style="margin-bottom: 12px;">Usuario: {{Auth::user()->user}}<a class="btn btn-default pull-right" href="{{route('logout')}}" role="button" style="text-decoration: none;">Cerrar Sesión</a></h3>
                            </div>

                        </div>


                    </div>--}}
                    <div class="panel-body">

                        <div class="row">
                            <h3 class="text-center">Mis reservas</h3>
                        </div>

                        <div class="row">

                            @foreach($reservas as $reserva)

                            <div id="{{$reserva->id}}" class="col-sm-6">
                            <div class="panel panel-default" style="position: relative;">
                                <div class="panel-body">

                                        <div class="row">
                                            <div class="col-xs-6  col-sm-5">
                                                <img src="{{URL::to('images/'.$reserva->foto)}}" alt="..." class="img-responsive">
                                            </div>
                                            <div class="col-xs-6 col-sm-7">

                                                <h3 class="text-center" style="margin-bottom: 12px"><a href="{{route("getSitio", $reserva->id_sitio)}}" style="text-decoration: none;"> {{$reserva->sitio}} </a></h3>
                                                <div class="col-sm-4"> <b>Cancha</b> </div>
                                                <div class="col-sm-8">{{$reserva->nombre}} </div>

                                                <div class="col-sm-4"> <b>Tipo</b> </div>
                                                <div class="col-sm-8">Futbol {{$reserva->tipo}} </div>

                                                <div class="col-sm-4"> <b>fecha</b> </div>
                                                <div class="col-sm-8">{{$reserva->fecha}} </div>

                                                <div class="col-sm-4"> <b>Hora</b> </div>
                                                <div class="col-sm-8">{{$reserva->hora}}:00</div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <a class="btn btn-danger pull-right cancel" href="#" onclick="return false;" role="button" style="margin-right: 20px; margin-top: 15px; text-decoration: none;" data-id="{{$reserva->id}}" data-cancha="{{$reserva->nombre}}" data-fecha="{{$reserva->fecha}}" data-hora="{{$reserva->hora}}">Cancelar Reserva
                                            <i id="i{{$reserva->id}}" class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>
                                            <span class="sr-only">Loading...</span>
                                        </a>
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
    </section>


    <div id="modalCancelReserva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel-warning">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Cancelar Reserva</h4>
                </div>
                <div class="modal-body">
                    <p id="msjConfirmar">  </p>

                    <div id="alertC">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                    <button id="confirmarCancel" type="button" class="btn btn-warning">Confirmar
                        <i id="carga" class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>
                        <span class="sr-only">Loading...</span>
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" id="modalErrorCancelReserva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content panel-danger">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Lo sentimos!</h4>
                </div>
                <div class="modal-body text-center">
                    Esta acción solo se puede realizar con 4 horas de anterioridad.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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

            $("#fh5co-header").addClass("navbar-fixed-top fh5co-animated slideInDown");


            var id;
            $(".cancel").click(function () {
                id= $(this).data("id");
                $("#msjConfirmar").html("Realmente deseas cancelar la reserva en <b>"+$(this).data("cancha")+"</b> el dia <b>"+$(this).data("fecha")+"</b> a las <b>"+$(this).data("hora")+":00</b>");
                //console.log(id);
                $("#i"+id).removeClass("hidden");
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route("cancelReservaUser")}}',
                    data:{"id":id},
                    success: function(data){
                        //console.log(data.bandera);
                        $("#i"+id).addClass("hidden");
                        if(data.bandera){
                            $("#modalCancelReserva").modal("show");
                        }else{
                            $("#modalErrorCancelReserva").modal("show");
                        }

                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });

            $("#confirmarCancel").click(function () {

                //console.log("se cancelara la reserva numero "+id);
                $("#carga").removeClass("hidden");
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route("cancelReservaUser")}}',
                    data:{"id":id,"cancel":id},
                    success: function(data){
                        console.log(data);
                        $("#carga").addClass("hidden");
                        if(data.bandera){

                            $("#alertC").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Perfecto!</strong> su reserva fue cancelada con exito </div>");
                            $("#confirmarCancel").addClass("hidden");
                            setTimeout(function(){
                                $("#modalCancelReserva").modal("hide");
                                $("#"+id).remove();
                                $("#confirmarCancel").removeClass("hidden");
                            } , 2000);

                        }else{
                            $("#alertC").html("<div class='alert alert-success'>"+
                                             +"<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>"+
                                             +"<strong>Lo sentomos!</strong> No fue posible realizar esta acción por favor intentarlo más tarde </div>");
                        }

                    },
                    error: function(){
                        console.log('ok');
                    }
                });

            });



        });








    </script>

@endsection
@extends('layouts.frontEnd.principal')

@section('css')
    <title>Cancha Tipo </title>
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}

    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
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
        .itemCancha{
            background-color: mintcream;
            margin-bottom: 5px;
            padding: 20px;
            border-radius: 5px;
        }




        .fotoCancha {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .fotoCancha:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 100000; /* Sit on top */
            padding-top: 50px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            position: relative;
            margin: auto;
            display: block;
            z-index: 100001;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)}
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .cerrar {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .cerrar:hover,
        .cerrar:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }


.btn{
    margin-right: 20px;
}
        .dia{
            box-shadow: 10px 10px 8px #414141;
        }

        .rotar1{
            /* Safari */
            -webkit-transform: rotate(-80deg);
            /* Firefox */
            -moz-transform: rotate(-80deg);
            /* IE */
            -ms-transform: rotate(-80deg);
            /* Opera */
            -o-transform: rotate(-80deg);
            /* Internet Explorer */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
            position: relative;
            top: 70px;
        }

        .fechaDispo{
            font-size: 14px;
        }
        #dispoInical{
            padding-left: 0px;
            padding-right: 0px;

        }

        #dispoMedio{
            margin-top: 20px;
            padding-left: 0px;
            padding-right: 0px;

        }

        #dispoFinal{
            margin-top: 30px;
            padding-left: 0px;
            padding-right: 0px;

        }

        .disponibilidad{
            font-size: 14px;
            border: solid 1px #232323;
        }


        .dispoInical{
            font-size: 15px;
        }

        .dispoMedio{

        }

        .dispoFinal{

        }

        .dispoHoy{
            color: #ffffff;
            background-color: #009508
        }
        .dispoHoy:hover{
            color: #ffffff;
            background-color: rgba(0, 119, 8, 0.7)
        }

        .dispofut{
            color: #ffffff;
            background-color: rgba(0, 149, 8, 0.50)
        }

        .diaSeleccion{
            color: #040404;
            background-color: rgba(240, 255, 12, 0.47)
        }
        .dispofut:hover{
            color: #ffffff;
            background-color: rgba(0, 131, 8, 0.71)
        }



        .noDispoHoy{
            color: #ffffff;
            background-color: #FF0F00;
            cursor: default;
        }

        .noDispofut{
            color: #ffffff;
            background-color: rgba(255, 15, 0, 0.50);
            cursor: default;
        }

        .cerrado{
            color: #ffffff;
            background-color: rgba(57, 57, 57, 0.65);
            cursor: default;
        }


        .horaPasado{

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
                        <li><a href="{{route("buscar")}}#fh5co-work" data-nav-section="work"><span>Buscar</span></a></li>
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="home"><span>Registro</span></a></li>
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
    <section id="fh5co-home" data-section="home" style="background-image: url(images/full_image_2.jpg);" >
        <div class="gradient"></div>
        <div class="container">
            <div class="text-wrap contenido">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="to-animate fadeInUp animated text-center">Futbol {{$canchas[0]->tipo}}</h1>
                    </div>
                </div>


                @foreach($canchas as $cancha)
                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="col-sm-4">
                                <img src="images/{{$cancha->foto}}" alt="Image" class="img-responsive fotoCancha">
                            </div>
                            <div class="col-sm-8">

                                <h3 class="text-center">{{$cancha->nombre}}</h3>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <p><b>Descripción: </b>{{$cancha->descripcion}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <b>Precio Base: <i class="fa fa-usd" aria-hidden="true"></i> {{$cancha->precio_base}}</b>
                                    </div>
                                    <div class="col-sm-6">
                                        Recargo Nocturno: <i class="fa fa-usd" aria-hidden="true"></i><b> {{$cancha->precio_nocturno}}</b>
                                    </div>
                                    <div class="col-sm-6">
                                        Recargo Festivo: <i class="fa fa-usd" aria-hidden="true"></i><b> {{$cancha->precio_festivo}}</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <a class="btn btn-default pull-right ver" href="#" role="button" data-precio="{{$cancha->precio_base}}" data-noche="{{$cancha->precio_nocturno}}" data-festivo="{{$cancha->precio_festivo}}" data-id="{{$cancha->id}}" data-nombre="{{$cancha->nombre}}" >Ver Disponibilidad</a>
                            </div>
                        </div>
                    </div>

                @endforeach


            </div>
        </div>
        <div class="slant"></div>
    </section>



    <!-- Modal -->
    <div class="modal fade " id="ModalDisponibilidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div id="modal-lg" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Disponibilidad </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div id="col-6" class="col-sm-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="fecha" class="form-control pull-right manito manito" id="fecha" placeholder="Fecha" readonly value="">
                                </div>
                            </div>
                            <div  class="col-sm-12" id="dispo">



                            </div>
                        </div>
                    </div>
                    <div id="resumen" class="col-sm-6 hidden" style="margin-top: 35px;">
                        <div class="row">

                        <h3 class="text-center">Resumen de la Reserva</h3>

                        <div class="row">
                            <div class="col-xs-4 text-right"><b>Fecha:</b></div>
                            <div id="divFecha" class="col-xs-8"></div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 text-right"><b>Hora:</b></div>
                            <div id="divHora" class="col-xs-8"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 text-right"><b>Cancha:</b></div>
                            <div id="divCancha" class="col-xs-8"> </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 text-right"><b>Precio:</b></div>
                            <div id="divPrecio" class="col-xs-8"></div>
                        </div>

                            <div id="alertC">



                            </div>

                        <div class="row">
                            <div class="col-sm-offset-1 col-sm-10 col-md-offset-2 col-sm-8 text-center">
                                @if(Auth::guest())

                                    <a class="btn btn-primary" href="#" role="button" onclick="return false;" id="sesion">Iniciar Sesión</a>
                                @else

                                    @if(\App\Http\Controllers\UsuariosController::getInfoToken($canchas[0]->id_sitio)["bandera"])


                                            <a class="btn btn-primary " href="#" role="button" onclick="return false;" id="confirmarReserva" style="margin: 0px auto;">Confirmar Reserva</a>

                                        @else

                                            <div class="col-xs-12">
                                                <div class="alert alert-danger">
                                                    <strong>{{\Auth::user()->getPersona->nombres}}</strong> {{\App\Http\Controllers\UsuariosController::getInfoToken($canchas[0]->id_sitio)["respuesta"]}}
                                                </div>
                                            </div>

                                    @endif



                                @endif
                            </div>
                        </div>


                    </div></div>
                </div>
                </div>
{{--                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>--}}
            </div>
        </div>
    </div>



@endsection

@section('js')
    <!-- bootstrap datepicker -->
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}


    <script>
         var id,tipo,precio,noche,festivo,fecha,hora;
        $(function(){



            $(".fotoCancha").click(function () {
                $('#myModal').css("display","block");
               // modal.style.display = "block";
                $("#img01").attr( "src", this.src );
                //modalImg.src = this.src;
                //captionText.innerHTML = this.alt;
            });
            $(".close").click(function () {
                $('#myModal').css("display","none");
            });
            $("#myModal").click(function () {
                $('#myModal').css("display","none");
            });


            //var id;
            $(".ver").click(function () {

                id = $(this).data("id");
                tipo = $(this).data("tipo");
                precio=$(this).data("precio");
                noche=$(this).data("noche");
                festivo=$(this).data("festivo");


                $("#myModalLabel").html("Selecciona el día y la hora para jugar");
                $("#divCancha").html($(this).data("nombre"));


                //console.log($(this).data("id"));
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route("disponibilidades")}}',
                    data:{"tipo":tipo,"id":id},
                    success: function(data){
                        //console.log(data);
                        llenarDispo(data);
                        $('#ModalDisponibilidad').modal('show');

                    },
                    error: function(){
                        console.log('ok');
                    }
                });
                return false;

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
                //console.log(id);
                    //console.log($("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'));
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route("disponibilidades")}}',
                    data:{"tipo":tipo,"id":id,"fecha":$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd')},
                    success: function(data){

                        llenarDispo(data);
                    },
                    error: function(){
                        console.log('ok');
                    }
                });

            });

       });

var horaActual = "{{$horaActual}}";
         var hoy = "{{$hoy}}";

         horaActual= parseInt(horaActual);
         var banderaHoraBrir = true;
        function llenarDispo(data) {
            var horasPasado=true;
            //console.log(data);
            $("#dispo").empty();
            $(data).each(function (index,elemento) {
               //console.log(elemento.reservas);

                //console.log(index +"->" +(data.length-1)+"->"+ elemento.fecha+"->"+ elemento.horario+"->"+ elemento.reservas);
                colum = 12/data.length;
                valorid= (index==0)?"dispoInical":((index==(data.length-1))?"dispoFinal":"dispoMedio");
                html = "<div id='"+valorid+"' class='col-xs-"+colum+" text-center'> <samp class='fechaDispo center-block' >"+ elemento.fecha+"</samp>" ;


                if(elemento.horario=="abierto"){
                    html+="<div class='dia' data-fecha='"+elemento.fecha+"' data-festivo='"+elemento.festivo+"'>";
                    $.each(elemento.reservas,function (i,item) {

                        if(banderaHoraBrir){
                            console.log(i, horaActual);
                            if(i>horaActual)
                                horasPasado= false;
                            banderaHoraBrir=false;
                        }

                       // console.log(i, item);
                        if (item == "") {
                            html += "<samp class='disponibilidad center-block " + valorid + " " + ((index == 0) ? ((horasPasado && hoy == elemento.fecha) ? "cerrado" : "dispoHoy manito") : "dispofut manito") + "' data-hora='" + i + "'> " + ((i.length < 2) ? "0" + i + ":00" : i + ":00") + "</samp>";
                        } else {
                            html += "<samp class='disponibilidad center-block " + valorid + " " + ((index == 0) ? ((horasPasado && hoy == elemento.fecha) ? "cerrado" : "noDispoHoy") : "noDispofut") + "'> " + ((i.length < 2) ? "0" + i + ":00" : i + ":00") + "</samp>";
                        }

                        if(i==horaActual)
                            horasPasado= false;

                    });
                }else{
                     html+="<div class='dia cerrado' style='height: 180px'><div class='rotar1 container-fluid'> C E R R A D O </div> ";
                }

                html += "</div></div>";
                $("#dispo").append(html);

            });
        }

var elementoHora;
        $("#dispo").on("click",".manito",function () {


            elementoHora=$(this);

            //console.log($(this).data("hora"));
            hora = $(this).data("hora");
            fecha = $(this).parent().data("fecha");
            $("#divHora").html(((hora.length<2)?"0"+hora+":00":hora+":00"));

            $("#divFecha").html(fecha);

            var precioCancha = precio;
            precioCancha= (hora>18||hora<5)?precioCancha+noche:precioCancha;
            precioCancha= ($(this).parent().data("festivo"))?precioCancha+festivo:precioCancha;
            //console.log(precioCancha);
            $("#divPrecio").html(precioCancha);


            $(".disponibilidad").each(function (index,elemento) {
                $(elemento).removeClass("diaSeleccion");
            });

            $(this).addClass("diaSeleccion");


            //console.log($(this).parent().data("fecha"));
            $("#modal-lg").addClass("modal-lg");
            $("#col-6").addClass("col-sm-6").removeClass("col-sm-12");
            $("#resumen").addClass("show").removeClass("hidden");
            $("#resumen").effect( "slide", null, 500, callback );
            //


        });

         $('#ModalDisponibilidad').on('hidden.bs.modal', function (e) {
             $("#modal-lg").removeClass("modal-lg");
             $("#col-6").addClass("col-sm-12").removeClass("col-sm-6");
             $("#resumen").addClass("hidden").removeClass("show");
         })



        $("#confirmarReserva").on("click",function () {
           // console.log("hora: "+hora+" , fecha : "+fecha+" id_cancha : "+id);
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route("addNuevaReservaUsuario")}}',
                data:{"id_cancha":id,"hora":hora,"fecha":fecha},
                success: function(data){

                    if(data["estado"]){
                        if(data["tipo"]=="normal"){
                            $("#alertC").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Perfecto!</strong> su reserva fue exito </div>");

                            setTimeout(function(){
                                $("#confirmarReserva").modal("hide");
                                location.href="{{route("misReservas")}}";
                            } , 2000);


                        }else{
                            $(elementoHora).addClass("noDispoHoy").removeClass("dispoHoy");
                        }
                    }

                },
                error: function(){
                    console.log('ok');
                }
            });
        });



         // Callback function to bring a hidden box back
         function callback() {
          setTimeout(function() {
          $( "#resumen" ).removeAttr( "style" ).hide().fadeIn();
          }, 1000 );
          }





        $("#sesion").on("click",function () {

            location.href="auth/login";

        });


    </script>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="cerrar">×</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
@endsection
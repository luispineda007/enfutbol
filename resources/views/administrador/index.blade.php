@extends('layouts.principal')

@section('css')
    <link href="plugins/bootstrapFileInput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    {{--<script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}--}}
    <style>
        /*.titulo{*/
            /*font-family: "Homer Simpson", cursive;*/
        /*}*/
        .item{
            padding-top: 7px;
        }
        .lugar{
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .editProfPic{
            position:absolute;
            bottom:0;
            z-index:1;
            text-align: right;
            padding-bottom: 9px;
            color: #0c0c0c;
            right: 0;
            padding-right: 15px;
        }
        .tema{
            margin-left: 20px;
            margin-right: 20px;
        }
        .bordered{
            border: solid 1px #040604;
            border-radius: 5px;
        }
        .icocontenido{
            margin-top: 7px;
            cursor: pointer;
        }
        .contenedorFoto{
            padding-left: 0px;
            padding-right: 0px;
            margin-bottom: 5px;
        }
        .foto{
            margin-left: 2px;
            height: 100%;
            margin-right: 2px;
        }
        #horarios{
            margin-top: 10px;
            margin-left: 15px;
        }
        #horarios > p {
            margin-bottom: 3px;
        }
        .resaltar{
            color: #ef1700;
        }
        .editHora:hover{
            cursor: pointer;
        }
        .icono{
            width: 55px;
            height: 55px;
            border-radius: 15%;
            padding: 4px;
            cursor: pointer;
            border: 5px solid #059223;
            /*background-color: #1e3dc5;*/
            opacity: 1;
            transition: all 0.5s ease;
        }
        .desact{
            border: 2px solid #828282;
            background-color: white;
            opacity: 0.4;
        }
        img[class="icono desact"]:hover{
            border: 5px solid #059223;
            opacity: 0.8;
        }
        .icono:hover{
            border: 2px solid #828282;
            background-color: white;
            opacity: 0.4;
        }
        .eliminar{
            background-color: rgba(195, 195, 195, 0.46);
            border-radius: 50%;
            padding: 5px;
        }
        .eliminar:hover{
            background-color: rgb(251, 255, 255);
        }
        .icono{
            margin-bottom: 10px;
        }
        .facebook, .has-success .facebook, .has-error .facebook {
            background-color: #354c98;
            color: white;
        }
        .twitt, .has-success .twitt, .has-error .twitt{
            background-color: #55acee;
            color: white;
            padding-right: 10px;
            padding-left: 10px;
        }
        .seccion{
            margin-bottom: 15px;
        }
        .has-error .form-control {
            background-color: rgba(249, 0, 0, 0.06);
        }
        .has-success .form-control{
            background-color: rgba(0, 169, 0, 0.14);
            color: black;
        }
        .form-group{
            margin-bottom: 0px;
        }
        @media (max-width: 445px) {
            .titulo{
                font-size: 15pt;
            }
            .item{
                font-size: 14px;
            }
            .editHora{
                font-size: 13px;
            }
            .contenedorFoto{
                height: 150px;
            }
            #divFotoPerfil{
                margin-left: 25%;
                margin-right: 25%;
            }
            .kv-avatar{
                margin-left: 0;
            }
            /*.centrar{*/
                /*width : 180px;*/
                /*margin-left : auto;*/
                /*margin-right : auto;*/
            /*}*/
            .center{
                text-align: center;
            }
        }
        @media (min-width: 446px) and (max-width: 767px) {
            #divFotoPerfil{
                margin-left: 25%;
                margin-right: 25%;
            }
        }
        @media (min-width: 446px) and (max-width: 851px) {
            .titulo{
                font-size: 17pt;
            }
            .item{
                font-size: 16px;
            }
            .editHora{
                font-size: 15px;
            }
            .contenedorFoto{
                height: 190px;
            }
            .kv-avatar{
                margin-left: 0;
            }
            .centrar{
                width : 180px;
                margin-left : auto;
                margin-right : auto;
            }
            .center{
                text-align: center;
            }

        }

        @media (min-width: 852px) and (max-width: 991px) {
            .titulo{
                font-size: 19pt;
            }
            .item{
                font-size: 16px;
            }
            .editHora{
                font-size: 15px;
            }
            .galeria{
                margin-left: 5px;
                margin-right: 5px;
            }
            .contenedorFoto{
                height: 190px;
            }
            .kv-avatar{
                width: 190px;
                margin-left: auto
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .titulo{
                font-size: 25px;
            }
            .item{
                font-size: 18px;
            }
            .editHora{
                font-size: 17px;
            }
            .galeria{
                margin-left: 10px;
                margin-right: 10px;
            }
            .contenedorFoto{
                height: 180px;
            }
            .kv-avatar{
                width: 240px;
                margin-left: auto
            }
        }
        @media (min-width: 1200px){
            .titulo{
                font-size: 27px;
            }
            .item{
                font-size: 20px;
            }
            .editHora{
                font-size: 19px;
            }
            .galeria{
                margin-left: 15px;
                margin-right: 15px;
            }
            .contenedorFoto{
                height: 170px;
            }
            .kv-avatar{
                width: 300px;
                margin-left: auto
            }
        }
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }
        .kv-avatar .file-input {
            display: table-cell;
        }
        h4{
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .view{
            color: rgba(187, 185, 164, 0.7);
            opacity: .6;
            font-weight: 500;

        }

        #map{
            width: 100%;
            height: 400px;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Gestionar perfil del sitio <small data-toggle="tooltip" data-placement="auto bottom" title="Ver como usuario" class="close view">(Ver)</small></h4>
                </div>
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 30px">
                        <div class="col-xs-6 text-right" id="divFotoPerfil" style="margin-bottom: 15px">
                            <form class="text-center" method="post" enctype="multipart/form-data" id="nuevo">
                                <div class="kv-avatar" id="conteFU">
                                    <input id="avatar-1" name="avatar-1" type="file" class="file-loading" accept='image/*'>
                                </div>
                            </form>
                            <div id="kv-avatar-errors-1" class="center-block" style="display:none; margin-top: 15px"></div>
                        </div>

                        <div class="col-xs-12 col-sm-6 center" data="{{$sitio->id}}" id="infoSitio">
                                <i class="fa fa-futbol-o fa-2x"></i><b><span class="titulo"> {{$sitio->nombre}}</span></b>
                            <div class="col-xs-12 item lugar" >
                                <i class="fa fa-map-marker"></i><span class="manito" id="ubicar" style="color: #0000C2"><b data-toggle="tooltip" data-placement="auto bottom" title="Dirección y ubicación del sitio"> Configurar</b></span>
                            </div>
                            <div class="item" id="conteHorario">
                                @if($horario->semana == "" && $horario->sabado == "" && $horario->festivo == "")
                                    <i class="fa fa-clock-o"></i><b> Horarios:</b> <a href="{{route('editHorarios')}}"  data-modal="" data-toggle="tooltip" data-placement="auto bottom" title="Horarios del sitio" class="editHora resaltar"><b>Configurar</b></a>
                                @else
                                    <i class="fa fa-clock-o"></i><b> Horarios:</b>  <a href="{{route('editHorarios')}}"  data-modal="" data-toggle="tooltip" data-placement="auto bottom" title="Horarios del sitio" class="editHora" style="color: #0000C2"><b>(Editar)</b></a>
                                @endif
                                <div id="horarios">
                                    <p>Lunes a Viernes:
                                        <span id="semana">
                                            @if($horario->semana == "")
                                                Cerrado
                                            @else
                                                {{$horario->semana}}
                                            @endif
                                        </span>
                                    </p>
                                    <p>Sábados:
                                        <span id="sabado">
                                            @if($horario->sabado == "")
                                                Cerrado
                                            @else
                                                {{$horario->sabado}}
                                            @endif
                                        </span>
                                    </p>
                                    <p>Festivos:
                                        <span id="festivo">
                                            @if($horario->festivo == "")
                                                Cerrado
                                            @else
                                                {{$horario->festivo}}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row seccion" id="conteDescripcion">
                        <div class="col-xs-12">
                            <h3>Descripción general del sitio</h3>
                        </div>
                        <div class="col-xs-12">
                            <div id="contenidoSitio" class="bordered" style="padding: 10px">
                                @if($sitio->info_adicional == "")
                                    Espacio disponible para ingresar descripción general del sitio!
                                @else
                                    {!!$sitio->info_adicional!!}
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 text-right">
                            @if($sitio->info_adicional == "")
                                <i class='editar icocontenido fa fa-pencil-square-o resaltar' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Editar descripcion'> <b>Editar contenido</b></i>
                            @else
                                <i class='editar icocontenido fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Editar'> Editar contenido</i>
                            @endif
                        </div>
                    </div>
                    <div class="row seccion">
                        <div class="col-xs-12">
                            <h3>Redes Sociales</h3>
                        </div>
                        {!!Form::open(['id'=>'formSocial', 'autocomplete'=>'off'])!!}
                            <div class="col-xs-12 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                <div class="form-group">
                                    <div class="input-group" data-toggle='tooltip' data-placement='bottom' title='Enlaza el Facebook de tu sitio'>
                                        <div class="input-group-addon facebook">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Ej: https://www.facebook.com/tuSitio" value="{{$sitio->facebook}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-6" style="margin-bottom: 15px">
                                <div class="form-group">
                                    <div class="input-group" data-toggle='tooltip' data-placement='bottom' title='Enlaza el Twitter de tu sitio'>
                                        <div class="input-group-addon twitt">
                                            <i class="fa fa-twitter"></i>
                                        </div>
                                        <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Ej: https://twitter.com/tuSitio" value="{{$sitio->twitter}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <button class="btn btn-primary center-block" type="submit" disabled id="submitRedes" data-toggle="tooltip" data-placement="auto bottom" title="Guardar redes sociales del sitio">
                                    Actualizar
                                    <i class="fa fa-check fa-fw cargando hidden"></i>
                                </button>
                            </div>
                        {!!Form::close()!!}
                    </div>
                    <div class="row seccion" id="Servicios">
                        <div class="col-xs-12">
                            <h3>Servicios</h3>
                            <div style="padding-left: 10px; padding-bottom: 15px">Activa o desactiva los servicios ofrecidos por tu sitio:</div>
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/parqueo.png" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Parqueadero" id="parqueo">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/bano.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Baños" id="bano">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/cafe.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Cafetería" id="cafe">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/infantil.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Zona Infantil" id="infantil">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/wifi.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Wi-fi" id="wifi">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/piscina.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Piscina" id="piscina">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/restaurant.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Restaurante" id="restaurant">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/beer.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Bar" id="beer">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/gym.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Gimnasio" id="gym">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/estadero.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Estadero" id="estadero">
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <img src="images/icons/extremo.png" alt="" class="icono desact" data-toggle="tooltip" data-placement="auto bottom" title="Deportes extremos" id="extremo">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Galería</h3>
                        </div>
                    </div>
                    <div class="row" id="divImagenes" style="padding: 10px;">
                        <div class="galeria" id="galeria">
                            @for($i=0;$i<count($galeria);$i++)
                                <div class="col-xs-6 col-md-4 col-lg-3 contenedorFoto" data-id={{$galeria[$i]->id}} data-ruta={{$galeria[$i]->foto}}>
                                    <div class="editProfPic">
                                        <i class='fa fa-trash fa-2x eliminar manito' aria-hidden='true' data-toggle='tooltip confirmation' data-popout="true" data-placement='top' title='Eliminar?' data-btn-ok-label="Si" data-btn-cancel-label="No"></i>
                                    </div>
                                    {{--<div class="foto bordered" style="background-image: url('images/{{$galeria[$i]->foto}}')"></div>--}}
                                    <div class="foto bordered">
                                        <img class="img-rounded img-responsive" src="images/{{$galeria[$i]->foto}}" style="height: 100%; width:100%">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="divUploadImages">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mapaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Configurar Ubicacion</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 15px">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="direccion" class="col-xs-2 control-label" style="padding-top: 5px">Direccion</label>
                                <div class="col-xs-10">
                                    <input type="text" name="direccion" id="direccion" placeholder="Ingresar direccion de sitio..." class="form-control" value="{{$sitio->direccion}}" data-toggle="tooltip" data-placement="auto bottom" title="Direccion del sitio">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="map"></div>
                    {{--{!!$map['html']!!}--}}
                </div>
                <div id="info"></div>
                <div class="modal-footer">
                    <div id="getinfo" class="hidden"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="almacenarCoordenada">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyA1AUmEiXssHdvD3yAjE4VTh_pWQENfNUM&sensor=true"></script>
    {!!Html::script('js/gmaps.js')!!}
    <script src="plugins/bootstrapConfirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/fileinput.min.js"></script>
    <script src="plugins/bootstrapFileInput/js/locales/es.js"></script>
    <script charset="UTF-8">
        var coordenada;
        var totalGaleria = 0;
        var imagesUploaded=0;
        var ppRoute = "";
        var geolocalizacion="{{$sitio->geolocalizacion}}";
        $(function () {
            activarInput($("#facebook"));
            activarInput($("#twitter"));
            validaRedes();

            $(".eliminar").each(function(){
                $(this).confirmation({
                    onConfirm: function () {
                        ajaxEliminarImagen($(this).parent().parent());
                        totalGaleria--;
                        validarUpload(totalGaleria);
                    }
                });
            });

            var servicios = "{{$sitio->servicios}}";
            servicios = servicios.split(',');

            $.each(servicios, function(index, elemento){
                $("#"+elemento).removeClass("desact");
            });

            totalGaleria = "{!!count($galeria)!!}";
            validarUpload(totalGaleria);
            ppRoute = "{{$portada[0]->foto}}";
            cargarAvatarFileInput(ppRoute);

            $("#ubicar").on('click', function(){
                $("#mapaModal").modal("show");
                setTimeout(function () {
                    map = new GMaps({
                        el: '#map',
                        lat: -12.043333,
                        lng: -77.028333
                    });

                    if(geolocalizacion=="")
                    geoMapa("{{$municipio->municipio." ".$municipio->getDepartamento->departamento}}");
                    else{
                        geo=geolocalizacion.split(",");
                        map.setCenter(geo[0], geo[1]);
                        map.removeMarkers();
                        map.addMarker({
                            lat: geo[0],
                            draggable: true,
                            lng: geo[1],
                            dragend: function(e) {
                                var lat = e.latLng.lat();
                                var lng = e.latLng.lng();
                                map.setCenter(lat, lng);
                                console.log(lat+","+ lng);
                                coordenada = lat+","+ lng;
                                //alert('dragend '+lat+"->"+lng);
                                //console.log(e);
                            }
                        });
                    }

                }, 500);

            });

            var formulario = $("#formSocial");
            formulario.submit(function(e){
                e.preventDefault();
                $("#submitRedes").focus();
//                if ($("#facebook").parent()
                    $.ajax({
                        type:"POST",
                        context: document.body,
                        url: '{{route('updateRedes')}}',
                        data:formulario.serialize(),
                        success: function(data){
                            if (data=="exito")
                                $(".cargando").removeClass("hidden");
                        },
                        error: function (data) {

                        }
                    });
//                }
            });

            $(".view").on('click', function () {
                window.location = "{{route("getSitio", $sitio->id)}}";
            });
        });

        $("#facebook").on('blur', function(){
            if ($(this).val() != "") {
                fbUrlCheck = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
                secondCheck = /home((\/)?\.[a-zA-Z0-9])?/;
                if (fbUrlCheck.test($(this).val()) && !secondCheck.test($(this).val())) {
                    activarInput($(this));
                    validaRedes();
                }
                else{
                    $(this).parent().addClass("has-error").attr("data-original-title", "Digita una URL valida");
                    $(this).focus();
                    $("#submitRedes").attr("disabled", 'disabled');
                    $(".cargando").addClass("hidden");
                }
            }
        });

        function validarFacebook(selector){
            fbUrlCheck = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
            secondCheck = /home((\/)?\.[a-zA-Z0-9])?/;
            if (fbUrlCheck.test($(this).val()) && !secondCheck.test($(this).val())) {
                activarInput($(this));
                validaRedes();
            }
            else{
                $(this).parent().addClass("has-error").attr("data-original-title", "Digita una URL valida");
                $(this).focus();
                $("#submitRedes").attr("disabled", 'disabled');
                $(".cargando").addClass("hidden");
            }
        }

        $("#twitter").on('blur', function(){
            if ($(this).val() != "") {
                twUrlCheck = /^(https?:\/\/)?(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/;
                secondCheck = /home((\/)?\.[a-zA-Z0-9])?/;
                if (twUrlCheck.test($(this).val()) && !secondCheck.test($(this).val())) {
                    activarInput($(this));
                    validaRedes();
                }
                else{
                    $(this).parent().addClass("has-error").removeClass("has-success");
                    // $(this).focus();
                    // $("#submitRedes").attr("disabled", 'disabled');
                    $(".cargando").addClass("hidden");
                }
            }
        });

        $("#direccion").on('blur', function(){
            if($(this).val != "")
                activarInput($(this));
            else{
                $(this).parent().addClass("has-error").removeClass("has-success");
                $(this).focus();
            }
        });

        $(".icono").on('click', function(){
            var elemento = $(this);
            var accion = "";
            if (elemento.hasClass("desact"))
                accion = "agregar";
            else
                accion= "borrar";
            $.ajax({
                type: "POST",
                context: document.body,
                url: '{{route('updateServicio')}}',
                data: "&servicio=" + elemento.attr("id") + "&accion=" + accion,
                success: function (data) {
                    if (data == "exito"){
                        if(accion == "agregar")
                            elemento.removeClass("desact");
                        else
                            elemento.addClass("desact");
                    }
                },
                error: function () {

                }
            });
        });

        function activarInput(elemento){
            if (elemento.val() != "")
                elemento.parent().addClass("has-success").removeClass("has-error");
            else{
                elemento.parent().addClass("has-error").removeClass("has-success");
            }
        }

        function validaRedes(){
            if ($("#facebook").val() != "" || $("#twitter").val() != ""){
                $("#submitRedes").removeAttr("disabled");

            }
        }


/*        $("#mapaModal").on("shown.bs.modal", function () {
            var currentCenter = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(currentCenter);
            coordenada=currentCenter.lat()+","+ currentCenter.lng();
        });*/

        $("#almacenarCoordenada").on("click", function () {
            if($("#getinfo").text()!="")
                coordenada=$("#getinfo").text();
            if ($("#direccion").val()!=""){
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('updateUbicacion')}}',
                    data: {"posicion":coordenada, "direccion":$("#direccion").val()},
                    success: function (data) {
                        if (data == "exito"){
                            $("#mapaModal").modal("hide");
                        }
                    },
                    error: function () {
                        console.log('error en la concexción');
                    }
                });
            }
            else{
                $("#direccion").parent().addClass("has-error");
                $("#direccion").focus();
            }
        });


        function validarUpload($cantImagenes) {
            if($cantImagenes != 8) {
                $("#divUploadImages").html("<div class='tema'>" +
                                                "<label class='control-label'>Seleccionar archivos</label>" +
                                                "<input id='inputGalery' name='inputGalery[]' type='file'  multiple class='file-loading' accept='image/*'>" +
                                            "</div>");
                imagesUploaded=0;
                $("#inputGalery").fileinput({
                    uploadAsync : true,
                    uploadUrl : 'administrador/subirimagen',
                    language: "es",
                    maxFileCount: 8-(totalGaleria),
                    showUpload: true,
                    uploadExtraData : {id:"{!! $sitio->id !!}", sitio:"{!! $sitio->nombre !!}"},
                    previewFileType: 'image',
                    allowedFileTypes: ['image'],
                    allowedFileExtensions: ['jpg', 'gif', 'png'],
                    previewSettings:{ image: {width: "200px", height: "160px"}},
                    minImageWidth: 500,
                    minImageHeight: 500,
                    maxFileSize: 2048
                }).on('fileuploaded', function(e, params) {
                    imagesUploaded++;
                    $(".galeria").append("<div class='col-xs-6 col-md-4 col-lg-3 contenedorFoto' data-id='"+params.response.id+"' data-ruta='"+params.response.ruta+"'>" +
                                            "<div class='editProfPic'>" +
                                                "<i class='fa fa-trash fa-2x eliminar manito' aria-hidden='true' data-toggle='tooltip confirmation' data-popout='true' data-placement='top' title='Eliminar?' data-btn-ok-label='Si' data-btn-cancel-label='No'></i>" +
                                            "</div>" +
                                            "<div class='foto bordered' ')\">" +
                                                "<img class='img-rounded img-responsive' src='images/"+params.response.ruta+"' style='height: 100%; width:100%'>" +
                                            "</div>" +
                                        "</div>");
                    if (imagesUploaded == params.files.length){
                        totalGaleria = parseInt(totalGaleria) + parseInt(imagesUploaded);
                        validarUpload(totalGaleria);
                    }
                });
            }
            else
                $("#divUploadImages").html("");
        }

        function cargarAvatarFileInput(ruta){
            ruta = htmlDecode(ruta);
            $("#conteFU").removeClass("centrar");
            $("#avatar-1").fileinput({
                uploadUrl : 'imagenperfil',
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
                uploadExtraData : {id:"{{$portada[0]->id}}", sitio:"{!! $sitio->nombre !!}", actual: ruta},
//                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="images/'+ruta+'" class="img-rounded img-responsive" alt="Imagen de perfil">',
//                resizeImage: true,
                previewSettings:{ image: {width: "200px", height: "160px"}},
                maxFileSize: 2048
            }).on('fileuploaded', function(e, params) {
                $("#conteFU").empty();
                $("#conteFU").append('<input id="avatar-1" name="avatar-1" type="file" class="file-loading" accept="image/*">');
                ppRoute = params.response.nueva;
                cargarAvatarFileInput(ppRoute);
            }).on('change', function(event) {
                $("#conteFU").addClass("centrar");
            });
        }

        $("#conteFU").on('filereset', '#avatar-1', function(){
            $("#conteFU").empty();
            $("#conteFU").append('<input id="avatar-1" name="avatar-1" type="file" class="file-loading" accept="image/*">');
            $("#conteFU").removeClass("centrar");
            cargarAvatarFileInput(ppRoute);
        });

        $(".galeria").on('click', '.eliminar', function(){
            $(this).confirmation({
                onConfirm: function () {
                    ajaxEliminarImagen($(this).parent().parent());
                    totalGaleria--;
                    validarUpload(totalGaleria);
                }
            });
        });

        function  ajaxEliminarImagen(elemento) {
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('deleteImage')}}',
                data: "&id=" + elemento.attr('data-id') + "&ruta=" + elemento.attr('data-ruta'),
                success: function(data){
                    if (data == "exito"){
                        elemento.remove();
                    }
                },
                error: function(data){
                    }
            });
        }

        $("#conteDescripcion").on('click', '.editar', function(){
            var conte = $("#contenidoSitio").text()+"";
            $("#conteDescripcion").html("<div class='col-xs-12 text-right'>" +
                    "<form>" +
                    "<textarea id='infoAdicional' name='infoAdicional' rows='10' cols='30' style='height:440px'></textarea>" +
                    "<button type='submit' class='btn btn-primary'>Guardar</button>" +
                    "</form>" +
                    "</div>");

            CKEDITOR.replace('infoAdicional', {removeButtons:'Image'});
            if (conte.trim() != "Espacio disponible para ingresar descripción general del sitio!")
                $("#infoAdicional").val(conte);
        });



        $('#conteDescripcion').on('submit', 'form', function (e) {
            e.preventDefault();
            var contenido = encodeURIComponent(CKEDITOR.instances.infoAdicional.getData().split("\n").join(""));
            if (contenido != "") {
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('editarDescripcion')}}',
                    data: "&infoAdicional=" + contenido + "&id=" + $('#infoSitio').attr('data'),
                    success: function (data) {
                        $("#conteDescripcion").html("<div class='col-xs-12'>" +
                                                        "<h3>Descripción general del sitio</h3>" +
                                                    "</div>" +
                                                    "<div class='tema'>" +
                                                        "<div class='col-xs-12'>" +
                                                            "<div id='contenidoSitio' class='bordered' style='padding:10px'>" + data + "</div>" +
                                                        "</div>" +
                                                        "<div class='col-xs-12 text-right'>" +
                                                            "<i class='editar icocontenido fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Editar'>" +
                                                            "Editar contenido" +
                                                            "</i>" +
                                                        "</div>" +
                                                    "</div>");
                    },
                    error: function () {
                        console.log('error en la concexción');
                    }
                });
            }
            else {
                $("#conteDescripcion").html("<div class='tema'>" +
                                                "<div class='col-xs-12'>" +
                                                    "<div id='contenidoSitio' class='bordered' style='padding:10px'>Espacio disponible para ingresar descripción general del sitio!</div>" +
                                                "</div>" +
                                                "<div class='col-xs-12 text-right'>" +
                                                    "<i class='editar icocontenido fa fa-pencil-square-o resaltar' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Editar'> <b>Editar contenido</b></i>" +
                                                "</div>" +
                                            "</div>");
            }
        });

        function htmlEncode(value){
            return $('<div/>').text(value).html();
        }

        function htmlDecode(value){
            return $('<div/>').html(value).text();
        }


        function geoMapa($muniDepartamento){
            GMaps.geocode({
                address: $muniDepartamento,
                callback: function(results, status){
                    if(status=='OK'){
                        var latlng = results[0].geometry.location;
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.removeMarkers();
                        map.addMarker({
                            lat: latlng.lat(),
                            draggable: true,
                            lng: latlng.lng(),
                            dragend: function(e) {
                                var lat = e.latLng.lat();
                                var lng = e.latLng.lng();
                                map.setCenter(lat, lng);
                                console.log(lat+","+ lng);
                                coordenada = lat+","+ lng;
                                //alert('dragend '+lat+"->"+lng);
                                //console.log(e);
                            }
                        });
                    }
                }
            });
        }
    </script>

@endsection
{{------end js--}}
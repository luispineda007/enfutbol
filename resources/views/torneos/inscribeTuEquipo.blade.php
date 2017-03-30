@extends('layouts.principal')

@section('css')

    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    {!!Html::style('plugins/iCheck/all.css')!!}
    <style>
        .ui-datepicker{ z-index:1151 !important; }
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
        .thumbnail:hover{
            box-shadow: 5px 5px 5px #90918f;
        }

        .thumbnail img{
            width: 100%;
            height: 158px;
        }
        .thumbnail .product-location h4{
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .icon i{
            margin: 0 4px;
        }


        #sortablePlanilla, #sortableEquipo {
            border: 1px solid #eee;
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #sortableEquipo{
            min-height: 50px;
            background-color: #f4ebeb;
        }
        #sortablePlanilla li, #sortableEquipo li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            cursor: move;
        }

        .integranteEquipo{
            border: 1px solid #575355;
            background: #c8bfbf;
            color: #000000;
        }

        .resaltar:hover{
            text-decoration: underline;
        }

        #tituloAlert{
            background-color: #f9a725 !important;
            color: white !important;
            font-size: 16px !important;
        }

        #cuerpoAlert{
            border: solid 2px #f9a725;
            border-top: none;
        }
        #infoCodigo:hover{
            color: #00a55a;
        }
        .mostrar:hover{
            color: green;
            background-color: #d3e9f7;
            border-radius: 5px;
        }
        #imageEscudo{
            border: 6px double #00a55a;
        }
        .labelsForm{
            padding-top: 0 !important;
        }
        #imageEscudo{
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease;
        }
        #imageEscudo:hover{
            -webkit-transform:scale(1.13);
            -moz-transform:scale(1.13);
            -ms-transform:scale(1.13);
            -o-transform:scale(1.13);
            transform:scale(1.13);
            z-index: 1000000;
        }

        #escudo:hover, .escudo:hover{
            -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        }
        .escudo{
            padding: 5px;
        }
        .escudo:hover{
            border: solid 1px rgba(0,0,0,0.75);
            cursor: pointer;
        }
        #escudos{
            padding: 0 10px;
        }
        .selected{
            padding: 5px;
            box-shadow: 5px 5px 10px 6px darkgreen;
            margin: 0 12px;
            border-top:solid 1px darkgreen;
            border-left:solid 1px darkgreen;
        }

    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">

                <div class="panel-body">

                    <h3 class="text-center">Inscribir equipo <br>Torneo: <b id="titulo">{{($torneo)?$torneo->nombre:""}}</b> </h3>

                    @if(count($planillas) > 0)
                        <div class="col-xs-12">
                            <div class="box box-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Inscribe rápidamente tu equipo usando una de tus plantillas </h3>
                                    <span class="label label-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}} pull-right"><i class="fa fa-users"></i></span>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    @foreach($planillas as $planilla)
                                        <div class="col-sm-6 col-md-3 product-grid">
                                            <div class="thumbnail manito" data-planilla="{{$planilla->id}}">
                                                <div class="caption">
                                                    <h4 class="text-center"><b>{{$planilla->nombre}}</b> </h4>
                                                    <small>{{($planilla->getJugadores->count()==1)?"1 Jugador":$planilla->getJugadores->count()." Jugadores"}}</small>
                                                    <small class="pull-right">
                                                        <span class="fa-venus-mars fa"></span><b> {{$planilla->genero}}</b>
                                                    </small>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->

                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Jugadores de tu planilla </h3>
                                <span class="icon pull-right">
                                    <i class="" > <input type='checkbox' name='' id='checkSelectPlanti'></i>
                                    <i class="fa fa-chevron-right manito" id="pasarSelect" data-toggle="tooltip" data-placement="bottom" title="Pasar seleccionados"></i>
                                </span>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul id="sortablePlanilla" class="connectedSortable">

                                    </ul>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    @else
                        <div class="col-sm-10 col-sm-offset-1 mensaje">
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-xs-2 text-center">
                                        <i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-xs-10 text-center" style="font-size: 16px;">
                                        No has creado plantillas con tus equipos favoritos, te recomendamos dirigirte a la sección
                                        <a href="{{route('adminPlantillas')}}"><b class="resaltar">Mis plantillas</b></a>
                                        para hacerlo y agilizar el proceso de inscripción de tu equipo al torneo.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="{{(count($planillas) == 0)?'col-sm-6 col-sm-offset-3':'col-sm-5'}}" id="contenedorJugadores">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="padding-bottom: 0" id="headerJugadores">
                                <h3 class="box-title" style="padding-bottom: 10px"> <b>Jugadores del equipo</b> <small>(Max. <span id="jugadoresNum"></span>)</small></h3>
                                <span class="icon pull-right">
                                    <span style="color: #ff524b;"><i class="fa fa-user-times manito" data-toggle='tooltip' data-placement='top' title="Eliminar seleccionados" id="borrarDeEquipo"></i></span>
                                    <span style="color: #00a65a;"><i class="fa fa-user-plus manito" data-toggle='tooltip' data-placement='top' title="Nuevo jugador" id="addPersona"></i></span>
                                </span>
                                <div class="text-center">
                                    <i class="fa fa-chevron-down hidden" aria-hidden="true" id="control"></i>
                                </div>
                            </div>
                            <div class="box-body" id="boxJugadores">

                                <ul id="sortableEquipo" class="connectedSortable">

                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" id="continuarInscripcion"></div>

                    {!!Form::open(['id'=>'formEquipo','class'=>'form-horizontal hidden', 'autocomplete'=>'off'])!!}
                        <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-0" style='margin-top:15px'>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-4 text-center">
                                    <div class="form-group">
                                        {!! Form::label('nombreEquipo', 'Nombre equipo:',['class'=>'control-label labelsForm', 'style'=>'']) !!}
                                        <div class="input-group">
                                            <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title='Digita el nombre que usará tu equipo en el torneo'>
                                                <i class="fa fa-users"></i>
                                            </div>
                                            {!!Form::text('nombreEquipo',null,['class'=>'form-control','id'=>'nombreEquipo','placeholder'=>"Nombre del equipo...", 'required'])!!}
                                        </div>
                                    </div>
                                </div>
                                @if($torneo)
                                    @if($torneo->privacidad == 'C')
                                        <div class="col-sm-8 col-sm-offset-4 text-center">
                                            <div class="form-group">
                                                {!! Form::label('codigo', 'Codigo:',['class'=>'control-label labelsForm', 'style'=>'']) !!}
                                                <div class="input-group">
                                                    <div class="input-group-addon manito" data-toggle="tooltip" data-placement="bottom" title='Ingresa tu código de inscripción a torneo' id="infoCodigo">
                                                        <i class="fa fa-keyboard-o"></i>
                                                    </div>
                                                    {!!Form::text('codigo',null,['class'=>'form-control','id'=>'codigo','placeholder'=>"Codigo para inscripcion...", 'required'])!!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-0" style='margin-top:15px'>
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-1 text-center">
                                    <div class="bordered">
                                        <img src="images\torneos\escudos\noEscudo.png" class="img-circle manito" width="135px" height="135px" id="imageEscudo" data-toggle="tooltip" data-placement="top" title='Elegir escudo para el equipo'>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 text-center" style="margin-top: 20px">
                            <button type="submit" class="btn btn-success" data-dismiss="modal" id="botonEnviarForm">Inscribirme!</button>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body" id="content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" id="botonModal">Entendido!</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nuevaPesona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="exampleModalLabel"><b>Registrar jugador</b></h4>
                </div>

                <div class="panel-body">

                    <div id="contePanel">
                        <div class="panel panel-default text-center desplegar">
                            <div class="panel-heading" id="tituloAlert">
                                <i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<b>Importante</b>
                            </div>
                            <div class="panel-body hidden" id="cuerpoAlert">
                                Es importante que la información suministrada a continuación sea clara y verídica, pues será utilizada para la logística de los torneos y la participación de los usuarios en ellos.
                                Dicha informacion, solo podrá ser modificada si su propietario (el jugador) se registra en <b>enFutbol.co</b>
                            </div>
                        </div>
                    </div>

                    {!!Form::open(['id'=>'formRegistrarJugador','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('identificacion', 'No. Identificación',['class'=>'col-sm-4 control-label', 'style'=>'']) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('identificacion',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>"Número de Identificación...", 'onkeypress' => 'return justNumbers(event)', 'maxlength'=>'15', 'minlength'=>'7', 'required'])!!}
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
                    <div id="divformulariRegistro" style="display: none;">
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
                                    {!! Form::label('sexo', 'Genero',['class'=>'col-sm-4 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!!Form::select('sexo', ['M' => 'Masculino', 'F' => 'Femenino'], ($torneo)?$torneo->genero:'', ['class'=>"form-control", 'disabled', 'data-toggle'=>"tooltip", 'data-placement'=>"bottom", 'title'=>($torneo)?($torneo->genero=='M')?'Torneo solo para hombres':'Torneo solo para mujeres':''])!!}
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
                    </div>

                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1" id="alertRespuestaModal">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="btnAccionModal">
                            {{--<button class="btn btn-primary center-block" type="submit" id="submitForm">Guardar! <i class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>--}}
                                {{--<span class="sr-only">Loading...</span> </button>--}}

                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfoCodigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center"><b>Codigos</b></h4>
                </div>
                <div class="modal-body">
                    Este torneo es privado, para completar la inscripción de tu equipo, debes proporcionar el código de inscripción generado por el administrador del torneo.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEscudos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Cambiar escudo</h4>
                </div>
                <div class="modal-body">
                    Selecciona el nuevo escudo para tu equipo:
                    <div id="escudos" class="row" style="margin-top: 15px">

                    </div>
                    <div id="error" class="row hidden" style="margin-top: 25px">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="alert alert-danger alert-dismissable text-center" style="margin-bottom: 0">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Atencion!</strong> <span id="texto"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" disabled id="cambiarEscudo">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection


@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    {!!Html::script('plugins/datepicker/locales/bootstrap-datepicker.es.js')!!}
    {!!Html::script('plugins/iCheck/icheck.min.js')!!}
    {{--{!!Html::script('js/gmaps.js')!!}--}}
    <script>
        var jugadoresplanilla = [];
        var jugadores = [];
        var maxjugadores;
        var titulo = "";
        var torneo;
        var continuar = true;
        var imagen = false;

        @if($torneo)
            console.log('entraaaaa');
            maxjugadores = parseInt("{{$torneo->max_jugadores}}");
            torneo = "{{$torneo->id}}";
            sessionStorage.setItem("maxjugadores", parseInt("{{$torneo->max_jugadores}}"));
            sessionStorage.setItem("titulo", "{{$torneo->nombre}}");
            sessionStorage.setItem("torneo_id", "{{$torneo->id}}");
        @else
            if(sessionStorage.getItem("maxjugadores")==null){
                    maxjugadores = sessionStorage.getItem("maxjugadores");
                    titulo = sessionStorage.getItem("titulo");
                    torneo = sessionStorage.getItem("torneo_id");
                }else{
                    window.location = "{{route("buscarTorneos")}}";
                }
        @endif
        var totalJugadores = 0;

        $(function () {
            if(titulo!="")
                $("#titulo").html(titulo);
            @foreach($planillas as $planilla)
                @foreach($planilla->getJugadores as $jugador)
                 jugadores.push({id:"{{$jugador->getUsuario->getPersona->identificacion}}",nombre:"{{$jugador->getUsuario->getPersona->nombres}}",equipo:""});
                @endforeach
                    jugadoresplanilla["planilla{{$planilla->id}}"]=jugadores;
                    jugadores=[];
            @endforeach

            if(maxjugadores != "")
                $("#jugadoresNum").html(maxjugadores);
            $('#fecha_nacimiento').datepicker({
                autoclose: true,
                language: 'es',
                endDate:'-1095d'
            });

            $( "#sortablePlanilla" ).sortable({
                connectWith: ".connectedSortable",
                cancel: ".ui-state-disabled",
                sort: function(event, ui) {
                    var $target = $(event.target);
                    if (!/html|body/i.test($target.offsetParent()[0].tagName)) {
                        var top = event.pageY - $target.offsetParent().offset().top - (ui.helper.outerHeight(true) / 2);
                        ui.helper.css({'top' : top + 'px'});
                    }
                },
                start: function( event, ui ) {
                    $('.checkPlanilla').iCheck('uncheck');
                    $("#checkSelectPlanti").iCheck('uncheck');

                }
            }).disableSelection();

            $( "#sortableEquipo" ).sortable({

                receive: function( event, ui ) {
                    $(ui.item).removeClass("ui-state-default").addClass("integranteEquipo");
                    $(ui.item).find("input").removeClass("checkPlanilla").addClass("checkEquipo");
                    selectJugadorEnEquipo($(ui.item).data("jugador"),"X");
                    iniciarCheckEquipo();
                    $("#checkSelectPlanti").iCheck('uncheck');

                }
            }).disableSelection();


            $(".thumbnail").click(function () {
                $("#sortablePlanilla" ).html("");
                $("#sortablePlanilla").data("planilla",$(this).data("planilla"));
                //console.log(jugadoresplanilla["planilla"+$(this).data("planilla")]);
                $.each(jugadoresplanilla["planilla"+$(this).data("planilla")],function (index,val) {

                    $( "#sortablePlanilla" ).append("<li class='ui-state-default "+(val.equipo=="X"?"ui-state-disabled":"")+"' data-jugador='"+val.id+"'>"+val.nombre+" <div class='pull-right'><input type='checkbox' class='minimal checkPlanilla' name='' id='' "+(val.equipo=="X"?"disabled":"")+"></div></li>");
                });
                iniciarCheckPlanillas();
                $("#checkSelectPlanti").iCheck('check');
            });

            $("#checkSelectPlanti").iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            }).on('ifChecked', function(event){
                $('.checkPlanilla').iCheck('check');
            }).on('ifUnchecked', function(event){
                $('.checkPlanilla').iCheck('uncheck');
            });

            $("#borrarDeEquipo").click(function(){
                var total = true;
                $('.checkEquipo:checked').each(function (index, val) {
                    if(totalJugadores >4){
                        var elemento = $(this).parents("li");
                        selectJugadorEnEquipo(elemento.data("jugador"), "");
                        $(elemento).hide("drop", [], 600);
                        setTimeout(function () {
                            $(elemento).remove();
                        }, 650);
                        --totalJugadores;
                        validarInsertJugador(totalJugadores);
                    }
                    else
                        total = false;
                });
                if(!total) {
                    $("#modal-title").html("Atencion!").parents('.modal-header').addClass('alert-warning');
                    $("#content").html("El equipo no puede contener menos de 4 jugadores");
                    $("#botonModal").addClass('btn-warning');
                    $("#notifModal").modal("show");
                }
            });

            $("#pasarSelect").click(function(){

                $('.checkPlanilla:checked').each(function (index,val) {

                    if($(this).parent().attr("aria-disabled")=="false"){
                        var elemento =$(this).parents("li");
                        selectJugadorEnEquipo(elemento.data("jugador"),"X");
                        $(elemento).hide( "fade", [], 600*(index+1) ,function () {
                            $("#sortableEquipo").append($(this));
                            $($(this)).show( "drop", [], 600 );
                            $($(this)).removeClass("ui-state-default").addClass("integranteEquipo");
                            $($(this)).find("input").removeClass("checkPlanilla").addClass("checkEquipo");
                            iniciarCheckEquipo();
                        } );
                    }

                });

            });

            $("#addPersona").click(function(){
                $("#contePanel").removeClass('col-sm-6 col-sm-offset-3').addClass('col-sm-10 col-sm-offset-1');
                $("#cuerpoAlert").removeClass("hidden");
                $("#tituloAlert").parent().removeClass('manito');
                $("#nuevaPesona").modal("show");
            });

            $("#nuevaPesona" ).on('shown.bs.modal', function(){
                setTimeout(function () {
                    $("#contePanel").removeClass('col-sm-10 col-sm-offset-1').addClass('col-sm-6 col-sm-offset-3');
                    $("#cuerpoAlert").addClass("hidden");
                    $("#tituloAlert").parent().addClass('manito');
                },4000);
            });

            $(".desplegar").on('click', function(){
                if($(this).hasClass('manito')){
                    var contenedor = $("#contePanel");
                    if(contenedor.hasClass('col-sm-6')) {
                        contenedor.removeClass('col-sm-6 col-sm-offset-3').addClass('col-sm-10 col-sm-offset-1');
                        $("#cuerpoAlert").removeClass("hidden");
                    }
                    else {
                        contenedor.removeClass('col-sm-10 col-sm-offset-1').addClass('col-sm-6 col-sm-offset-3');
                        $("#cuerpoAlert").addClass("hidden");
                    }
                }
            });

            $("#departamento").change(function () {
                if($("#departamento").val()==""){
                    $("#divMunicipio").addClass("hidden").removeClass("show");
                }else{
                    $("#divMunicipio").addClass("show").removeClass("hidden");
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


            var formRegistrarJugador = $("#formRegistrarJugador");
            formRegistrarJugador.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('addPersonaExterna')}}',
                    data:formRegistrarJugador.serialize()+'&sexo='+$("#sexo").val()+"&addEquipo=NO",
                    success: function (data) {
                        var html = '';
                        if(data.estado){
                            ++totalJugadores;
                            validarInsertJugador(totalJugadores);
                            $("#nuevaPesona").modal("toggle");
                            validarArrow($("#control"));
                            $("#sortableEquipo").append("<li class='integranteEquipo' data-jugador='"+$("#identificacion").val()+"'>"+$("#nombres").val()+" <div class='pull-right'><input type='checkbox' class='minimal checkEquipo' name='' id=''></div></li>");
                            iniciarCheckEquipo();
                        }
                        else {
                            html = '<div class="alert alert-warning alert-dismissable text-center"> ' +
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                    '<strong>Atencion!</strong><br>'+data.mensaje +
                                    '</div>';
                            $("#alertRespuestaModal").html(html);
                        }
                    },
                    error: function (data) {
                    }
                });
            });

            $("#identificacion").change(function(){
                var identificacion = $(this).val();
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('exisPersona')}}',
                    data:{identificacion:identificacion, torneo:torneo},
                    success: function (data) {
                        if(data.bandera) {
                            $("#nombres").val(data.nombres).attr('disabled', true);
                            var html = '';
                            if (buscarJugaroEnEquipo(identificacion)) {
                                html = '<div class="alert alert-info alert-dismissable text-center"> ' +
                                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                        '<strong>Atención!</strong><br>Este jugador ya pertenece a tu equipo! ' +
                                        '</div>';
                                $("#btnAccionModal").html("");
                            }
                            else {
                                html = '<div class="alert alert-success alert-dismissable text-center"> ' +
                                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                        '<strong>Perfecto!</strong><br>El jugador fue encontrado en nuestro sistema y esta disponible para jugar en tu equipo.' +
                                        '</div>';
                                $("#btnAccionModal").html("<button class='btn btn-primary center-block' type='button' id='submitFormAddJugadpr'>Agregar<i class='fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden'></i>" +
                                        "<span class='sr-only'>Loading...</span> </button>");
                                $("#contePanel").addClass('hidden');
                                $("#divformulariRegistro").css('display', 'none');
                            }
                            $("#alertRespuestaModal").html(html);
                        }
                        else{
                            if(data.mensaje == 'No encontrado'){
                                $("#contePanel").removeClass('hidden');
                                $("#nombres").removeAttr('disabled');
                                $("#divformulariRegistro").show();
                                $("#alertRespuestaModal").html("");
                                $("#nombres").val("");
                                $("#btnAccionModal").html("<button class='btn btn-primary center-block' type='submit' id='submitForm'>Registrar Jugador<i class='fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden'></i>"+
                                        "<span class='sr-only'>Loading...</span> </button>");
                            }
                            else {
                                $("#contePanel").addClass('hidden');
                                $("#divformulariRegistro").hide("fade",[],600, function () {
                                    $("#nombres").val(data.nombres).attr('disabled', true);
                                });
                                var html = '<div class="alert alert-warning alert-dismissable text-center"> ' +
                                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                            '<strong>Atencion!</strong><br>El jugador fue encontrado en nuestro sistema pero ya participa en este torneo. <br>Equipo: ' + data.mensaje['nombre'] +
                                            '</div>';
                                $("#alertRespuestaModal").html(html);
                                $("#btnAccionModal").html("");
                            }
                        }
                    },
                    error: function (data) {
                    }
                });
            });


        });// FIN READY

        $("#btnAccionModal").on("click","#submitFormAddJugadpr",function () {
            validarArrow($("#control"));
            $("#sortableEquipo").append("<li class='integranteEquipo' data-jugador='"+$("#identificacion").val()+"'>"+$("#nombres").val()+" <div class='pull-right'><input type='checkbox' class='minimal checkEquipo' name='' id=''></div></li>");
            iniciarCheckEquipo();
            selectJugadorEnEquipo($("#identificacion").val(),"X");
            ++totalJugadores;
            validarInsertJugador(totalJugadores);
            $("#nuevaPesona").modal("toggle");
        });

        function validarInsertJugador($numExistentes){
            if($numExistentes < maxjugadores)
                $("#addPersona").removeClass("hidden");
            else
                $("#addPersona").addClass("hidden");

            if($numExistentes>=4 && continuar)
                $("#continuarInscripcion").html("<button class='btn btn-primary center-block' type='button' id='btnContinuar'>Continuar<i class='fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden'></i>");
        }

        function iniciarCheckPlanillas() {
            $('input[type="checkbox"].minimal').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                increaseArea: '-10%'
            });
            $('.checkPlanilla').iCheck('check');
        }

        function iniciarCheckEquipo() {
            $('input[type="checkbox"].checkEquipo').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                increaseArea: '-10%'
            });
            $('.checkEquipo').iCheck('uncheck');
        }

        function selectJugadorEnEquipo(jugador,estado) {
            $.each(Object.keys(jugadoresplanilla),function (i,v) {
                $.each(jugadoresplanilla[v],function (index,val) {
                    if(jugador == val.id){
                        val.equipo=estado;
                    }
                });
            });
        }

        function buscarJugaroEnEquipo(identificacion) {
            var bandera = false;
            $(".integranteEquipo").each(function (index,val) {
                if($(this).data("jugador")==identificacion){
                    bandera=true;
                }
            });
            return bandera;
        }

        var formEquipo = $("#formEquipo");
        formEquipo.submit(function (e) {
            e.preventDefault();
            if(imagen){
                var arrayIDs = [];
                $('.integranteEquipo').each(function (index, val) {
                    arrayIDs.push($(this).data('jugador'));
                });
                var escudoEquipo = $("#imageEscudo").data('escudo');
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('inscribirEquipo')}}',
                    data: $(this).serialize()+"&torneo="+torneo+"&jugadores="+arrayIDs+"&escudo="+escudoEquipo,
                    success: function(data){
                        if(data.estado){
                            var mensaje = '';
                            if(data.jugadores == 'completos'){
                                mensaje = 'Felicidades, Tu equipo ahora participa en este torneo, puedes administrar los jugadores de tu equipo, siempre que el estado del torneo sea abierto.';
                            }
                            else {
                                mensaje = 'Felicidades, Tu equipo ahora participa en este torneo, pero ten cuidado, es posible que no se pudieran agregar algunos jugadores seleccionados, por favor inténtalo de nuevo desde el espacio administración de tu equipo.';
                            }
                            $("#modal-title").html("Inscripcion completada!").parents('.modal-header').addClass('alert-success').removeClass('alert-warning alert-danger');
                            $("#content").html(mensaje);
                            $("#botonModal").addClass('hidden').removeClass('btn-warning btn-danger');
                            $("#notifModal").modal("show");
                            setTimeout(function(){
                                $("#notifModal").modal("toggle");
                                sessionStorage.setItem("maxjugadores", null);
                                sessionStorage.setItem("titulo", null);
                                sessionStorage.setItem("torneo_id", null);
                                window.location = '/adminEquipo/' + data.mensaje['id'];
                            }, 5000);
                        }
                        else {
                            $("#modal-title").html("Atencion!").parents('.modal-header').addClass('alert-danger');
                            $("#content").html(data.mensaje);
                            $("#botonModal").addClass('btn-danger');
                            $("#notifModal").modal("show");
                        }
                    },
                    error: function(data){

                    }
                });
            }
            else{
                $("#modal-title").html("Atencion!").parents('.modal-header').addClass('alert-warning');
                $("#content").html("Debes seleccionar un escudo para tu equipo!");
                $("#botonModal").addClass('btn-warning');
                $("#notifModal").modal("show");
            }
        });

        $("#contenedorJugadores").on('click', '.mostrar', function(){
            var control = $("#control");
            if(control.hasClass('fa-chevron-down')){
                $("#boxJugadores").show("blind", [], 400);
                control.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
            else{
                $("#boxJugadores").hide("blind", [], 400);
                control.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });

        function validarArrow(control){
            if(!continuar) {
                if (control.hasClass('fa-chevron-down')) {
                    $("#boxJugadores").show("blind", [], 400);
                    control.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
            }
        }

        $('#nuevaPesona').on('hidden.bs.modal', function (e) {
            $("#contePanel").removeClass('hidden');
            $("#nombres").removeAttr('disabled');
            $("#alertRespuestaModal").html("");
            $("#formRegistrarJugador").reset();
            $("#btnAccionModal").html('');
            $("#divformulariRegistro").css('display', 'none');
        });

        $("#continuarInscripcion").on('click', '#btnContinuar', function(){
            formEquipo.removeClass('hidden');
            continuar = false;
            $("#continuarInscripcion").html("");
            if('{{count($planillas)}}' == 0){
                $("#boxJugadores").hide("blind", [], 600);
//                $("#headerJugadores").addClass('manito mostrar');
                $("#control").removeClass('hidden').parent().addClass('manito mostrar');
            }
        });

        formEquipo.on('click', '#infoCodigo', function(){
            $("#modalInfoCodigo").modal("show");
        });

        $("#imageEscudo").on('click', function(){
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('getEscudosDisponibles')}}',
                data: {torneo_id:torneo},
                success: function(data){
                    if(data.estado){
                        var html = '';
                        console.log();
                        for(var i in data.mensaje){
                            html = html + '<div class="col-sm-2 text-center escudo" data-id="'+data.mensaje[i]['id']+'">' +
                                    '<img src="../images/torneos/escudos/'+data.mensaje[i]['url']+'" alt="" width="100%" height="100px">' +
                                    '</div>';
                        }
                        $("#escudos").html(html);
                        $("#modalEscudos").modal("show");
                    }
                    else {
                        $("#escudos").html('<div class="alert alert-warning text-center">' +
                                '<strong>Lo sentimos!</strong> Ha ocurrido un error interno cargando los escudos disponibles.<br>Por favor, inténtalo de nuevo mas tarde.' +
                                '</div>');
                        $("#modalEscudos").modal("show");
                        setTimeout(function(){
                            $('#modalEscudos').modal('toggle');
                        }, 4000);
                    }
                },
                error: function(data){

                }
            });
        });

        $("#escudos").on('click', '.escudo', function(){
            $(".selected").removeClass('selected').addClass('escudo');
            $(this).addClass('selected').removeClass('escudo');
            $("#cambiarEscudo").removeAttr('disabled');
        });

        $("#modalEscudos").on('hidden.bs.modal', function(){
            $("#cambiarEscudo").attr('disabled', true);
            $("#error").addClass('hidden');
        });

        $("#cambiarEscudo").on('click', function(){
            var seleccionado = $(".selected");
            $("#imageEscudo").attr('src',seleccionado.children('img').attr('src')).attr('data-escudo',seleccionado.data('id'));
            $("#modalEscudos").modal("toggle");
            imagen = true;
        });
    </script>
@endsection
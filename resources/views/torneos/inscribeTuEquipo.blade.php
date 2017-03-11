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
            margin: 0 10px;
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

    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">

                <div class="panel-body">

                    <h3 class="text-center">Inscribe tu equipo a <b id="titulo">{{($torneo)?$torneo->nombre:""}}</b> </h3>

                    <div class="col-xs-12">
                        <div class="box box-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                            <div class="box-header with-border">
                                <h3 class="box-title">Inscribe rapidanmente tu equipo selecionando una de tus plinillas </h3>
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

                    <div class="col-sm-5">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <b>Jugadores de tu Equipo a inscribir</b> </h3>
                                <span class="icon pull-right">
                                    <span style="color: #ff524b;"><i class="fa fa-user-times manito" id="borrarDeEquipo"></i></span>
                                    <span style="color: #00a65a;"><i class="fa fa-user-plus manito" id="addPersona"></i></span>
                                </span>
                            </div><!-- /.box-header -->
                            <div class="box-body">

                                <ul id="sortableEquipo" class="connectedSortable">

                                </ul>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->

                </div>{{--fin panel body--}}

            </div>

        </div>

    </div>

<div class="modal fade" id="nuevaPesona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel"><b>Registrar un Jugador</b></h4>
            </div>

            <div class="panel-body">
                <div class="alert alert-warning alert-dismissable text-justify">
                    <strong>Nota!</strong> La información necesaria para crear una persona podrá ser actualizada o modificada,
                    solo si el propietario de dicha información se registra en nuestro sistema. Esta información será utilizada
                    para la logística de los torneos (listado de jugadores, resultado de encuentros, carnet, premiación, ...),
                    por tal motivo es importante que la información sea correcta para poder participar en los eventos.
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
                <div id="divformulariRegistro">
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


@endsection


@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    {!!Html::script('plugins/datepicker/locales/bootstrap-datepicker.es.js')!!}
    {!!Html::script('plugins/iCheck/icheck.min.js')!!}
    <script>
        var jugadoresplanilla = [];
        var jugadores = [];
        @if($torneo)
            var maxjugadores = parseInt("{{$torneo->max_jugadores}}");
            var titulo ="";
            sessionStorage.setItem("maxjugadores", parseInt("{{$torneo->max_jugadores}}"));
            sessionStorage.setItem("titulo", "{{$torneo->nombre}}");
        @else

            if(sessionStorage.getItem("maxjugadores")!=""){
                var maxjugadores = sessionStorage.getItem("maxjugadores");
                var tituli =  sessionStorage.getItem("titulo");
            }else{
                window.location = "{{route("buscarTorneos")}}";
            }

        @endif

        $(function () {
            if(titulo!="")
            $("#titulo").html(tituli);
            @foreach($planillas as $planilla)
                @foreach($planilla->getJugadores as $jugador)
                 jugadores.push({id:"{{$jugador->getUsuario->getPersona->identificacion}}",nombre:"{{$jugador->getUsuario->getPersona->nombres}}",equipo:""});
                @endforeach
                    jugadoresplanilla["planilla{{$planilla->id}}"]=jugadores;
                    jugadores=[];
            @endforeach


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

                $('.checkEquipo:checked').each(function (index,val) {
                    var elemento =$(this).parents("li");
                    selectJugadorEnEquipo(elemento.data("jugador"),"");
                    $(elemento).hide( "drop", [], 600 );
                    setTimeout(function () {
                        $(elemento).remove();
                    },650);

                });


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
                $("#nuevaPesona").modal("show");
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


            var formRegistrarJugador = $("#formRegistrarJugador");
            formRegistrarJugador.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('addPersonaExterna')}}',
                    data:formRegistrarJugador.serialize(),
                    success: function (data) {

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
                    data:{identificacion:identificacion},
                    success: function (data) {
                        if(data.bandera){

                            $("#divformulariRegistro").hide("fade",[],600, function () {
                            $("#nombres").val(data.nombres);
                                if(buscarJugaroEnEquipo(identificacion)){
                                    var html = '<div class="alert alert-info alert-dismissable"> ' +
                                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                        '<strong>Nota!</strong> La informacion del jugador fue encontrada, ya se encuentra en tu equipo ' +
                                        '</div>';
                                    $("#btnAccionModal").html("");
                                }else{
                                    var html = '<div class="alert alert-success alert-dismissable"> ' +
                                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                                        '<strong>Perfecto!</strong> La informacion del jugador fue encontrada, puedes agregarlo a tu equipo. ' +
                                        '</div>';

                                    $("#btnAccionModal").html("<button class='btn btn-primary center-block' type='button' id='submitFormAddJugadpr'>Agregar a Mi Equipo <i class='fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden'></i>"+
                                    "<span class='sr-only'>Loading...</span> </button>");
                                }
                                $("#alertRespuestaModal").html(html);
                            });


                        }else{
                            $("#divformulariRegistro").show();
                            $("#alertRespuestaModal").html("");
                            $("#nombres").val("");
                            $("#btnAccionModal").html("<button class='btn btn-primary center-block' type='submit' id='submitForm'>Registrar Jugador<i class='fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden'></i>"+
                                "<span class='sr-only'>Loading...</span> </button>");

                        }
                    },
                    error: function (data) {
                    }
                });
            });


        });// FIN READY

        $("#btnAccionModal").on("click","#submitFormAddJugadpr",function () {
            console.log("hola");
            $("#sortableEquipo").append("<li class='integranteEquipo' data-jugador='"+$("#identificacion").val()+"'>"+$("#nombres").val()+" <div class='pull-right'><input type='checkbox' class='minimal checkEquipo' name='' id=''></div></li>");
            iniciarCheckEquipo();
            selectJugadorEnEquipo($("#identificacion").val(),"X");
            $("#nuevaPesona").modal("hide");
        });

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
        $('#nuevaPesona').on('hidden.bs.modal', function (e) {
            $("#divformulariRegistro").show("fade",[],600);
            $("#formRegistrarJugador").reset();
            $("#alertRespuestaModal").html("");
        })
    </script>
@endsection
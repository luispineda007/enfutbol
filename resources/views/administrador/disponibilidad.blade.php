@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}

    <style>

        .ocupado{
            background-color: #d8534f;
        }
        .disponible{
            background-color: #5cb75c;
        }
        .poin{
            cursor: pointer;
        }
        #descripcion{
            min-height: 50px;
        }
        #fechaReserva{
            font-size: 24px;
        }
.canc{
    border: solid 1px #4b4b4b;
    border-radius: 5px;
}
        .canc:hover{
            box-shadow: 5px 10px 5px #888888;
        }

        .cancSelect{
            border: solid 2px #01136e;
            background-color: rgba(0, 211, 253, 0.1);
            box-shadow: 10px 10px 5px rgba(60, 140, 187, 0.75);
        }

        .imgCancha{
            max-width: 100%;
        }
        .centerBlock{
            margin: 0 auto;
            height: auto;
        }
        .col-center-block {
            float: none;
            display: block;
            margin: 0 auto;
            /* margin-left: auto; margin-right: auto; */
        }
    </style>

@endsection
{{------end css--}}

{{--@section('Pageheader')--}}

    {{--<h1>--}}
        {{--Disponibilidad--}}
        {{--<small>Version 2.0</small>--}}
    {{--</h1>--}}
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>--}}
        {{--<li class="active">Disponibilidad</li>--}}
    {{--</ol>--}}

{{--@endsection--}}
{{------end css--}}

@section('content')
    <div class="row">
    {!!Form::open(['id'=>'formdisponibilidad','class'=>'form-horizontal','autocomplete'=>'off'])!!}
    <div class="col-md-10 col-md-offset-1 panel panel-primary">
        <div class="panel-body">

            <div class="row">

                {{--<div class="col-sm-6">--}}
                {{--<div class="form-group">--}}
                {{--{!! Form::label('cancha', 'Cancha ',['class'=>'col-sm-4 control-label']) !!}--}}
                {{--<div class="col-sm-8">--}}
                {{--{!!Form::select('cancha', $arrayCanchas, null, ['class'=>"form-control"])!!}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}

                @foreach($arrayCanchas as $key =>$cancha)
                <div class="col-xs-4 col-sm-3 col-lg-2 text-center" >
                    <div class="col-xs-12 canc poin" data-id_cancha="{{$key}}" data-nombre="{{$cancha[0]}}" data-tipo="{{$cancha[1]}}">
                        <div class="row">{{$cancha[1]}}</div>
                        <div class="row"><img src="images/{{$cancha[2]}}" class="imgCancha"  height="90" alt=""></div>
                        {{$cancha[0]}}
                    </div>

                </div>

                @endforeach

            </div>
            <div class="row" style="margin-top: 30px">
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('fecha', 'El dia',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                {!!Form::text('fecha',$hoy,['class'=>'form-control pull-right','readonly'])!!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        {!! Form::label('Descripcion', 'Descripcion ',['class'=>'col-xs-2 control-label']) !!}
                        <div id="descripcion" class="col-xs-10">
                            {{$descripcion}}
                        </div>
                    </div>
                </div>
            </div>

            @if($horario == "cerrado")
            <div class="row" id="rowCerrado">
                <div class="callout callout-danger">
                    <h4 class="text-center">La Cancha se encuentra CERRRADA para esta fecha</h4>

                    <p class="text-center">Desea configurar el Horario? </p>
                </div>
            </div>
            @endif


            <div class="row {{($horario == "cerrado")?"hidden":""}}" id="rowAbierto">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box">
                        <div class="box-header">
                            <h3 id="tituloTable" class="box-title"></h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Responsable</th>
                                </tr>
                                </thead>
                                <tbody id="tbody" class="poin">

                                @foreach($responsables as $hora => $responsable)

                                    @if(!empty($responsable))
                                        <tr class="respo ocupado" data-id="{{$responsable[0]}}" data-respo="{{$responsable[1]}}" data-hora="{{$hora}}">
                                            <td>{{(strlen($hora)<2)?"0".$hora.":00":$hora.":00"}}</td>
                                            <td>{{$responsable[1]}}</td>

                                        </tr>
                                    @else
                                        <tr class="respo disponible" data-respo="" data-hora="{{$hora}}">
                                            <td>{{(strlen($hora)<2)?"0".$hora.":00":$hora.":00"}}</td>
                                            <td></td>

                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>


        </div>
    </div>
    {!!Form::close()!!}
    </div>

    <div id="modalNuevoRes" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="tituloNuevoRes" class="modal-title"></h4>
                </div>
                {!!Form::open(['id'=>'formNuevoRes','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('user', 'Responsable (*)',['class'=>'col-sm-4 control-label hidden-xs']) !!}
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" placeholder="Ingresar el nombre del responsable..." name="responsable" id="responsable" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('telefono', 'No. de Contacto (*)',['class'=>'col-sm-4 control-label hidden-xs']) !!}
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

                            <h4 class="text-center"> La Reserva queda para <strong><spam id="fechaReserva"></spam></strong></h4>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Reservar',['class'=>'btn btn-primary']) !!}
                    {{--<button type="button" class="btn btn-primary">Reservar</button>--}}
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="modalToken" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Penalización (Retirar Token a Usuario)</h4>
                </div>
                {!!Form::open(['id'=>'formRetirarToken','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-8 col-sm-offset-2 ">
                            <div class="form-group">
                            {!!Form::select('motivos', ['No Asistio al Encuentro' => 'No Asistio al Encuentro',
                                                     'Formo pelea en la cancha' => 'Formo pelea en la cancha',
                                                     'No cumplio con lo acordado'=>'No cumplio con lo acordado',
                                                     '4'=>'Otro Motivo'], null, ['id'=>'motivos','class'=>"form-control",'placeholder' => 'Seleccione un motivo...', 'required'])!!}
                            </div>
                        </div>
                        <div id="otroMotivo" class="col-sm-8 col-sm-offset-2">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Eliminar Token!',['class'=>'btn btn-primary']) !!}
                    {{--<button type="button" class="btn btn-primary">Eliminar Token</button>--}}
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="noEsUsuario" class="modal fade modal-danger" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center "><i class="fa fa-ban" aria-hidden="true"></i> No se puede hacer sanción</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">No se puede quitarle el token a una perosona que no esta resgistrada</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div id="cancelarReserva" class="modal fade modal-warning" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center "><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Realmente quieres cancelar la reserva</h4>
                </div>
                <div class="modal-body">
                    <p id="reserva_mensaje" class="text-center"> </p>
                    <div id="responsables">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="corfirmarCancelacion" class="btn btn-warning" >Confirmar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
{{------end content--}}

@section('js')
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <script>
        var hora;
        var id ='{{Auth::user()->getToken->id}}';
        var id_res;
        var hoy= '{{$hoy}}';
        var horaActual = '{{$horaActual}}';
        var id_cancha;
        $(function () {
            id_cancha=$(".canc:first").data("id_cancha");
            $("#tituloTable").html($(".canc:first").data("nombre")+"  ("+$(".canc:first").data("tipo")+")");
            $(".canc:first").addClass("cancSelect");
            //alert(horaActual);
            $('#fecha').datepicker({
                autoclose: true,
                language: 'es',
                todayHighlight:true,
                Default: true,
                format:'yyyy-mm-dd'
            });

            var fecha="";

            $("#fecha").change(function () {
                if(fecha!=$("#fecha").val()){
                    fecha=$("#fecha").val();
                    //alert("cambio"+$("#fecha").val());
                    llenarDispo();
                }

            });

            $("#cancha").change(function () {
                //alert("el valor es "+$("#cancha").val());
                llenarDispo();
            });

            $("#motivos").change(function () {
                //alert("cambio "+$("#motivos").val());
                if($("#motivos").val()=="4"){
                    $("#otroMotivo").html("<div class='form-group'>"+
                    "<input type='text' class='form-control' id='motivo' name='motivos' placeholder='Motivo...'>"+
                            "</div>");
                }else{
                    $("#otroMotivo").html("");
                }
            });


            var formReserva= $("#formNuevoRes");
            formReserva.submit(function(e){
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('addNuevaReserva')}}',
                    data:formReserva.serialize()+"&fecha="+$("#fecha").val()+"&hora="+hora+"&id_cancha="+id_cancha,
                    success: function(data){

                        if(data=="exito"){
                            formReserva.reset();
                            llenarDispo();
                            $('#modalNuevoRes').modal('hide');
                        }
                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });


            var formRetirarToken= $("#formRetirarToken");
            formRetirarToken.submit(function(e){
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('retirarToken')}}',
                    data:formRetirarToken.serialize()+"&id_token="+id_res,
                    success: function(data){




                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });


            $(".canc").click(function () {
                $(".canc").removeClass("cancSelect");
                $(this).addClass("cancSelect");
                id_cancha=$(this).data("id_cancha");
                $("#tituloTable").html($(this).data("nombre")+"  ("+$(this).data("tipo")+")");
                llenarDispo();
            });

        });


        function llenarDispo() {
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('getDisponibilidad')}}',
                data:{'id_cancha':id_cancha,'fecha':$("#fecha").val()},
                success: function(data){

                    $("#tbody").empty();
                    $("#descripcion").html(data["descripcion"]);

                    if(data["horario"]=="cerrado"){
                        $("#rowCerrado").removeClass("hidden");
                        $("#rowAbierto").addClass("hidden");

                    }else{
                        $("#rowAbierto").removeClass("hidden");
                        $("#rowCerrado").addClass("hidden");
                    }


                    $.each(data["responsables"], function (hora, responsable) {
                        var html="";
                        if(responsable.length > 0){
                            html=html + '<tr class="respo ocupado" data-id="'+responsable[0]+'" data-respo="'+responsable[1]+'" data-hora="'+hora+'">' +
                                    '<td>'+((hora.trim().length<2)?"0"+hora.trim()+":00":hora+":00")+'</td>'+
                                    '<td>'+responsable[1]+'</td>'+
                                    '</tr>';
                        }else{
                            html=html + '<tr class="respo disponible" data-id="" data-respo="" data-hora="'+hora+'">' +
                                    '<td>'+((hora.trim().length<2)?"0"+hora.trim()+":00":hora+":00")+'</td>'+
                                    '<td></td>'+
                                    '</tr>';
                        }
                        $("#tbody").append(html);
                    });

                },
                error: function(){
                    console.log('ok');
                }
            });
        }

        var fila;

        $("#tbody").on("click",".respo",function () {
            fila = $(this);
            var respo= $( this ).data( "respo" );
                hora= $( this ).data( "hora" );
                id_res = $( this ).data( "id" );
            //alert(hora+" "+respo);
            var fechaHoy = Date.parse(hoy);
            var fechaSeleccionada = Date.parse($("#fecha").val());



            if(respo==''){

                if (fechaHoy == fechaSeleccionada){

                    //alert("hora actual "+horaActual+ "-> escrita "+hora);

                    if(parseInt(horaActual)>=parseInt(hora)){
                        alert("no se puede Reservar una hora que ya PASO");
                    }else{
                        $("#tituloNuevoRes").html("Reservar la "+$("#cancha option:selected").text());
                        $('#modalNuevoRes').modal('show');
                        $('#fechaReserva').text($("#fecha").val()+" a las "+((hora.length<2)?"0"+hora+":00":hora+":00"));
                    }

                    //alert("Primera es igual Segunda");
                } else if (fechaHoy > fechaSeleccionada) {
                    alert("no se puede Reservar una FECHA que ya PASO");
                } else{
                    $("#tituloNuevoRes").html("Reservar la "+$("#cancha option:selected").text());
                    $('#modalNuevoRes').modal('show');
                    $('#fechaReserva').text($("#fecha").val()+" a las "+((hora.length<2)?"0"+hora+":00":hora+":00"));
                }


            }else{

                if (fechaHoy == fechaSeleccionada){

                    if(parseInt(horaActual)>parseInt(hora)){
                        quitarTokenOno(id_res);
                    }else{
                        cancelarReserva($("#fecha").val(),hora);
                    }

                    //alert("Primera es igual Segunda");
                } else if (fechaHoy > fechaSeleccionada) {
                    quitarTokenOno(id_res);
                } else{
                    cancelarReserva($("#fecha").val(),hora);
                }



               // $('#modalToken').modal('show');
            }

        });

        function quitarTokenOno(id_res) {
            if(id==id_res){
                //alert("no se puede hacer sdancion ");
                $('#noEsUsuario').modal('show');
            }else{
                $('#modalToken').modal('show');
            }
        }

        var ids;
        function cancelarReserva(fecha,hora) {


            var cancha = id_cancha;
            //alert("cancelar la reserva en la cancha :" +$("#cancha").val()+"a las : "+$("#fecha").val()+" en la hora "+hora);
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('infoCancelarReserva')}}',
                data:{"cancha":cancha,"fecha":fecha,"hora":hora},
                success: function(data){
                    //console.log(data.responsable.length);
                    ids = data.ids;
                    var s = (data.responsable.length>1)?"Se cancelaran las reservas de":"Se cancelará las reserva de";

                    $("#reserva_mensaje").html(s);

                    $("#responsables").empty();
                    for(var i=0;i<data.responsable.length;i++){
                        html=  "<div class='callout callout-warning'>"+
                                "<h4 class='text-center'>"+data.responsable[i]+"</h4>"+
                                "<p>"+data.mensaje[i]+"</p>"+
                                "</div>" ;

                        $("#responsables").append(html);
                    }

                    $('#cancelarReserva').modal('show');

                },
                error: function(){
                    console.log('ok');
                }
            });
        }

        $("#corfirmarCancelacion").on("click",function () {

            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('cancelarReserva')}}',
                data:{"ids":ids},
                success: function(data){
                    //console.log(fila.children()[1]);
                    if(data["estado"]){
                        $(fila.children()[1]).empty();
                        fila.data("respo","");
                        fila.data("id","");
                        fila.removeClass("ocupado").addClass("disponible");
                    }

                },
                error: function(){
                    console.log('ok');
                }
            });




            console.log(ids);
            $('#cancelarReserva').modal('hide');
        });


    </script>
@endsection
{{------end js--}}
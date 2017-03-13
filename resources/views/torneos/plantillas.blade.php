@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}
    {!!Html::style('plugins/autocompletar/autocompletar.css')!!}
    <style>
        .informacion{
            font-size: 18px;
            text-align: center;
        }
        .titulo{
            margin: 10px;
            margin-bottom: 20px;
        }
        .bordered{
            border: solid 1px black;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .pointer {
            cursor: pointer;
        }
        .nuevaPlantilla:hover{
            color: blue;
        }
        .lista{
            margin-bottom: 15px;
        }

        .nuevaPlantilla, .plantilla{
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease;
        }
        .nuevaPlantilla:hover, .plantilla:hover{
            -webkit-transform:scale(1.13);
            -moz-transform:scale(1.13);
            -ms-transform:scale(1.13);
            -o-transform:scale(1.13);
            transform:scale(1.13);
            z-index: 1000000;
        }
        .selected{
            -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        }
        .eliminar:hover{
            color: red;
        }
    </style>
@endsection
{{------end css--}}


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="col-md-12">
                <div class="alert alert-success informacion alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Crea hasta <b>5</b> plantillas personalizadas de equipos, podrás fichar usuarios registrados de <b>enFutbol</b> para inscribirte con facilidad a los torneos junto con tu equipo.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="col-md-4 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3 class="titulo"><b>Mis plantillas</b></h3>
                        </div>
                        <div id="misplantillas">
                            @foreach($plantillas as $clave => $plantilla)

                                    <div class="col-xs-12 col-sm-4 col-md-12 text-center pointer lista">
                                        <div class="bordered plantilla {{($clave==0)?'selected':''}}" data-id="{{$plantilla->id}}">
                                            Nombre: <b>{{(strlen($plantilla->nombre) <= 10)?$plantilla->nombre:substr($plantilla->nombre, 0, 10).'...'}}</b><br>
                                            Genero: <b>{{($plantilla->genero == 'M')?'Masculino':'Femenino'}}</b><br>
                                            <b id="canJugadores{{$plantilla->id}}" data-cantidad="{{count($plantilla->getJugadores)}}">{{count($plantilla->getJugadores)}}</b> Jugador{{(count($plantilla->getJugadores) != 1)?'es':''}}
                                        </div>
                                    </div>

                            @endforeach
                        </div>
                            @if(count($plantillas) != 5)
                                <div class="col-xs-12 col-sm-4 col-md-12 text-center pointer lista">
                                    <div class="bordered nuevaPlantilla">
                                        <div>
                                            <i class="fa fa-plus-circle fa-3x add"></i><br>
                                            Nueva Plantilla
                                        </div>
                                    </div>
                                </div>
                            @endif


                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body" id="contePlantillas">
                        @if($plantillas->count() == 0)


                            <div class="text-center">
                                <h3 class="titulo"><b>Crear plantilla</b></h3>
                            </div>


                        <form id="formCrearPlantilla" class="form-horizontal">

                            <div class="form-group">
                                <label for="nombre" class="col-md-2 control-label">Nombre</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-th-list"></i>
                                        </div>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la plantilla.." required>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="nombre" class="col-md-2 control-label">Genero</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-venus-mars"></i>
                                        </div>
                                        <select class="form-control" id="genero" name="genero" required>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12 text-center" style="margin-top: 25px;">
                                    <button type="submit" id="btnPlantilla" class="btn btn-primary">Crear Planilla</button>
                                </div>
                            </div>
                            </form>


                        @endif
                    </div>
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
@endsection


@section('js')
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}
    {!!Html::script('plugins/autocompletar/jquery.mockjax.js')!!}
    {!!Html::script('plugins/autocompletar/jquery.autocomplete.js')!!}
    <script>
        var totalPlantillas = '{{count($plantillas)}}';
        var totalJugadores;
        $(function(){

            @if(count($plantillas) != 0)
                    ajaxDetallarPlantilla('{{($plantillas[0]->id)}}');
            totalJugadores = '{{count($plantillas[0]->getJugadores)}}';
            @endif


            $(".nuevaPlantilla").click(function(){
                console.log("nueva");
                nuevaPlantilla();
            });


//           $('#participantes').DataTable( {
//                "language": {
//                    "lengthMenu": "Mostrar  _MENU_ Solicitudes por Página",
//                    "zeroRecords": "Ningun registro",
//                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
//                    "infoEmpty": "No hay solicitudes",
//                    "infoFiltered": "(filtered from _MAX_ total records)"
//                }
//            });
        }); //FIN de ready


        $("#contePlantillas").on("submit","#formCrearPlantilla",function (e) {
            e.preventDefault();
            console.log($(this).serialize());
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('nuevaPlantilla')}}',
                data: $(this).serialize(),
                success: function(data) {
                    if(data.bandera){
                        $(".plantilla").removeClass("selected");
                        var html = "<div class='col-xs-12 col-sm-4 col-md-12 text-center pointer lista'>" +
                            "<div class='bordered plantilla selected' data-id='"+data.id+"'>"+
                        "Nombre: <b>"+data.nombre+"</b><br>"+
                        "Genero: <b>"+data.genero+"</b><br>"+
                        "<b id='canJugadores"+data.id+"' data-cantidad='0'>0</b> Jugadores"+
                        "</div></div>";
                        $("#misplantillas").append(html);
                        ajaxDetallarPlantilla(data.id);

                        if((data.totalPlantillas+1)==5){
                            $(".nuevaPlantilla").parent().remove();
                        }

                    }
                },
                error: function (data) {
                }
            });
        });

        $("#contePlantillas").on('click', '#iconoIntegrante', function(){
            if($("#user_id").val() != ''){
                var planilla = $("#autocompletar").data('plantilla');
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('addJugadorPlanilla')}}',
                    data: {usuario_id:$("#user_id").val(), plantilla:planilla},
                    success: function(data){
                        if(data.estado){
                            $("#participantes").append('<tr class="fila">' +
                                                            '<td>' + data.mensaje['get_usuario']['get_persona']['identificacion'] + '</td>' +
                                                            '<td>' + data.mensaje['get_usuario']['get_persona']['nombres'] + '</td>' +
                                                            '<td class="text-center" data-integrante="' + data.mensaje['id'] + '">' +
                                                                '<i class="fa fa-times-circle-o fa-2x eliminar pointer" aria-hidden="true" data-toggle="confirmation" data-singleton="true" data-placement="top" title="Eliminar?"></i>' +
                                                            '</td>' +
                                                        '</tr>');

                            var canti = parseInt($("#canJugadores"+planilla).data("cantidad")+1);
                            $("#canJugadores"+planilla).data("cantidad",canti);
                            $("#canJugadores"+planilla).html(canti)
                        }
                        else {
                            $("#modal-title").html("Error!").parents('.modal-header').addClass('alert-danger');
                            $("#content").html(data.mensaje);
                            $("#botonModal").addClass('btn-danger');
                            $("#notifModal").modal("show");
                        }
                        $("#autocompletar").val("");
                        $("#iconoIntegrante").addClass("hidden");
                        $("#user_id").val("");
                    },
                    error: function(data){

                    }
                });
            }
        }).on('click', '#btnPlantilla', function(){
            $("#formPlantilla").submit();
        });

        $("#misplantillas").on("click",".plantilla",function () {
            $(".plantilla").removeClass("selected");
            $(this).addClass("selected");
            ajaxDetallarPlantilla($(this).data("id"));

        });

        function ajaxDetallarPlantilla(plantilla_id){
            $('#contePlantillas').html("<div class='text-center'><i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i>" +
                "<span class='sr-only'>Loading...</span></div>");


            setTimeout(function(){
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('getPlantilla')}}',
                    data: {plantilla:plantilla_id},
                    success: function(data) {
                        $("#contePlantillas").html(data);
                        iniciarAutoComplete();
                    },
                    error: function (data) {
                    }
                });
            }, 500);


        }

        function iniciarAutoComplete(){
            $('#autocompletar').autocomplete({
                serviceUrl: '{{route("autoCompleUser")}}',
                lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function(suggestion) {
                    $("#iconoIntegrante").removeClass("hidden");
                    $("#user_id").val(suggestion.data);
                    console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
                },
                onHint: function (hint) {
                    $('#autocomplete-ajax-x').val(hint);
                },
                onInvalidateSelection: function() {
                    $("#iconoIntegrante").addClass("hidden");
                    $("#user_id").val("");
                }
            });
        }

        function eliminarJugador(elemento){
            var planilla = elemento.parents('#participantes').data('torneo');
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('delJugadorPlanilla')}}',
                data:{plantilla:planilla, jugador:elemento.data('integrante')},
                success: function(data){
                    if (data.estado) {
                        elemento.parents('.fila').remove();
                        var canti = parseInt($("#canJugadores"+planilla).data("cantidad")-1);
                        $("#canJugadores"+planilla).data("cantidad",canti);
                        $("#canJugadores"+planilla).html(canti)
                    }else {
                        $("#modal-title").html("Error!").parents('.modal-header').addClass('alert-danger');
                        $("#content").html(data.mensaje);
                        $("#botonModal").addClass('btn-danger');
                        $("#notifModal").modal("show");
                    }
                },
                error: function (data) {

                }
            });
        }


        function nuevaPlantilla() {
            var html = " <div class='text-center'> " +
                "<h3 class='titulo'><b>Crear plantilla</b></h3> " +
                "</div> " +
                "<form id='formCrearPlantilla' class='form-horizontal'> " +
                "<div class='form-group'> " +
                "<label for='nombre' class='col-md-2 control-label'>Nombre</label> " +
                "<div class='col-md-8'> " +
                "<div class='input-group date'> " +
                "<div class='input-group-addon'> " +
                "<i class='fa fa-th-list'></i> " +
                "</div> " +
                "<input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre de la plantilla..' required> " +
                "</div> " +
                "</div> " +
                "</div> " +
                "<div class='form-group'> " +
                "<label for='nombre' class='col-md-2 control-label'>Genero</label> " +
                "<div class='col-md-8'> " +
                "<div class='input-group date'> " +
                "<div class='input-group-addon'> " +
                "<i class='fa fa-venus-mars'></i> " +
                "</div> " +
                "<select class='form-control' id='genero' name='genero' required> " +
                "<option value='M'>Masculino</option> " +
                "<option value='F'>Femenino</option> " +
                "</select> " +
                "</div> " +
                "</div> " +
                "</div> " +
                "<div class='form-group'> " +
                "<div class='col-sm-12 text-center' style='margin-top: 25px;'> " +
                "<button type='submit' id='btnPlantilla' class='btn btn-primary'>Crear Planilla</button> " +
                "</div> " +
                "</div> " +
                "</form>";

            $("#contePlantillas").html(html);

        }




    </script>
@endsection
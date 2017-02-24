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
                        @foreach($plantillas as $clave => $plantilla)
                            <div class="col-xs-12 col-sm-4 col-md-12 text-center pointer lista">
                                <div class="bordered {{($clave==0)?'selected':'plantilla'}}">
                                    Nombre: <b>{{(strlen($plantilla->nombre) <= 10)?$plantilla->nombre:substr($plantilla->nombre, 0, 10).'...'}}</b><br>
                                    Genero: <b>{{($plantilla->genero == 'M')?'Masculino':'Femenino'}}</b><br>
                                    <b>{{count($plantilla->getJugadores)}}</b> Jugador{{(count($plantilla->getJugadores) != 1)?'es':''}}
                                </div>
                            </div>
                        @endforeach
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
                        @if($plantillas == null)

                        @endif
                    </div>
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
            if(totalPlantillas != 0){
                $('#contePlantillas').html("<div class='text-center'><i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i>" +
                        "<span class='sr-only'>Loading...</span></div>");
                setTimeout(function(){
                    ajaxDetallarPlantilla('{{count($plantillas[0]->id)}}');
                    totalJugadores = '{{count($plantillas[0]->getJugadores)}}';
                }, 500);
            }

//           $('#participantes').DataTable( {
//                "language": {
//                    "lengthMenu": "Mostrar  _MENU_ Solicitudes por Página",
//                    "zeroRecords": "Ningun registro",
//                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
//                    "infoEmpty": "No hay solicitudes",
//                    "infoFiltered": "(filtered from _MAX_ total records)"
//                }
//            });
        });

        function ajaxDetallarPlantilla(plantilla_id){
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('getPlantilla')}}',
                data: {plantilla:plantilla_id},
                success: function(data) {
                    $("#contePlantillas").html(data);
//                    iniciarAutoComplete();
                },
                error: function (data) {
                }
            });
        }

        function iniciarAutoComplete(){
            $('#autocompletar').autocomplete({
                serviceUrl: '{{route("autoCompleUser")}}',
                lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function(suggestion) {
                    console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
                },
                onHint: function (hint) {
                    $('#autocomplete-ajax-x').val(hint);
                },
                onInvalidateSelection: function() {
                    console.log('You selected: none');
                }
            });
        }
    </script>
@endsection
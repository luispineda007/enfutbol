@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}
    {!!Html::style('plugins/autocompletar/autocompletar.css')!!}

    <style>

    </style>


@endsection
{{------end css--}}

@section('Pageheader')

    <h1>
        Administrsción
        <small>Torneos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Torneos</li>
    </ol>

@endsection
{{------end css--}}

@section('content')

    <div class="row">


        <div class="col-sm-10 col-sm-offset-1">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a class="btn btn-default nuevopago" role="button">Registrar un nuevo Pago</a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <table id="sitiosRegistrados" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Sitio</th>
                            <th>Fecha Fin</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyUsers">
                        @foreach($pagosTorneos as $pagosTorneo)
                            <tr>
                                <td>{{$pagosTorneo->getUsuario->user}}</td>
                                <td>{{$pagosTorneo->getUsuario->rol}}</td>
                                <td>{{($pagosTorneo->getUsuario->getSitio==null)?"":$pagosTorneo->getUsuario->getSitio->nombre}}</td>
                                <td>{{$pagosTorneo->fecha_fin}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        {{--                    <tfoot>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                            </tfoot>--}}
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Registrar un pago para Servicio de Torneos</h4>
                </div>
                {!!Form::open(['id'=>'formPagoTorneo','class'=>'form-horizontal','autocomplete'=>'off'])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('autocompletar', 'Usuario',['class'=>'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('user',null,['id'=>'autocompletar','class'=>'form-control','placeholder'=>"identificacion o usuario", 'required'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('fecha_fin', 'Fecha Fin (*)',['class'=>'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                        {!!Form::text('fecha_fin',null,['class'=>'form-control pull-right','placeholder'=>'Selecciona una fecha','onkeypress'=>'return false;'])!!}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('valor', 'Valor',['class'=>'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    {!!Form::text('valor',null,['class'=>'form-control','placeholder'=>"Valor pagado", 'required', 'onkeypress' => 'return justNumbers(event)'])!!}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar Pago</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>


@endsection
{{------end content--}}

@section('js')
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}
    {!!Html::script('plugins/autocompletar/jquery.mockjax.js')!!}
    {!!Html::script('plugins/autocompletar/jquery.autocomplete.js')!!}

    <script>
        $(function () {

            $('#tablePagosTorneos').DataTable( {
                "language": {
                    "lengthMenu": "Mostrar  _MENU_ Sitios por Página",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            } );


            $(".nuevopago").click(function () {
                $("#myModal").modal("show");
            });
            $('#autocompletar').autocomplete({
                 serviceUrl: '{{route("autoCompleUser")}}',
//                lookup: countriesArray,
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


            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Clear",
                format: "yyyy/mm/dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $('#fecha_fin').datepicker({
                autoclose: true,
                startDate: '0d',
                language: 'es'
            });

            var formPagoTorneo = $("#formPagoTorneo");
            formPagoTorneo.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('pagosTorneoUser')}}',
                    data:formPagoTorneo.serialize(),
                    success: function(data){
                        console.log(data);
                        if(data.bandera){
                            var html= "<tr style='background-color: #cffbd0;'>" +
                                "<td>"+data.user+"</td> " +
                                "<td>"+data.rol+"</td> " +
                                "<td>"+data.sitio+"</td>" +
                                "<td>"+data.fecha_fin+"</td> " +
                                "</tr>";
                            $("#tbodyUsers").prepend(html);
                            $("#myModal").modal("hide");
                        }
                    },
                    error: function(data){

                    }
                });
            });

        });


    </script>
@endsection
{{------end js--}}
@extends('layouts.principal')

@section('css')
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <!-- Bootstrap time Picker -->
    {!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}
    <!-- DataTables -->
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
{{--    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">--}}
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}

    <style>
        #listadoSitios>tbody>tr>td{
            /*padding: 4px;*/
            text-align: center;
        }
    </style>



@endsection
{{------end css--}}

@section('Pageheader')

    <h1>
        Dashboard
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
    </ol>

@endsection
{{------end css--}}

@section('content')



        <div class="col-sm-10 col-sm-offset-1">

    {!!Form::open(['id'=>'canchastipo','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('tipo', 'Tipo de Cancha',['class'=>'hidden-xs hidden-sm']) !!}

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                {!!Form::select('tipo', ['11' => 'Futbol 11', '10' => 'Futbol 10', '9' => 'Futbol 9', '8' => 'Futbol 8', '7' => 'Futbol 7', '6' => 'Futbol 6', '5' => 'Futbol 5'], null, ['class'=>"form-control",'placeholder' => 'Tipo de Cancha', 'required'])!!}
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
                    <input type="text" name="fecha" class="form-control pull-right manito" id="fecha" placeholder="Fecha" readonly>
                </div>

        </div>
    </div>
    <div class="col-sm-4">
        <div class="bootstrap-timepicker">
            <div class="form-group">
                <label class='hidden-xs hidden-sm'>Time picker:</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input id="hora" name="hora" type="text" class="form-control timepicker manito" readonly placeholder="Hora">
                </div>
                <!-- /.input group -->
            </div>
            <!-- /.form group -->
        </div>
    </div>

    {!!Form::close()!!}



        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sitios Disponibles</h3>
                    </div>
                    <!-- /.box-header -->
                    <div id="boxHistorialToken" class="box-body">
                        <table id="listadoSitios" class="table cell-border table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Sitio</th>
                                <th class="text-center">No. canchas</th>
                                <th class="text-center">Ir al sitio</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

@endsection
{{------end content--}}

@section('js')
    <!-- bootstrap datepicker -->
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <!-- bootstrap time picker -->
    {!!Html::script('plugins//timepicker/bootstrap-timepicker.min.js')!!}
    <!-- DataTables -->
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}
    <script>

        var table;

        $(function () {
            sitiosCanchas(0,"2016-02-02","12");

            $(".timepicker").timepicker({
                showInputs: false,
                showSeconds: false,
                showMeridian: false,
                minuteStep:60,
                defaultTime:false
            }).on('hide.timepicker', function(e) {
                if($("#tipo").val()!=""&&$("#fecha").val()!="") {
                    table.destroy();
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
                language: 'es'
            }).on('changeDate', function () {

                if($("#tipo").val()!=""&&$("#hora").val()!=""){
                    table.destroy();
                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });

            $("#tipo").change(function () {

                if($("#hora").val()!=""&&$("#fecha").val()!=""){
                    table.destroy();
                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });


        });

/*        $('#hora').on('changeTime.timepicker', function(e) {
            console.log('The hour is ' + e.time.hours+"----"+ $("#fecha").getDates);
        });*/


        function sitiosCanchas(tipo,fecha,hora) {


            //console.log('funcioc( ' + tipo+"  , "+ fecha + " , "+ hora +" )");

            table = $('#listadoSitios').DataTable( {
                "ajax": {
                    url: 'getCanchasTipo/'+tipo+'/'+fecha+'/'+hora,
                },
                columns: [
                    { data: 'nombre' },
                    { data: 'canchas' }
                ]
                ,
                "columnDefs": [ {
                    "targets": 2,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary perfil'>Perfil del Sitio</button>"
                } ],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "pageLength": 3,
                "autoWidth": false
            } );
            //$('#example2').css("width","100%");

        }
        $('#listadoSitios tbody').on( 'click', '.perfil', function () {
            var data = table.row( $(this).parents('tr') ).data();

            //console.log("hola -> "+data["id_sitio"]);


        } );
    </script>

@endsection
{{------end js--}}
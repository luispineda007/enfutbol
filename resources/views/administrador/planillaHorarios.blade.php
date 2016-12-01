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
        .white{
            color: #efefef;
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
        .ocupado:hover{

        }

    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 panel panel-primary">
            <div class="panel-body">
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha: ',['class'=>'col-sm-4 control-label text-center', 'style'=>'padding-top:6px']) !!}
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
                </div>

                <div id="planilla">

                    <div class="row {{($estadoSitio == 'abierto')?'hidden':''}}" id="rowCerrado">
                        <div class="callout callout-danger">
                            <h4 class="text-center">El sitio se encuentra CERRRADO para esta fecha</h4>

                            <p class="text-center">Desea configurar el Horario? </p>
                        </div>
                    </div>

                    <div class="row" id="rowAbierto">
                        <div class="box">
                            <div class="box-header no-padding"></div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-bordered text-center">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @foreach($arrayCanchas as $cancha)
                                            <th>{!!ucwords($cancha[0])!!}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach($horarios as $hora => $horario)
                                            <tr data-hora="{{$hora}}">
                                                <td class="horas">{{$hora}}</td>
                                                @foreach($arrayCanchas as $cancha)
                                                    {{--{{dd(cancha[1]['responsables'][$hora])}}--}}
                                                    @if(!empty($cancha[1]['responsables'][$hora]))
                                                        <td class="ocupado white poin"  title="Detallar reserva!">{{ucwords($cancha[1]['responsables'][$hora][1])}}</td>
                                                    @else
                                                        <td class="disponible"></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <script>
        transformarHoras();
        var fecha='{{$hoy}}';
        $(function () {
            $('#fecha').datepicker({
                autoclose: true,
                language: 'es',
                todayHighlight:true,
                Default: true,
                format:'yyyy-mm-dd'
            });

            $("#fecha").change(function () {
                if($(this).val()!=fecha){
                    fecha = $(this).val();
                    llenarPlanilla();
                }

            });

            function llenarPlanilla(){
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('getPlanillas')}}',
                    data:{'fecha':fecha},
                    success: function(data){
                        $("#tbody").empty();
                        if(data["estadoSitio"]=="cerrado"){
                            $("#rowCerrado").removeClass("hidden");
                            $("#rowAbierto").addClass("hidden");

                        }else{
                            var html ="";
                            $("#rowAbierto").removeClass("hidden");
                            $("#rowCerrado").addClass("hidden");
                            $.each(data["horarios"], function (hora, horario) {

                                html = html + "<tr data-hora="+hora+">" +
                                                    "<td class='horas'>"+hora+"</td>";
                                $.each(data["arrayCanchas"], function (index, cancha) {
                                   if (cancha[1]['responsables'][hora] != "")
                                       html = html + "<td class='ocupado white poin'>" + cancha[1]['responsables'][hora][1] + "</td>";
                                   else
                                       html = html + "<td class='disponible'></td>";
                                });
                                html = html + "</tr>";
                            });
                            $("#tbody").append(html);
                            transformarHoras();
                        }
                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            }
        });

        function transformarHoras() {
            $(".horas").each(function (index) {
                $(this).html(formatHora($(this).html()));
            });
        }
    </script>
@endsection
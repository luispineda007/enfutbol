@extends('layouts.principal')

@section('css')
    <style>
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
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">

                <div class="panel-body">

                    <h2 class="text-center" style="margin-bottom: 30px"> {{$torneo->nombre}}</h2>

                    <div class="col-md-6">
                        <img src="{{url("images/torneos/".$torneo->url_logo)}}" alt="" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-text-width"></i>

                                <h3 class="box-title">Descripción del Torneo</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <dl class="dl-horizontal">
                                    <dt>Ciudad:</dt>
                                    <dd>{{$torneo->getMunicipio->municipio}}</dd>
                                    <dt>Lugar:</dt>
                                    <dd>{{($torneo->sitio_id!=0)?$torneo->getSitio->nombre:$torneo->lugar}}</dd>
                                    <dt>Responsable:</dt>
                                    <dd>{{$torneo->getUsuario->getPersona->nombres}}</dd>
                                    <dt>Maximo de equipos:</dt>
                                    <dd>{{$torneo->max_equipos}}</dd>
                                    <dt>jugadores por equipos:</dt>
                                    <dd>{{$torneo->max_jugadores}}</dd>
                                    <dt>tipo de cancha:</dt>
                                    <dd>Futbol {{$torneo->tipo_cancha}}</dd>
                                    <dt>tipo de Inscrpción:</dt>
                                    <dd>{{($torneo->privacidad=="A")?"Abierta":"Cerrada (inspriccion con código)"}}</dd>
                                    <dt>Fecha de Inscripciones</dt>
                                    <dd> hasta el <b>{{$torneo->maxFecha_inscripcion}}</b></dd>
                                    <dt>Genero:</dt>
                                    <dd>{{($torneo->genero=="M"?"Masculino":"Femenino")}}</dd>
                                    <dt>Premiacion:</dt>
                                    <dd>{{$torneo->premiacion}}</dd>
                                    <dt>Valor inscripción:</dt>
                                    <dd><b style="font-size: 18px">${{number_format ($torneo->vlr_inscripcion,0,",",".")}}</b></dd>
                                </dl>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>

                <div class="col-md-12">
                    <h4>Detalles del torneo</h4>
                    {{$torneo->descripcion}}
                </div>

                </div>{{--fin panel body--}}
                <div class="row text-center" style="margin-bottom: 20px;">

                @if(Auth::guest())
                        <a class="btn btn-success" href="{{route('myLoginModal')}}"   data-modal=""  >
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="hidden-xs"> Iniciar Sesión </span>
                        </a>

                @else

                    @if(empty($participo))

                        {!!Form::open(['route'=>'inscribeTuEquipo','class'=>'form-horizontal'])!!}
                            <input type="hidden" name="torneo" value="{{$torneo->id}}">
                            <input type="submit" class="btn btn-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}" value="INSCRIBE TU EQUIPO" id="">

                        {!!Form::close()!!}

                    @else

                            <div class="row">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Perfecto!</strong> Ya estas participando en este campeonato con el equipo ( <b>{{$participo->nombre}}</b> ).
                                    </div>
                                </div>
                            </div>


                    @endif




                @endif



                </div>
            </div>

        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">

                <div class="panel-body">

                    <h2 class="text-center"> Otros Torneos</h2>

                    <div id="conteBusTorneos">

                        <div class="row">
                            @foreach($torneos as $torneo)

                                <div class="col-sm-6 col-md-3 product-grid">
                                    <div class="thumbnail manito" data-torneo="{{$torneo->id}}">
                                        <div class="product-location text-center">
                                            <span class="fa-map-marker fa"></span> {{$torneo->getMunicipio->municipio}}
                                            <h4>{{($torneo->sitio_id!=0)?$torneo->getSitio->nombre:$torneo->lugar}}</h4>
                                        </div>
                                        <img src="/images/torneos/{{$torneo->url_logo}}" alt="..." >
                                        <div class="caption">
                                            <small>{{$torneo->created_at}}</small>
                                            <small class="pull-right">
                                                <span class="fa-venus-mars fa"></span><b> {{$torneo->genero}}</b>
                                            </small>
                                            <h4>{{$torneo->nombre}}</h4>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>

                        <div class="row text-center">
                            {!! $torneos->render() !!}
                        </div>


                    </div>


                </div>{{--fin panel body--}}

            </div>

        </div>
    </div>

@endsection


@section('js')
    <script>

        $(document).on("click",".thumbnail",function () {
            console.log("hola"+$(this).data("torneo"));
            window.location = ""+$(this).data("torneo");
        });

        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            getTorneos();
        });
        function getTorneos() {
            $.ajax({
                type:"GET",
                context: document.body,
                url: '{{route('buscarTorneos')}}',
                data:{nombre:$("#nombre").val(),estado:$("#estado").val(),page:page},
                success: function(data){
                    $("#conteBusTorneos").html(data);
                },
                error: function (data) {

                }
            });
        }
    </script>
@endsection

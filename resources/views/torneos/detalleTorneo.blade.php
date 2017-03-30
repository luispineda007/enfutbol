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
        .codigo{
            color: #fd4937;
            cursor: default;
        }
        #divFoto{
            padding-top: 18px;
        }
        @media (min-width: 300px) and (max-width: 449px){
            #divFoto{
                text-align: center;
                margin-bottom: 15px;
            }
            #foto{
                width: 200px;
                height: 200px;
            }
            h2.text-center{
                margin-bottom: 15px;
            }
        }
        @media (min-width: 450px) and (max-width: 991px) {
            #divFoto{
                text-align: center;
                margin-bottom: 15px;
            }
            #foto{
                width: 250px;
                height: 250px;
            }
            h2.text-center{
                margin-bottom: 15px;
            }
        }
        @media (min-width: 992px){
            .detalles{
                border-top: solid 2px #0040FF;
            }
        }
        .izq{
            text-align: right;
            font-weight: 900;
            padding-right: 8px;
            background-color: #d6e8f3;
            padding-left: 20px;
        }
        .der{
            text-align: left;
            padding-left: 4px;
            padding-right: 20px;
        }
        td{
            border-bottom: 1px solid black;
        }
        .detalles{
            margin-top:20px;
            padding-bottom: 15px;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                <div class="panel-body">
                    <h2 class="text-center" style="margin-bottom: 15px">Torneo: <b>{{$torneo->nombre}}</b></h2>

                    <div class="row">
                        <div class="col-xs-12 col-md-6 text-right" id="divFoto">
                            <img src="{{url("images/torneos/".$torneo->url_logo)}}" alt="" height="278px" width="278px" id="foto">
                        </div>

                        <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-0">
                            <div class="text-center">
                                <table>
                                    <tr>
                                        <td class="izq">Ciudad</td>
                                        <td class="der">{{$torneo->getMunicipio->municipio}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Lugar</td>
                                        <td class="der">{{($torneo->sitio_id!=0)?$torneo->getSitio->nombre:$torneo->lugar}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Responsable</td>
                                        <td class="der">{{$torneo->getUsuario->getPersona->nombres}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Cant. equipos</td>
                                        <td class="der">{{$torneo->max_equipos}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Jugadores <br>equipo</td>
                                        <td class="der">{{$torneo->max_jugadores}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Tipo de cancha</td>
                                        <td class="der">Futbol {{$torneo->tipo_cancha}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Tipo inscripcion</td>
                                        @if($torneo->privacidad=="C")
                                            <td class="der codigo" data-toggle="tooltip" data-placement="left" title="Debes solicitar un código de inscripción al administrador del torneo."><b>Con codigo</b></td>
                                        @else
                                            <td>Libre</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="izq">Cierre <br> Inscripciónes</td>
                                        <td class="der"><b>{{$torneo->maxFecha_inscripcion}}</b></td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Genero</td>
                                        <td class="der">{{($torneo->genero=="M"?"Masculino":"Femenino")}}</td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Premiación</td>
                                        <td class="der">
                                            @foreach(explode(',', $torneo->premiacion) as $premio)
                                                {{$premio}}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="izq">Valor inscripción</td>
                                        <td class="der"><b style="font-size: 18px">{{number_format ($torneo->vlr_inscripcion,0,",",".")}}</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 col-md-offset-3 detalles">
                            <h4><b>Detalles del torneo</b></h4>
                            {{$torneo->descripcion}}
                        </div>
                    </div>

                </div>

                <div class="row text-center" style="margin-bottom: 20px;">
                    @if(Auth::guest())
                        <a class="btn btn-success" href="{{route('myLoginModal')}}"   data-modal="" data-toggle="tooltip" data-placement="bottom" title="Inscribir tu equipo al torneo">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="hidden-xs"> Inscribirme! </span>
                        </a>
                    @else
                        @if($participo==null && $capitan==null)
                            {!!Form::open(['route'=>'inscribeTuEquipo','class'=>'form-horizontal'])!!}
                                <input type="hidden" name="torneo" value="{{$torneo->id}}">
                                <input type="submit" class="btn btn-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}" value="PARTICIPAR!" data-toggle="tooltip" data-placement="bottom" title="Inscribir tu equipo al torneo">
                            {!!Form::close()!!}
                        @else
                            <div class="row">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Perfecto!</strong> Ya estas participando en este campeonato con el equipo ( <b>{{($participo)?$participo->nombre:$capitan->nombre}}</b> ).
                                    </div>
                                </div>
                            </div>
                            @if($capitan != null && $torneo->estado =='A')
                                <input type="button" class="btn btn-success" value="Editar Equipo" id="editarEquipo">
                            @endif
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

        $("#editarEquipo").click(function(){
            @if(isset($capitan))
                    window.location = '/adminEquipo/{{$capitan->equipoTorneo}}';
            @endif
        });
    </script>
@endsection

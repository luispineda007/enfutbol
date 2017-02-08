@extends('layouts.principal')

@section('css')
    <style>
        .pointer{
            cursor: pointer;
        }
        .torneo, .nuevo{
            -webkit-transition:all .9s ease; /* Safari y Chrome */
            -moz-transition:all .9s ease; /* Firefox */
            -o-transition:all .9s ease; /* IE 9 */
            -ms-transition:all .9s ease;
        }
        .torneo:hover, .nuevo:hover{
            -webkit-transform:scale(1.13);
            -moz-transform:scale(1.13);
            -ms-transform:scale(1.13);
            -o-transform:scale(1.13);
            transform:scale(1.13);
            z-index: 1000000;
        }
        .nuevo:hover{
            color: blue;
        }
        .editProfPic{
            position:absolute;
            top:15px;
            z-index:1;
            text-align: right;
            /*padding-top: 9px;*/
            color: #a10000;
            right: 10px;
            /*margin-right: 20px;*/
        }
        .eliminar{
            background-color: white;
            border-radius: 50%;
            padding: 5px;
        }
        .eliminar:hover{
            background-color: rgb(251, 255, 255);
            cursor: pointer;
        }
        .abuelo{
            position: relative;
        }
        .confirmation .popover-content {
            width: 180px;
        }
        .btn-xs{
            padding: 4px 10px;
        }
        .confirmation-content{
            color: #0c0c0c;
            font-size: 13px;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Mis torneos</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12" id="albums">
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2" id="padreNuevo">
                                <div class="panel panel-default pointer nuevo">
                                    <div class="panel-body" style="padding: 70px 0;">
                                        <center>
                                            <i class="fa fa-plus-square fa-4x"></i>
                                            <div style="padding-top: 5px">Crear Torneo</div>
                                        </center>
                                    </div>
                                </div>
                            </div>

                            @foreach($torneos as $torneo)
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2" data-album="{{$torneo->id}}">
                                    <div class="panel pointer torneo">
                                        <div class="panel-body abuelo" style="padding: 0;">
                                            <center>
                                                <div class="editProfPic">
                                                    <i class='fa fa-trash fa-2x eliminar manito' aria-hidden='true' data-toggle='confirmation' data-singleton="true" data-placement='top' title='Atencion!'  data-content="El álbum y sus imágenes se borrarán, ¿Continuar?:" data-btn-ok-label="Si" data-btn-cancel-label="No"></i>
                                                </div>

                                                <img src="/images/torneos/{{$torneo->url_logo}}" width="100%" height="158px">

                                            </center>
                                        </div>
                                        <div class="panel-footer">
                                            <b>{{$torneo->nombre}}</b><br>
                                            <b>{{($torneo->estado == 'A')?'Abierto':'Cerrado'}}</b>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>
        $("#padreNuevo").on('click', '.nuevo', function(){
            window.location = '{{route('torneoNuevo')}}';
        });
    </script>
@endsection
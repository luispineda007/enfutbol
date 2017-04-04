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
        .tituloTorneo{
            margin: 7px 0 15px 0;
        }
    </style>
@endsection
{{------end css--}}


@section('content')

    <div class="row">
        <div class="col-xs-offset-1 col-xs-10">
            <div class="panel panel-default">
                <div class="panel-body">

                    @if(empty($mistorneos))

                    @else
                        <div class="col-xs-12">
                            <div class="box box-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                                <div class="box-header with-border">
                                    <h3 class="box-title text-center">Torneos en donde participo </h3>
                                    <span class="label label-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}} pull-right"><i class="fa fa-html5"></i></span>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    @foreach($mistorneos as $mistorneo)
                                        <div class="col-sm-6 col-md-3 product-grid">
                                            <div class="thumbnail manito" data-torneo="{{$mistorneo->id}}">
                                                <div class="product-location text-center">
                                                    <span class="fa-map-marker fa"></span> {{$mistorneo->municipio}}
                                                </div>
                                                <img src="/images/torneos/{{$mistorneo->url_logo}}" alt="...">
                                                <div class="caption">
                                                    <small>{{$mistorneo->created_at}}</small>
                                                    <small class="pull-right">
                                                        <span class="fa-venus-mars fa"></span><b> {{$mistorneo->genero}}</b>
                                                    </small>
                                                    <h4>{{$mistorneo->nombre}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    @endif


                        <div class="col-xs-12">
                            <div class="box box-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}}">
                                <div class="box-header with-border">
                                    <h3 class="box-title text-center">Buscar un torneo por nombre </h3>
                                    <span class="label label-{{(Auth::guest())?"success":((Auth::user()->rol=="admin")?"primary":"success")}} pull-right"><i class="fa fa-html5"></i></span>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                    {!!Form::open(['id'=>'formGetTorneos','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {!! Form::label('nombre', 'Nombre Torneo',['class'=>'hidden-xs hidden-sm']) !!}

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','placeholder'=>"Nombre torneo"])!!}

                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {!! Form::label('estado', 'Estado',['class'=>'hidden-xs hidden-sm']) !!}

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-bars"></i>
                                                </div>
                                                {!!Form::select('estado', ['A' => 'Inscripciones abiertas', 'C' => 'Jugando', 'T' => 'Terminado'], null, ['class'=>"form-control", 'required','id'=>'estado'])!!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label for="ciudad" class='hidden-xs hidden-sm'>Ciudad</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </div>
                                                    {!!Form::select('ciudad', ['v' => 'Villavicencio', 'a' => 'Acacias', 'g' => 'Granada'], null, ['class'=>"form-control", 'required','id'=>'tipo'])!!}
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </div>

                                    {!!Form::close()!!}
                                        </div></div>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    <div class="col-xs-12">
                        <div id="conteBusTorneos">

                        <div class="row">
                            @foreach($torneos as $torneo)

                                <div class="col-sm-6 col-md-3 product-grid">
                                    <div class="thumbnail manito" data-torneo="{{$torneo->id}}">
                                        <div class="product-location text-center">
                                            <h3 class="tituloTorneo">{{$torneo->nombre}}</h3>
                                        </div>
                                        <img src="/images/torneos/{{$torneo->url_logo}}" alt="..." >
                                        <div class="caption">
                                            <div style="margin-bottom: 7px">
                                                <small class="pull-right">
                                                    <span class="fa-venus-mars fa"></span><b> {{$torneo->genero}}</b>
                                                </small>
                                                <div style="font-size: 15px;">{{($torneo->sitio_id!=0)?$torneo->getSitio->nombre:$torneo->lugar}}</div>
                                                <span class="fa-map-marker fa"></span> {{ucwords(strtolower($torneo->getMunicipio->municipio))}}
                                            </div>


                                            <small>{{explode(" ",$torneo->created_at)[0]}}</small>

                                            {{--<h4>{{$torneo->nombre}}</h4>--}}
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>

                        <div class="row text-center">
                            {!! $torneos->render() !!}
                        </div>


                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="detallesTorneo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Detalle Torneo</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')

    <script>
        var page;
    $(function () {

        var formGetTorneos = $("#formGetTorneos");
        formGetTorneos.submit(function (e) {
            e.preventDefault();
            page=1;
            getTorneos()
        });

        $("#nombre").change(function () {
            page=1;
            getTorneos()
        });
        $("#estado").change(function () {
            page=1;
            getTorneos()
        });
    });

    $(document).on("click",".thumbnail",function () {
        console.log("hola"+$(this).data("torneo"));
        window.location = "detalleTorneo/"+$(this).data("torneo");
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
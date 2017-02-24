@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
    <style>
        .pointer{
            cursor: pointer;
        }

        .small-box:hover{
            box-shadow: 5px 5px 5px #292929;
        }

        .tipoSelect{
            box-shadow: 8px 8px 5px #337ab7;
        }
        .equipo{
            background-color: #d9edf7;
            cursor: move;
            border: solid 1px #a4a4a4;
            padding: 5px;
            height: 50px;
            overflow: hidden;
        }
        .equipo>span {
            padding-left: 10px;
        }


        #sortable1, #sortable2, #sortable3 {
            list-style-type: none;
            margin: 0; float: left;
            margin-right: 10px;
            background: #eee;
            padding: 5px;
            width: 100%;
            min-height: 100px;
        }
        #sortable1 li, #sortable2 li, #sortable3 li {
            margin: 5px;
            padding: 5px;
            font-size: 1.2em;
         }

    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Configuración Fase 1</h4>
                </div>
                <div class="panel-body">

                    <div class="col-md-10 col-md-offset-1">
                        <!-- Horizontal Form -->

                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>

                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="inputPassword3" placeholder="EJ: Eliminación">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    {{--<div class="col-xs-12 text-center">Tipo de competición</div>--}}

                                    <h4 class="text-center">Tipo de competición</h4>

                                    <div class="col-sm-6">
                                        <div class="col-xs-10 col-xs-offset-1">
                                            <!-- small box -->
                                            <div class="small-box bg-yellow pointer">
                                                <div class="inner" style="height: 82px;">
                                                    <h3></h3>

                                                    <p>Todos contra Todos</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-globe"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    More info <i class="fa fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="col-xs-10 col-xs-offset-1">
                                            <!-- small box -->
                                            <div class="small-box bg-green pointer">
                                                <div class="inner" style="height: 82px;">
                                                    <h3></h3>

                                                    <p>Eliminación directa</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-user-times"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    More info <i class="fa fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>



                                </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Sign in</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>





                    </div>

                    <div id="conteEquipos" class="col-sm-3">
                        {{--<div class="col-xs-12 equipo draggable">--}}
                            {{--<img src="{{url('images/torneos/escudos')}}/manchesterU.png" alt="" height="40px"><span>Manchester U</span>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 equipo draggable">--}}
                            {{--<img src="{{url('images/torneos/escudos')}}/manchesterC.png" alt="" height="40px"><span>Manchester wew wwewewewewewewewe wew ewew weweww</span>--}}
                        {{--</div>--}}

                        <ul id="sortable1" class="dropequipos">
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/manchesterU.png" alt="" height="40px"><span>Manchester U</span></li>
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/manchesterC.png" alt="" height="40px"><span>Manchester City</span></li>
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/LEICESTER CITY.png" alt="" height="40px"><span>LEICESTER CITY</span></li>
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/lincolncity.jpg" alt="" height="40px"><span>Lincoln CITY</span></li>
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/liverpool.png" alt="" height="40px"><span>Liverpool</span></li>
                            <li class="equipo"><img src="{{url('images/torneos/escudos')}}/Newcastle United.png" alt="" height="40px"><span>Newcastle United</span></li>
                        </ul>





                    </div>
                    <div class="col-sm-9">

                        <div class="col-md-6 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Grupo A</h3>
                                </div>
                                <div class="panel-body">
                                    <ul id="sortable2" class="dropgrupos">

                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Grupo B</h3>
                                </div>
                                <div class="panel-body">
                                    <ul id="sortable3" class="dropgrupos">

                                    </ul>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection


@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}

    <script>
        $(function(){

//            $( ".draggable" ).draggable({helper: "clone",
//                revert: "invalid"
//            });

            $( "ul.dropequipos" ).sortable({
                connectWith: ".dropgrupos"
//                disabled: true
            });

            $( "ul.dropgrupos" ).sortable({
                connectWith: ".dropgrupos",
                receive: function( event, ui ) {

                    var hijos = $(this).children();
                    console.log(hijos.length);
                    if(hijos.length<1){
                        console.log("se recibe");
                    }else{
                        console.log("se rechaza");
                    }

                }
            });

            $( "#sortable1, #sortable2, #sortable3" ).disableSelection();

            $(".small-box").click(function(){
                $(".small-box").removeClass("tipoSelect");
                $(this).addClass("tipoSelect");

            });

        });//fin Ready

    </script>
@endsection

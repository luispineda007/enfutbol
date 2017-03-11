@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
    {!!Html::style('plugins/iCheck/all.css')!!}
    <style>
        .pointer{
            cursor: pointer;
        }

        .small-box:hover{
            box-shadow: 5px 5px 5px #292929;
        }

        .tipoSelect{
            box-shadow: 15px 15px 10px #337ab7;
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


        .dropequipos, .dropgrupos {
            list-style-type: none;
            margin: 0; float: left;
            margin-right: 10px;
            background: #eee;
            padding: 5px;
            width: 100%;
            min-height: 100px;
        }
        .dropequipos li, .dropgrupos li {
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
                                            <label for="nombre" class="col-sm-2 control-label">Nombre</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre" placeholder="EJ: Eliminación">
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
                                            <div class="small-box bg-yellow pointer tipoCompeticion" data-competicion="tvt">
                                                <div class="inner" style="height: 82px;">
                                                    <h3></h3>

                                                    <p>Todos contra Todos</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-globe"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    Seleccionar <i class="fa fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-xs-12">
                                            <div class="form-group hidden" id="grupoCheck" >
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>

                                                            <input type="checkbox" class="minimal" id="checkGrupos"> <b>Hacer grupos</b>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-sm-6">
                                        <div class="col-xs-10 col-xs-offset-1">
                                            <!-- small box -->
                                            <div class="small-box bg-green pointer tipoCompeticion" data-competicion="ed">
                                                <div class="inner" style="height: 82px;">
                                                    <h3></h3>

                                                    <p>Eliminación directa</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa fa-user-times"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    Seleccionar <i class="fa fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>



                                </div>




                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <h3 id="tituloCompeticion"></h3>
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

                        {{--<ul id="sortableequipos" class="dropequipos">--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/manchesterU.png" alt="" height="40px"><span>Manchester U</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/manchesterC.png" alt="" height="40px"><span>Manchester City</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/LEICESTER CITY.png" alt="" height="40px"><span>LEICESTER CITY</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/lincolncity.jpg" alt="" height="40px"><span>Lincoln CITY</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/liverpool.png" alt="" height="40px"><span>Liverpool</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/Newcastle United.png" alt="" height="40px"><span>Newcastle United</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/CHELSEA.png" alt="" height="40px"><span>Chelsea</span></li>--}}
                            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/everton.png" alt="" height="40px"><span>Everton</span></li>--}}
                        {{--</ul>--}}





                    </div>
                    <div id="conteAdminCompeti" class="col-sm-9" >

                        {{--<div class="col-md-6 col-lg-4">--}}
                            {{--<div class="panel panel-default">--}}
                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">Grupo A <span class="pull-right"><i class="fa fa-unlock pointer icon-lock" aria-hidden="true" data-estado="A"></i></span></h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body">--}}
                                    {{--<ul id="sortableGrupoA" class="dropgrupos">--}}

                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-lg-4 col-md-6">--}}
                            {{--<div class="panel panel-default">--}}
                                {{--<div class="panel-heading">--}}
                                    {{--<h3 class="panel-title">Grupo B <span class="pull-right"><i class="fa fa-unlock pointer icon-lock" aria-hidden="true"></i></span> </h3>--}}
                                {{--</div>--}}
                                {{--<div class="panel-body">--}}
                                    {{--<ul id="sortableGrupoB" class="dropgrupos">--}}

                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}


                    </div>



                </div>{{--fin panel body--}}
                <div class="row text-center" style="margin-bottom: 20px;">
                    <input type="submit" class="btn btn-primary" value="Iniciar Fase" id="">
                </div>
            </div>

        </div>

    </div>

@endsection


@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    {!!Html::script('plugins/iCheck/icheck.min.js')!!}


    <script>

        var equipos = new Array();

        $(function(){
            {{--<li class="equipo"><img src="{{url('images/torneos/escudos')}}/manchesterU.png" alt="" height="40px"><span>Manchester U</span></li>--}}


            equipos.push({id:1,escudo:"{{url('images/torneos/escudos')}}/manchesterU.png",nombre:"Manchester U"});
            equipos.push({id:2,escudo:"{{url('images/torneos/escudos')}}/manchesterC.png" ,nombre:"Manchester City"});
            equipos.push({id:3,escudo:"{{url('images/torneos/escudos')}}/LEICESTER CITY.png" ,nombre:"LEICESTER CITY"});
            equipos.push({id:4,escudo:"{{url('images/torneos/escudos')}}/lincolncity.jpg" ,nombre:"Lincoln CITY"});
            equipos.push({id:5,escudo:"{{url('images/torneos/escudos')}}/liverpool.png" ,nombre:"Liverpool"});
            equipos.push({id:6,escudo:"{{url('images/torneos/escudos')}}/Newcastle United.png" ,nombre:"Newcastle United"});
            equipos.push({id:7,escudo:"{{url('images/torneos/escudos')}}/CHELSEA.png" ,nombre:"Chelsea"});
            equipos.push({id:8,escudo:"{{url('images/torneos/escudos')}}/everton.png" ,nombre:"Everton"});
            
            //console.log(equipos);

            
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
//            $( ".draggable" ).draggable({helper: "clone",
//                revert: "invalid"
//            });


            $(".small-box").click(function(){
                $(".small-box").removeClass("tipoSelect");
                $(this).addClass("tipoSelect");

            });

            $(".tipoCompeticion").click(function(){
                if($(this).data("competicion")=="tvt"){
                    console.log("seleccionar tvt");
                    $("#tituloCompeticion").html("Todos contra Todos");
                    $("#grupoCheck").removeClass("hidden");
                    hacerTvTLiga();
                }else{
                    console.log("seleccionar eliminacion directa");
                    $("#tituloCompeticion").html("Eliminacion Directa");
                    $("#grupoCheck").addClass("hidden");
                    $("#checkGrupos").iCheck("uncheck");
                    hacerEDirecta();
                }
            });


        });//fin Ready

        
        $("#conteAdminCompeti").on("click",".icon-lock",function () {
            bloDesContenedor($(this));

        });

        function bloDesContenedor(elemento) {
            if(elemento.data("estado")=="C"){
                elemento.removeClass("fa-lock").addClass("fa-unlock");
                elemento.data("estado","A");
                elemento.effect( "pulsate", [], 500 );
            }else{
                elemento.removeClass("fa-unlock").addClass("fa-lock");
                elemento.data("estado","C");
                elemento.effect( "pulsate", [], 500 );
            }
        }

        $("#checkGrupos").on('ifClicked', function (e) {
            if (!e.currentTarget['checked']) {
                console.log("crear todo con los grupos");
                hacerTvTGrupos();
            }
            else{
                console.log("NO crear todo con los grupos y borrar lo existente");
                hacerTvTLiga();
                $("#conteEquipos").html("");
            }
        });

        $("#conteAdminCompeti").on("click","#btncreargrupos",function () {
            console.log("crear los grupos indicados"+$("#sltgrupos").val());
            llenargruposequipos($("#sltgrupos").val());
        });



        function hacerTvTLiga() {
            var html ="Liga";
            $("#conteAdminCompeti").html(html);
            $("#conteEquipos").html("");
        }

        function hacerTvTGrupos() {
            var html ="<div class='row'>" +
                "<div class='form-horizontal'>" +
                "<div class='row'> " +
                "<div class='form-group'> " +
                "<label for='inputEmail3' class='col-sm-2 control-label'>Cuantos grupos</label> " +
                "<div class='col-sm-4'> " +
                "<select id='sltgrupos' class='form-control'> " +
                "<option>2</option> " +
                "<option>3</option> " +
                "<option>4</option> " +
                "<option>5</option> " +
                "</select> " +
                "</div> " +
                "<div class='col-sm-3'> " +
                "<button id='btncreargrupos' class='btn btn-primary'>Crear grupos</button> " +
                "</div> </div> " +
                "</div> " +
                "</div> " +
                "</div>" +
                "<div class='row'>" +
                "<div id='divcontegrupos' class='col-xs-12'></div></div>";
            $("#conteAdminCompeti").html(html);
            llenarEquipos();
        }

        function hacerEDirecta() {
            var html =" hacer el arbol";
            $("#conteAdminCompeti").html(html);
            llenarEquipos();
        }

        function llenarEquipos() {

            var html="<ul id='sortableequipos' class='dropequipos'>";

            $.each(equipos,function (index,value) {
                html = html+"<li class='equipo'><img src='"+value.escudo+"' alt='' height='40px'><span> "+value.nombre+"</span></li>";
            });

            $("#conteEquipos").html(html);
            $( "ul.dropequipos" ).sortable({
                connectWith: ".dropgrupos"
//                disabled: true
            });

        }

        function llenargruposequipos(numgrupos) {
            var letras = ["A","B","C","D","E","F","G","H","I","J","K"];
            var html="";

            for(var i = 0; i<parseInt(numgrupos); i++){
                html=html+"<div class='col-md-6 col-lg-4'> " +
                    "<div class='panel panel-default'> " +
                    "<div class='panel-heading'> " +
                    "<h3 class='panel-title'>Grupo "+letras[i]+" <span class='pull-right'><i class='fa fa-unlock pointer icon-lock' aria-hidden='true' data-estado='A'></i></span></h3> " +
                    "</div> " +
                    "<div class='panel-body'> " +
                    "<ul id='sortableGrupo"+letras[i]+"' class='dropgrupos'> " +
                    "</ul> " +
                    "</div> " +
                    "</div> " +
                    "</div>";
            }
            $("#divcontegrupos").html(html);
            $( ".dropgrupos" ).disableSelection();
            $( "ul.dropgrupos" ).sortable({
                connectWith: ".dropgrupos",
                receive: function( event, ui ) {

                    var hijos = $(this).children();
                    console.log(hijos.length);
                    if(hijos.length==1){
                        console.log("se recibe");
                    }else{
                        console.log("se rechaza");
                    }

                }
            });

        }



    </script>
@endsection

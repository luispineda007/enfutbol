@extends('layouts.principal')

@section('css')
    <link href="plugins/bootstrapFileInput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <style>
        textarea{
            resize:none;
        }
        .centrar{
            width : 180px;
            margin-left : auto;
            margin-right : auto;
        }
    </style>

@endsection
{{------end css--}}

{{--@section('Pageheader')--}}

    {{--<h1>--}}
        {{--Dashboard--}}
        {{--<small>Version 2.0</small>--}}
    {{--</h1>--}}
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li class="active">Administrar Canchas</li>--}}
    {{--</ol>--}}

{{--@endsection--}}
{{------end css--}}

@section('content')

   @foreach($arrayCanchas as $canchaPadre)

        {{--{{$canchaPadre["padre"]["id"]}}--}}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$canchaPadre["padre"]["nombre"]}} ( Futbol {{$canchaPadre["padre"]["tipo"]}} )</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div id="panel_{{$canchaPadre["padre"]["id"]}}" class="panel panel-{{(strlen ($canchaPadre["padre"]["nombre"])<=3)?"danger":"primary"}}">
                            <div class="panel-heading">
                                Informacion de la Cancha <b>Futbol {{$canchaPadre["padre"]["tipo"]}}</b>
                            </div>

                            <div class="panel-body" data-elemento="{{$canchaPadre["padre"]["id"]}}">

                                <div class="row">

                                <div class="col-sm-3">

                                    <div class="text-right" id="divFotoPerfil" style="margin-bottom: 15px">
                                        <form class="text-center" method="post" enctype="multipart/form-data" id="nuevo">
                                            <div class="kv-avatar contenerdorFoto">
                                                <input name="avatar-1" type="file" class="file-loading avatar" accept='image/*' data-ruta="{{$canchaPadre["padre"]["foto"]}}" data-idcancha="{{$canchaPadre["padre"]["id"]}}">
                                            </div>
                                        </form>
                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none; margin-top: 15px"></div>
                                    </div>
                                </div>

                                <div class="col-sm-8 .col-sm-offset-1">


                                {!!Form::open(['id'=>'formAddInfoCanchas'.$canchaPadre["padre"]["id"],'class'=>'form-horizontal'])!!}
                                <div class="form-group requerido">
                                    {!! Form::label('nombre_'.$canchaPadre["padre"]["id"], 'Nombre Cancha (*)',['class'=>'col-sm-4 control-label']) !!}
                                    <div class="col-sm-8">

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                                            {!!Form::text('nombre_'.$canchaPadre["padre"]["id"],$canchaPadre["padre"]["nombre"],['class'=>'form-control',"name"=>"nombre"])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group requerido">
                                    {!! Form::label('precio_base_'.$canchaPadre["padre"]["id"], 'Precio Base (*)',['class'=>'col-sm-4 control-label']) !!}
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_base_'.$canchaPadre["padre"]["id"],$canchaPadre["padre"]["precio_base"],['class'=>'form-control numeros',"name"=>"precio_base","onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('precio_nocturno', 'Recargo Nocturno',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_nocturno',$canchaPadre["padre"]["precio_nocturno"],['class'=>'form-control numeros',"onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('precio_festivo', 'Recargo Festivos',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_festivo',$canchaPadre["padre"]["precio_festivo"],['class'=>'form-control numeros',"onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group requerido">
                                    {!! Form::label('descripcion_'.$canchaPadre["padre"]["id"], 'Descripción (*)',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" name="descripcion" id="descripcion_{{$canchaPadre["padre"]["id"]}}" placeholder="Breve descripción de la cancha">{{$canchaPadre["padre"]["descripcion"]}}</textarea>

                                    </div>
                                </div>

                                    {!!Form::close()!!}
                                </div>


                            </div>
                            </div>

                            <div id="alert_{{$canchaPadre["padre"]["id"]}}" class="alert">


                            </div>

                            <div class="panel-footer text-right">
                                <a  id="btn_{{$canchaPadre["padre"]["id"]}}" class="btn btn-{{($canchaPadre["padre"]["nombre"]=="")?"danger":"primary"}} guardar"  role="button" data-id="{{$canchaPadre["padre"]["id"]}}">Guardar Informacion Cancha</a>
                            </div>


                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                @foreach($canchaPadre["hijo"] as $canchahijo)

            {{--{{$canchahijo["id"]}}--}}
                    <div class="col-sm-6">

                        <div id="panel_{{$canchahijo["id"]}}" class='panel panel-{{($canchahijo["nombre"]=="")?"danger":"primary"}}'>
                            <div class="panel-heading">
                                Informacion de la Cancha <b>Futbol {{$canchahijo["tipo"]}}</b>
                            </div>
                            {!!Form::open(['id'=>'formAddInfoCanchas'.$canchahijo["id"],'class'=>'form-horizontal'])!!}
                            <div class="panel-body" data-elemento="{{$canchahijo["id"]}}">

                                <div class="row">

                                <div class="col-sm-12">
                                    <div class="col-xs-6 text-right" style="margin-bottom: 15px; margin-right: 25%;margin-left: 25%;">
                                        <form class="text-center" method="post" enctype="multipart/form-data" id="nuevo">
                                            <div class="kv-avatar centrar">
                                                <input name="avatar-1" type="file" class="file-loading avatar" accept='image/*' data-ruta="{{$canchahijo["foto"]}}" data-idcancha="{{$canchahijo["id"]}}">
                                            </div>
                                        </form>
                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none; margin-top: 15px"></div>
                                    </div>
                                </div>



                                    <div class="col-sm-12">



                                <div class="form-group requerido">
                                    {!! Form::label('nombre_'.$canchahijo["id"], 'Nombre Cancha (*)',['class'=>'col-sm-4 control-label nombre']) !!}
                                    <div class="col-sm-8">

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                                            {!!Form::text('nombre_'.$canchahijo["id"],$canchahijo["nombre"],['class'=>'form-control',"name"=>"nombre"])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group requerido">
                                    {!! Form::label('precio_base_'.$canchahijo["id"], 'Precio Base (*)',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_base_'.$canchahijo["id"],$canchahijo["precio_base"],['class'=>'form-control numeros',"name"=>"precio_base" ,"onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('precio_nocturno', 'Recargo Nocturno',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_nocturno',$canchahijo["precio_nocturno"],['class'=>'form-control numeros',"onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('precio_festivo', 'Recargo Festivos',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            {!! Form::text('precio_festivo',$canchahijo["precio_festivo"],['class'=>'form-control numeros',"onkeyup"=>"format(this)" ,"onchange"=>"format(this)"]) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group requerido">
                                    {!! Form::label('descripcion_'.$canchahijo["id"], 'Descripción (*)',['class'=>'col-sm-4 control-label']) !!}

                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="3" name="descripcion" id="descripcion_{{$canchahijo["id"]}}" placeholder="Breve descripción de la cancha">{{$canchahijo["descripcion"]}}</textarea>

                                    </div>
                                </div>
                                </div>
                            </div></div>

                            <div id="alert_{{$canchahijo["id"]}}" class="alert">


                            </div>

                            <div class="panel-footer text-right">
                                <a id="btn_{{$canchahijo["id"]}}" class="btn {{($canchahijo["nombre"]=="")?"btn-danger":"btn-primary"}} guardar"  role="button" data-id="{{$canchahijo["id"]}}">Guardar Informacion Cancha</a>
                            </div>

                            {!!Form::close()!!}
                        </div>
                    </div>

                @endforeach


                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>


    @endforeach


@endsection
{{------end content--}}

@section('js')
    <script src="js/inicio.js"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="plugins/bootstrapFileInput/js/fileinput.min.js"></script>
    <script src="plugins/bootstrapFileInput/js/locales/es.js"></script>
    <script>

        $(function () {

            $(".avatar").each(function (index,elemento) {
                cargarAvatarFileInput(elemento);
            });

            $( ":input" ).click(function () {
//                console.log("dio click");
                $(this).parent().parent().parent().removeClass("has-error");
            });
            $( "textarea" ).click(function () {
//                console.log("dio click");
                $(this).parent().parent().removeClass("has-error");
            });

        });

        function cargarAvatarFileInput(elemento){

            var contenedorFoto = $(elemento).parent();
            //console.log(contenedorFoto);
            var ruta = $(elemento).data("ruta");
            //console.log("el hijo es ");

            //console.log($(contenedorFoto).children("input"));



            $(contenedorFoto).removeClass("centrar");
            $(elemento).fileinput({
                maxFileSize: 2048,
                uploadUrl : 'imagenCancha',
                uploadAsync : false,
                overwriteInitial: true,
                showClose: false,
                showCaption: false,
                dropZoneEnabled: false,
                language: "es",
                showUpload: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'Deshacer cambios',
                previewFileType: 'image',
                allowedFileTypes: ['image'],
                allowedFileExtensions: ['jpg', 'gif', 'png'],
                uploadExtraData : {id:$(elemento).data("idcancha"), sitio:"", actual:ruta},
//                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="images/'+ruta+'" class="img-rounded img-responsive" alt="Imagen de perfil">',
                resizeImage: true,
                //previewSettings:{ image: {width: "200px", height: "160px"}}
            }).on('fileuploaded', function(e, params) {
                $(contenedorFoto).empty();
                $(contenedorFoto).append('<input name="avatar-1" type="file" class="file-loading avatar" accept="image/*" data-ruta="'+params.response.nueva+'" data-idcancha="'+params.response.id+'">');
                ppRoute = params.response.nueva;
                cargarAvatarFileInput($(contenedorFoto).children("input"));
            }).on('change', function(event) {
                $(contenedorFoto).addClass("centrar");
            });
        }



        $(".guardar").on("click",function () {
            //alert("el id es "+$(this).data("id"));

            var formulario = $("#formAddInfoCanchas"+$(this).data("id"));
           //console.log($(formulario).children(".panel-footer").children(".btn"));
            var bandera = true;
            var mensaje ="";
            var panel = $(formulario).children(".panel-body");

            var elemento = $(this).data("id");


            if($("#nombre_"+elemento).val() == null || $("#nombre_"+elemento).val().length < 4 || /^\s+$/.test($("#nombre_"+elemento).val())){
                bandera = false;
                $("#nombre_"+elemento).parent().parent().parent().addClass("has-error");
                if(mensaje=="")
                        mensaje= "Es necesario especificar un Nombre para esta cancha";
            }
            if($("#precio_base_"+elemento).val()==0){
                bandera = false;
                $("#precio_base_"+elemento).parent().parent().parent().addClass("has-error");
                if(mensaje=="")
                    mensaje= "El Precio Base es necesario para el usuario Final";
            }

            var descripcion =$("#descripcion_"+elemento).val();

            if(descripcion.length<10){
                bandera = false;
                $("#descripcion_"+elemento).parent().parent().addClass("has-error");
                if(mensaje=="")
                    mensaje= "Una breve descripcion indicara las ventajas de tu cancha ";
            }

            //console.log($("#descripcion_"+elemento).val());


/*            $(requeridos).each(function (index,elemento) {


            });*/


            var html;
            if(bandera){
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('addInfoCanchas')}}',
                    data:formulario.serialize()+"&id="+$(this).data("id"),
                    success: function(data){
                        if (data["estado"]==true) {

                            //console.log(formulario.parent());
                            $("#panel_"+elemento).removeClass("panel-danger").addClass("panel-primary");
                            $("#btn_"+elemento).removeClass("btn-danger").addClass("btn-primary");

                            $($(panel).children(".requerido")).each(function (index,elemento) {
                                $(elemento).removeClass("has-error");
                            });

                            mensaje="Los Datos de esta cancha se guardaron satisfactoriamente";
                            alerta($("#alert_"+elemento), "check","Perfecto!",mensaje ,"success");
                        }
                        else {
                            mensaje="salio algo mal en el servidor, vuelve a intentarlo más tarde";
                            alerta($("#alert_"+elemento),"ban" ,"Ups!" , mensaje ,"danger");
                        }
                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            }else{
                alerta($("#alert_"+elemento),"ban", "Ups!",mensaje ,"danger");
            }


        });


        function alerta(elemento,icono, titulo, mensaje ,tipo) {
            //console.log(elemento);
            html=  "<div class='alert alert-"+tipo+" alert-dismissible'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
                    "<h4><i class='icon fa fa-"+icono+"'></i> "+titulo+"</h4>"+mensaje+
                    "</div>";
            elemento.empty();
            elemento.append(html);

        }

        function format(input){
            var keynum = window.event ? window.event.keyCode : input.which;


            var menos=(input.value.indexOf("-")==0)?"-":"";
            input.value = input.value.replace("-","");

            if (input.value.length==1){
                if(keynum==109){

                }else{
                    input.value = menos+input.value.replace(/[^\d\.]*/g,"");
                }
            }else{
                var num = input.value.replace(/\./g,"");
                if(!isNaN(num)){
                    num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
                    num = num.split("").reverse().join("").replace(/^[\.]/,"");
                    input.value = menos+num;
                }else{
                    input.value = menos+input.value.replace(/[^\d\.]*/g,"");
                }
            }




        }
    </script>


@endsection
{{------end js--}}
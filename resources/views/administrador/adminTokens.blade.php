@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}

    <style>

        .nuevo{
            background-color: rgba(154, 255, 117, 0.33);
        }

        #historialToken>tbody>tr>td{
            padding: 4px;
            text-align: center;
        }
        #boxHistorialToken{
            border: solid #3c8cbb 1px;
            border-radius: 5px;
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
        {{--<li class="active">Dashboard</li>--}}
    {{--</ol>--}}

{{--@endsection--}}
{{------end css--}}

@section('content')

    <div class="row">
        {!!Form::open(['id'=>'formdisponibilidad','class'=>'form-horizontal','autocomplete'=>'off'])!!}
        <div class="col-md-10 col-md-offset-1 panel panel-primary">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            {!! Form::label('user', 'Usuario',['class'=>'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingresa un nombre de usuario o No. documento" name="user" id="user" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <button id="buscarParaAddToken" type="button" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Usuarios con Token activo</h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Remover</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody" class="poin">

                                    @foreach($tokens as $token)

                                            <tr id="{{$token->id}}" data-id="{{$token->getUsuario->id}}" class="trTokens">
                                                <td>{{$token->getUsuario->getPersona->nombres}}</td>
                                                <td>{{$token->tipo}}</td>
                                                <td>{{$token->fecha}}</td>
                                                <td><button type="button" class="btn btn-danger remover" data-id="{{$token->id}}">Token</button></td>
                                            </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $tokens->render() !!}
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>


            </div>
        </div>
        {!!Form::close()!!}
    </div>

    <div id="modalToken" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Penalización (Retirar Token a Usuario)</h4>
                </div>
                {!!Form::open(['id'=>'formRetirarToken','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-8 col-sm-offset-2 ">
                            <div class="form-group">
                                {!!Form::select('motivos', ['No Asistio al Encuentro' => 'No Asistio al Encuentro',
                                                         'Formo pelea en la cancha' => 'Formo pelea en la cancha',
                                                         'No cumplio con lo acordado'=>'No cumplio con lo acordado',
                                                         '4'=>'Otro Motivo'], null, ['id'=>'motivos','class'=>"form-control",'placeholder' => 'Seleccione un motivo...', 'required'])!!}
                            </div>
                        </div>
                        <div id="otroMotivo" class="col-sm-8 col-sm-offset-2">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Eliminar Token!',['class'=>'btn btn-primary']) !!}
                    {{--<button type="button" class="btn btn-primary">Eliminar Token</button>--}}
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="modalAddToken" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Informacion de Tokens de <b> <spam class="nombreUsuario"></spam></b></h4>
                </div>
                {!!Form::open(['id'=>'formAddToken','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Tokes Perdidos</h3>
                                </div>
                                <!-- /.box-header -->
                                <div id="boxHistorialToken" class="box-body">
                                    <table id="historialToken" class="table cell-border table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Motivo</th>
                                            <th class="text-center">Fecha</th>
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
                    <div class="row">
                        <div class="col-xs-12">
                        <h3 class="box-title">Asignar un Token</h3>
                        <div  class="col-sm-8 col-sm-offset-2 ">
                            <div id="divToken" class="form-group">
                                {!!Form::select('tipo', ['normal' => 'Normal',
                                                         'VIP' => 'VIP'], null, ['id'=>'motivos','class'=>"form-control",'placeholder' => 'Seleccione el tipo de Token', 'required'])!!}
                            </div>
                            <div id="yaToken">
                                <div class="alert alert-success">
                                    <strong class="nombreUsuario" ></strong> Ya cuanta con un TOKEN activo.
                                </div>
                                {{--<h4> <b> <spam class="nombreUsuario"></spam></b> Ya cuanta con un TOKEN activo</h4>--}}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Agregar Token',['id'=>'btnAddToken','class'=>'btn btn-primary']) !!}
                    {{--<button type="button" class="btn btn-primary">Eliminar Token</button>--}}
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
{{------end content--}}

@section('js')
    {!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
    <!-- DataTables -->
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}

    <script>

        var table;
        var bandera=0;
        var id_res;
        var id_user;

        $(function () {

            var tokens ='{{$tokens}}';
            //console.log(tokens);

            llenarGrid(0);
/*            $("#example2").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "pageLength": 3,
                "autoWidth": false
            });*/
            $("#user").keyup(function() {
                var cantidad = $("#user").val().length;

                if(cantidad==0){
                    bandera=0;
                }

                if(cantidad==1&&bandera==0){
                    bandera++;
                    //console.log("mandamos a buscar");
                    $.ajax({
                        type:"POST",
                        context: document.body,
                        url: '{{route('autoCompleUsuarios')}}',
                        data:{"nombre":$( "#user" ).val()},
                        success: function(data){
                           // console.log(data);
                            $( "#user" ).autocomplete({
                                source: data,
                                select: function( event, ui ) {
                                    buscarAddTokenAjax(ui.item.value);
                                }
                            });
                        },
                        error: function(){
                            console.log('ok');
                        }
                    });
                }


            });


            $("#motivos").change(function () {
                //alert("cambio "+$("#motivos").val());
                if($("#motivos").val()=="4"){
                    $("#otroMotivo").html("<div class='form-group'>"+
                            "<input type='text' class='form-control' id='motivo' name='motivos' placeholder='Motivo...'>"+
                            "</div>");
                }else{
                    $("#otroMotivo").html("");
                }
            });//fin evento CHANGE #motivos

            var formRetirarToken= $("#formRetirarToken");
            formRetirarToken.submit(function(e){
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('retirarToken')}}',
                    data:formRetirarToken.serialize()+"&id_token="+id_res,
                    success: function(data){

                        if(data=="eliminado"){
                            $('#modalToken').modal('hide');
                            $("#"+id_res).remove();
                        }

                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });

            $("#buscarParaAddToken").click(function () {
                buscarAddTokenAjax($("#user").val());
            });

            var formAddToken= $("#formAddToken");
            formAddToken.submit(function(e){
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('addToken')}}',
                    data:formAddToken.serialize()+"&id_usuario="+id_user,
                    success: function(data){

                        console.log(data);
                        $('#modalAddToken').modal('hide');
                        var html ="<tr id='"+data.id+"' data-id='"+data.id_user+"' class='nuevo trTokens'>"+
                                "<td>"+data.nombre+"</td>"+
                                "<td>"+data.tipo+"</td>"+
                                "<td>"+data.fecha+"</td>"+
                                "<td><button type='button' class='btn btn-danger remover' data-id='"+data.id+"'>Token</button></td>"+
                                "</tr>";
                        $("#tbody").prepend(html);
                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });

        }); //Fin $();


        $("#tbody").on("click", ".remover", function () {
            id_res= $(this).data("id");
            $('#modalToken').modal('show');

            //alert("el valor de id es : "+id_res);
        });


        function buscarAddTokenAjax(user) {
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('buscarAddToken')}}',
                data:{'user':user},
                success: function(data){

                    console.log(data);

                    if(data.bandera){
                        $(".nombreUsuario").text(data.nombre);

                        if(buscarIdToken(data.id)){
                            $("#yaToken").addClass("show").removeClass("hidden");
                            $("#divToken").addClass("hidden");
                            $("#btnAddToken").addClass("hidden");
                        }else{
                            $("#yaToken").addClass("hidden").removeClass("show");
                            $("#divToken").removeClass("hidden");
                            $("#btnAddToken").removeClass("hidden");
                        }

                        table.destroy();
                        llenarGrid(data.id);
                        $('#modalAddToken').modal('show');
                        id_user=data.id;


                    }else{

                        alert("pailas usuario no existe");
                    }

                },
                error: function(){
                    console.log('ok');
                }
            });
        }

        //buscar el id del token dentro de la tabla de tokes activos para el sitio
        function buscarIdToken(id) {

            var bandera = false;

            $(".trTokens").each(function () {
                console.log($(this).data("id"));
                if(id==$(this).data("id")){
                    bandera= true;
                }
            });
            return bandera;

        }



        function llenarGrid(id){
            table = $('#historialToken').DataTable( {
                ajax: {
                    url: 'infoToken/'+id,
                    dataSrc: ''
                },
                columns: [
                    { data: 'motivo' },
                    { data: 'fecha' }
                ],
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

    </script>
    

@endsection
{{------end js--}}
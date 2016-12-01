@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <style>
        input[type="date"]{
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
        }

        .borderCanchas{
            padding-top: 5px;
            border:solid 1px #2b82ff;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .ico-cerrar{
           cursor: pointer;
            color: #680000;
        }

    </style>
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQfuApkISN-47bhyMFSQkk4mxBq5z83oY"
            type="text/javascript"></script>
    <script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}--}}
@endsection
{{------end css--}}

@section('Pageheader')

    <h1>
        Registrar
        <small>un sitio</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Registro</li>
    </ol>

@endsection
{{------end css--}}


@section('content')
    {!!Form::open(['id'=>'formRegistrarSitio','class'=>'form-horizontal','autocomplete'=>'off'])!!}
    <div class="panel panel-primary">
        <div class="panel-heading">
            Información del Usuario Administrador
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('identificacion', 'No. Identificación (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::text('identificacion',null,['class'=>'form-control','placeholder'=>"Número de Identificación...", 'required', 'onkeypress' => 'return justNumbers(event)', 'maxlength'=>'15', 'minlength'=>'7'])!!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('nombres', 'Nombre (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::text('nombres',null,['class'=>'form-control','placeholder'=>"Nombres y Apellidos...", 'required', 'onkeypress' => 'return justletters(event)', 'maxlength="35"'])!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('telefono', 'No. Movil (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input type="text" name="telefono" id="telefono" class="form-control" required minlength="10" maxlength="10" onkeypress="return justNumbers(event)" placeholder="Número celular...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('correo', 'E-Mail (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="ejemplo@miscanchas.com" name="email" id="correo" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Información del Sitio
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre Del Sitio (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                {!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>"Nombre Campleto de Sitio..."])!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('departamento', 'Departamento (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::select('departamento', $arrayDepartamento, null, ['class'=>"form-control",'placeholder' => 'Seleccione un Departamento'])!!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 hidden" id="divMunicipio">
                    <div class="form-group">
                        {!! Form::label('id_municipio', 'Municipio (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::select('id_municipio', ['L' => 'Large', 'S' => 'Small'], null, ['class'=>"form-control",'placeholder' => 'Pick a size...'])!!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('user', 'Usuario (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Ingresa un nombre de usuario..." name="user" id="user" required>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('contrasena', 'Contraseña (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::text('contrasena',null,['class'=>'form-control','placeholder'=>"deberia ser automatica"])!!}
                        </div>
                    </div>
                </div>--}}
            </div>

            <div class="col-sm-12">
                <h3>Meses a Pagar</h3>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('fecha_inicio', 'Fecha Inicio (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                {!!Form::text('fecha_inicio',null,['class'=>'form-control pull-right','placeholder'=>'Selecciona una fecha','onkeypress'=>'return false;'])!!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('fecha_fin', 'Fecha Fin (*)',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                {!!Form::text('fecha_fin',null,['class'=>'form-control pull-right','placeholder'=>'Selecciona una fecha', 'disabled'=>'disabled'])!!}
                            </div>

                        </div>
                    </div>
                </div>

{{--                <div class="col-sm-9">
                    {!!$map['html']!!}
                </div>--}}

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Canchas del Sitio  <a id="btnaddCancha" class="btn btn-info" role="button"> <i class="fa fa-plus" aria-hidden="true"></i> Nueva Cancha</a></h3>
                </div>
            </div>

            <div id="canchas" class="row">


                <div id="divCancha1" class="col-xs-12 ">
                    <div class="container-fluid borderCanchas">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('cancha1', 'Tipo de cancha (*)',['class'=>'col-sm-5 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!!Form::select('cancha1', ["11"=>"Futbol 11","10"=>"Futbol 10","9"=>"Futbol 9","8"=>"Futbol 8","7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], null, ['class'=>"form-control selectCanchas",'data-id'=>"1"])!!}
                                        </div>
                                        <div class="col-sm-7 col-md-3">
                                            <label id="labelCheck1" class="checkbox-inline hidden">
                                                <input type="checkbox" name="Check1" id="Check1" class="checkCanchas" value="option1" data-id="1"> Convertible
                                            </label>
                                        </div>

                                    </div>

                                </div>
                                <div id="minicanchas1" class="col-sm-6 hidden">
                                    <div class="form-group">
                                        {!! Form::label('cancha11', 'Tipo de cancha (*)',['class'=>'col-sm-5 control-label']) !!}
                                        <div class="col-sm-7">
                                            {!!Form::select('cancha11', ["7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], null, ['class'=>"form-control"])!!}
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('cancha12', 'Tipo de cancha (*)',['class'=>'col-sm-5 control-label']) !!}
                                        <div class="col-sm-7">
                                            {!!Form::select('cancha12', ["7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], null, ['class'=>"form-control"])!!}
                                        </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1" id="error"></div>
            </div>

        </div>

        <div class="panel-footer text-right">

            {!! Form::submit('Registrar Sitio',['class'=>'btn btn-primary center-block']) !!}

        </div>

    </div>
    {!!Form::close()!!}
@endsection
{{------end content--}}

@section('js')
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.date.extensions.js')!!}
    {!!Html::script('plugins/input-mask/jquery.inputmask.extensions.js')!!}
    <script>
        var totalcanchas=1;
        $(function () {
            $(document).on("cut copy paste","#fecha_inicio",function(e) {
                e.preventDefault();
            });
            $("#correo").blur(function(){
                expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if ($(this).val() != ""){
                    if (!expr.test($(this).val())) {
                        $(this).parent().addClass("has-error");
                        $(this).focus();
                    }
                    else{
                        $(this).parent().removeClass("has-error");
                        $(this).parent().addClass("has-success");
                    }
                }
                else {
                    $(this).parent().removeClass("has-error");
                    $(this).parent().removeClass("has-success");
                }
            });
            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Clear",
                format: "yyyy/mm/dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $('#fecha_inicio').datepicker({
                autoclose: true,
                language: 'es'
            });
            $('#fecha_fin').datepicker({
                autoclose: true,
                language: 'es'
            });

            $("[data-mask]").inputmask();
            
            var formulario = $("#formRegistrarSitio");
            formulario.submit(function(e){
                e.preventDefault();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('addSitio')}}',
                    data:formulario.serialize()+"&totalcanchas="+totalcanchas,
                    success: function(data){
                        if (data=="exito") {
                            formulario.reset();
                            window.location= "{{route("registrarSitio")}}";
                        }
                        else {
                            //alert("Se genero un error Interno");
                        }
                    },
                    error: function(data){
                        var respuesta =JSON.parse(data.responseText);
                        var arr = Object.keys(respuesta).map(function(k) { return respuesta[k] });
                        var error='<ul>';
                        for (var i=0; i<arr.length; i++)
                            error += "<li>"+arr[i][0]+"</li>";
                        error += "</ul>";
                        $("#error").html('<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> Corrige los siguientes errores para continuar el registro:' +
                                '<p>'+error+'</p>' +
                                '</div>');
                    }
                });
            });
        });

        $("#fecha_inicio").change(function () {
            var fecha=$(this).val();
            $('#fecha_fin').datepicker('setStartDate', fecha);
            $("#fecha_fin").removeAttr("disabled");
        });

        $("#departamento").change(function () {

            if($("#departamento").val()==""){
                //alert("el id es nulo");
                $("#divMunicipio").addClass("hidden").removeClass("show");
            }else{
                $("#divMunicipio").addClass("show").removeClass("hidden");
                //alert("el id es "+$("#departamento").val());
                $.ajax({
                    type: "POST",
                    context: document.body,
                    url: '{{route('municipios')}}',
                    data: { 'id' : $("#departamento").val()},
                    success: function (data) {

                        $("#id_municipio").empty();

                        $.each(data,function (index,valor) {
                            $("#id_municipio").append('<option value='+index+'>'+valor+'</option>')

                            console.log("la key es "+index+" y el valor es "+valor);
                        });

                    },
                    error: function (data) {
                    }
                });
            }

        });

        $("#btnaddCancha").click(function () {
            totalcanchas++;

            $("#cerrar"+(totalcanchas-1)).addClass("hidden");

            $("#canchas").prepend("<div id='divCancha"+totalcanchas+"' class='col-xs-12 '>"+
                    "<div class='col-xs-12 text-right'>"+
                    "<i id='cerrar"+totalcanchas+"' class='fa fa-times ico-cerrar' aria-hidden='true'  data-id='"+totalcanchas+"'></i>"+
                    "</div>"+
                    "<div class='container-fluid borderCanchas'>"+
                    "<div class='col-sm-6'>"+
                    "<div class='form-group'>"+
                    "<label for='cancha"+totalcanchas+"' class='col-sm-5 control-label'>Tipo de cancha (*)</label>"+
                    "<div class='col-sm-7'>"+
                    "<select id='cancha"+totalcanchas+"' name='cancha"+totalcanchas+"' class='form-control selectCanchas' data-id='"+totalcanchas+"'>"+
                    "<option value='11'>Futbol 11</option>"+
                    "<option value='10'>Futbol 10</option>"+
                    "<option value='9'>Futbol 9</option>"+
                    "<option value='8'>Futbol 8</option>"+
                    "<option value='7'>Futbol 7</option>"+
                    "<option value='6'>Futbol 6</option>"+
                    "<option value='5'>Futbol 5</option>"+
                    "</select>"+
                    "</div>"+
                    "<div class='col-sm-6 col-md-3'>"+
                    "<label id='labelCheck"+totalcanchas+"' class='checkbox-inline hidden'>"+
                    "<input type='checkbox' name='Check"+totalcanchas+"' id='Check"+totalcanchas+"' class='checkCanchas' value='option1' data-id='"+totalcanchas+"'> Convertible"+
                    "</label>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "<div id='minicanchas"+totalcanchas+"' class='col-sm-6 hidden'>"+
                    "<div class='form-group'>"+
                    "<label for='cancha"+totalcanchas+"1' class='col-sm-5 control-label'>Tipo de cancha (*)</label>"+
                    "<div class='col-sm-7'>"+
                    "<select id='cancha"+totalcanchas+"1' name='cancha"+totalcanchas+"1' class='form-control' disabled>"+
                    "<option value='7'>Futbol 7</option>"+
                    "<option value='6'>Futbol 6</option>"+
                    "<option value='5'>Futbol 5</option>"+
                    "</select>"+
                    "</div>"+
                    "</div>"+
                    "<div class='form-group'>"+
                    "<label for='cancha"+totalcanchas+"2' class='col-sm-5 control-label'>Tipo de cancha (*)</label>"+
                    "<div class='col-sm-7'>"+
                    "<select id='cancha"+totalcanchas+"2' name='cancha"+totalcanchas+"2' class='form-control' disabled>"+
                    "<option value='7'>Futbol 7</option>"+
                    "<option value='6'>Futbol 6</option>"+
                    "<option value='5'>Futbol 5</option>"+
                    "</select>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "</div>");
        });


       $("#canchas").on("change", ".selectCanchas",function () {

           var actual= $( this ).data( "id" );

            //alert($( this ).data( "id" ));
            //var padre =$(this).parent();
            //var hermano = $(padre).siblings();
            $("#Check"+actual).prop('checked', false);
            $("#minicanchas"+actual).removeClass("show").addClass("hidden");
            $("#cancha"+actual+"1").prop('disabled', 'disabled');
            $("#cancha"+actual+"2").prop('disabled', 'disabled');


            if($(this).val()=='8'||$(this).val()=='9'||$(this).val()=='10'){
                $("#labelCheck"+actual).removeClass("hidden").addClass("show");
            }else {
                $("#labelCheck"+actual).removeClass("show").addClass("hidden");
            }
            //console.log(hermano);
        });

        $("#canchas").on("change",".checkCanchas",function () {

            var actual= $( this ).data( "id" );

            if( $(this).prop('checked') ) {
               //alert("cancha"+actual+"1");
                $("#minicanchas"+actual).removeClass("hidden").addClass("show");
                $("#cancha"+actual+"1").prop('disabled', false);
                $("#cancha"+actual+"2").prop('disabled', false);
            }else{
                $("#minicanchas"+actual).removeClass("show").addClass("hidden");
                $("#cancha"+actual+"1").prop('disabled', 'disabled');
                $("#cancha"+actual+"2").prop('disabled', 'disabled');
            }
        });

        $("#canchas").on("click", ".ico-cerrar", function () {
            //alert($( this ).data( "id" ));
            $("#cerrar"+(totalcanchas-1)).removeClass("hidden").addClass("show");
            $("#divCancha"+totalcanchas).remove();
            totalcanchas--;

        } );

    </script>

@endsection
{{------end js--}}
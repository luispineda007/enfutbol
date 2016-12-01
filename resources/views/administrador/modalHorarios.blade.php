{{--<link rel="stylesheet" href="plugins/iCheck/all.css">
<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">--}}
{{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">--}}
{!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}
{!!Html::style('plugins/iCheck/all.css')!!}
{!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}

<style>
    .rangos{
        padding-left: 25px;
        padding-right: 25px;
    }
    .form-group{
        margin-bottom: 0px;
    }
    .panel-body, .panel-heading{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .hora{
        padding-left: 10px;
        padding-right: 10px;
    }
    .contenido{
        display: none;
    }
    .desplegado{
        display: block;
    }
    .alert{
        margin-bottom: 0px;
    }
    .lista:hover{
        cursor: pointer;
    }
    .convencion{
        height: 20px;
        padding-left: 10px;
        padding-right: 0px;
    }
    button.close {

    }
</style>

<div id="NombreDelModal">
    {!!Form::open(['id'=>'formHorario'])!!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <button type="button" class="close" onclick="mostrarAyuda()" style="padding:1px 6px; color: #001cbf;">?</button>
        <h4>Configurar horarios de atención</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading lista alert lleno" id="1">
                        <div class="row text-center">
                            <div class="col-xs-6">
                                <b>Lunes a Viernes</b>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" id="c1" name="c1">
                                        Cerrado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body contenido" id="horaSemana">
                        <div class="row">
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Desde:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="11" name="11">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hasta:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="12" name="12">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div id = "panel2" class="panel panel-default">
                    <div class="panel-heading lista alert lleno" id="2">
                        <div class="row text-center">
                            <div class="col-xs-6">
                                <b>Sabados</b>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" id="c2" name="c2">
                                        Cerrado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body contenido" id="horaSabado">
                        <div class="row">
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Desde:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="21" name="21">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hasta:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="22" name="22">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading lista alert lleno" id="3">
                        <div class="row text-center">
                            <div class="col-xs-6">
                                <b>Domingos y Festivos</b>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" id="c3" name="c3">
                                        Cerrado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body contenido" id="horaFestivo">
                        <div class="row">
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Desde:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="31" name="31">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 text-center hora">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hasta:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" readonly id="32" name="32">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" id="divAyuda"></div>

            <div class="col-xs-10 col-xs-offset-1" id="alertar"> </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <input type="submit" class="btn btn-primary" value="Guardar" id="guardadr">
    </div>
    {!!Form::close()!!}
</div>
{!!Html::script('plugins/jQueryUI/jquery-ui.min.js')!!}
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>
    var input11 = $("#11");
    var input12 = $("#12");
    var input21 = $("#21");
    var input22 = $("#22");
    var input31 = $("#31");
    var input32 = $("#32");
    var divSemana = $("#horaSemana");
    var divSabado = $("#horaSabado");
    var divFestivo = $("#horaFestivo");
    var lista1 = $("#1");
    var lista2 = $("#2");
    var lista3 = $("#3");
    var valorCambiado = "";


    $(function () {
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        $(".timepicker").timepicker({
            showInputs: false,
            showSeconds: false,
            showMeridian: false,
            minuteStep: 60,
            defaultTime: false
        }).on('show.timepicker', function(e) {
            valorCambiado = "";
            $("#alertar").empty();
            if ($(this).val() == "")
                $(this).timepicker('setTime', '12:00');
            else
                valorCambiado = $(this).val();
        });

        if ("{{$horario->semana}}" != ""){
            lista1.addClass('alert-success');
            var semana="{{$horario->semana}}";
            semana = semana.split('-');
            input11.val(semana[0]+":00");
            input12.val(semana[1]+":00");
        }
        else{
            lista1.addClass('alert-warning bloquear');
            input11.attr('disabled', 'disabled');
            input12.attr('disabled', 'disabled');
            $('#c1').iCheck('check');
        }



        if ("{{$horario->sabado}}" != ""){
            lista2.addClass('alert-success');
            var sabado="{{$horario->sabado}}";
            sabado = sabado.split('-');
            input21.val(sabado[0]+":00");
            input22.val(sabado[1]+":00");
        }
        else{
            lista2.addClass('alert-warning bloquear');
            input21.attr('disabled', 'disabled');
            input22.attr('disabled', 'disabled');
            $('#c2').iCheck('check');
        }


        if ("{{$horario->festivo}}" != ""){
            lista3.addClass('alert-success');
            var festivo="{{$horario->festivo}}";
            festivo = festivo.split('-');
            input31.val(festivo[0]+":00");
            input32.val(festivo[1]+":00");
        }
        else{
            lista3.addClass('alert-warning bloquear');
            input31.attr('disabled', 'disabled');
            input32.attr('disabled', 'disabled');
            $('#c3').iCheck('check');
        }




        var formulario = $("#formHorario");
        formulario.submit(function(e){
            e.preventDefault();
            if (lista1.hasClass('lleno') && lista2.hasClass('lleno') && lista3.hasClass('lleno')) {
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('updateHorario')}}',
                    data: formulario.serialize(),
                    success: function(data){
                        if (data.semana != "")
                            $("#semana").html(data.semana);
                        else
                            $("#semana").html("Cerrado");

                        if (data.sabado != "")
                            $("#sabado").html(data.sabado);
                        else
                            $("#sabado").html("Cerrado");

                        if (data.festivo != "")
                            $("#festivo").html(data.festivo);
                        else
                            $("#festivo").html("Cerrado");

                        modalBs.modal('hide');


                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            else {
                $("#alertar").html("<div class='alert alert-danger alert-dismissible' style='margin-bottom:15px;'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
                        "<h4><i class='icon fa fa-ban'></i> Cambios no almacenados</h4> Debe completar TODOS los campos para poder actualizar el horario de atencion de su sitio."+
                        "</div>");
            }
        });

    });

    function mostrarAyuda(){
        html =  "<div class='row'>" +
                    "<div class='col-xs-4'>" +
                        "<div class='col-xs-2 convencion'>" +
                            "<div class='alert-success' style='height: 100%'></div>" +
                        "</div>" +
                        "<div class='col-xs-10' style='padding-left: 10px;'>Configurado</div>" +
                    "</div>" +

                    "<div class='col-xs-4'>" +
                        "<div class='col-xs-2 convencion'>" +
                            "<div class='alert-warning' style='height: 100%'></div>" +
                        "</div>" +
                        "<div class='col-xs-10' style='padding-left: 10px;'>Cerrado</div>" +
                    "</div>" +

                    "<div class='col-xs-4'>" +
                        "<div class='col-xs-2 convencion'>" +
                            "<div class='alert-danger' style='height: 100%'></div>" +
                        "</div>" +
                        "<div class='col-xs-9' style='padding-left: 10px;'>NO Configurado</div>" +
                    "</div>" +
                "</div>";
        $("#alertar").html("");
        $("#divAyuda").html(html);
        setTimeout(function(){$("#divAyuda").html("");} , 5000);


    }

    input11.timepicker().on('hide.timepicker', function(e) {
        seleccionar(1,1);
        if (input11.val() != "")
            input12.removeAttr('disabled');
    });

    input12.timepicker().on('hide.timepicker', function(e) {
        seleccionar(1,2);
        if ($(this).val() != "" && input11.val() != "") {
            lista1.removeClass('alert-danger').addClass('alert-success lleno');
            if (lista2.hasClass('lleno') && lista3.hasClass('lleno'))
                $("#guardadr").removeAttr('disabled');
        }
    });

    input21.timepicker().on('hide.timepicker', function(e) {
        seleccionar(2,1);
        if (input21.val() != "")
            input22.removeAttr('disabled');
    });

    input22.timepicker().on('hide.timepicker', function(e) {
        seleccionar(2,2);
        if ($(this).val() != "" && input21.val() != "") {
            lista2.removeClass('alert-danger').addClass('alert-success lleno');
            if (lista1.hasClass('lleno') && lista3.hasClass('lleno'))
                $("#guardadr").removeAttr('disabled');
        }
    });

    input31.timepicker().on('hide.timepicker', function(e) {
        seleccionar(3,1);
        if (input31.val() != "")
            input32.removeAttr('disabled');
    });

    input32.timepicker().on('hide.timepicker', function(e) {
        seleccionar(3,2);
        if ($(this).val() != "" && input31.val() != "") {
            lista3.removeClass('alert-danger').addClass('alert-success lleno');
            if (lista1.hasClass('lleno') && lista2.hasClass('lleno'))
                $("#guardadr").removeAttr('disabled');
        }
    });


    function seleccionar(i, j) {
        var bandera = false;
        var act, centro, final;
        if (j==2){
            --j;
            bandera =true;
        }
        else {
            var auxI = i;
            var auxJ = j;
            final= auxI+""+auxJ;
            auxJ=2;
            --auxI;
            if (auxI == 0){
                auxI = 3;
            }
            centro = auxI+""+auxJ;
            --auxJ;
            act = auxI+""+auxJ;
//            console.log("validar("+act+", "+centro+", "+final+", "+bandera+", atras);");
            validar(act, centro, final, bandera, "atras");
        }
        act=i+""+j;
        ++j;
        centro = i+""+j;
        ++j;
        if(j == 3){
            j=1;
            ++i;
        }
        if(i == 4)
            i=1;
        final = i+""+j;
//        console.log("validar("+act+", "+centro+", "+final+", "+bandera+", adelante);");
        validar(act, centro, final, bandera, "adelante");
    }

    function validar(primero, segundo, tercero, bandera, estado) {
        var act = $("#"+primero).val();
        if (act != "")
            act = parseInt(act.split(':')[0]);

        var centro = $("#"+segundo).val();
        if (centro != "")
            centro = parseInt(centro.split(':')[0]);

        var final = $("#"+tercero).val();
        if (final != "")
            final = parseInt(final.split(':')[0]);

//        console.log("actual= "+act);
//        console.log("centro= "+centro);
//        console.log("final= "+final);
//        console.log("");

        if(centro != ""){
            if(centro<= act){
                if (final != ""){
                    if(centro>final){
//                        console.log("cambio no valido");
                        if (estado == "adelante"){
                            if (bandera) {
                                $("#" + segundo).val(valorCambiado);
                                segundo = segundo.charAt(0);
                                notificar(++segundo);
                            }
                            else {
                                $("#" + primero).val(valorCambiado);
                                primero=primero.charAt(0);
                                notificar(++primero);
                            }
                        }
                        else {
                            $("#"+tercero).val(valorCambiado);
                            tercero = tercero.charAt(0);
                            notificar(--tercero);
                        }

                    }
//                    $("#"+tercero).val(centro+":00");
                }
//                $("#"+tercero).val(centro+":00");
            }
        }
    }

    function notificar(selector) {
        if (selector == 4)
            selector = 1;
        if (selector == 0)
            selector = 3;

        var mensaje = "";
        if  (selector == 1)
            mensaje = "Lunes a Viernes";
        else if(selector == 2)
            mensaje = "Sabados";
        else
            mensaje = "Domingos y Festivos";
            $("#alertar").html("<div class='alert alert-danger alert-dismissible'>"+
                                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
                                    "<h4><i class='icon fa fa-ban'></i> Cambio no permitido</h4> La modificacion ingresada, interfiere con el horario ingresado para  <b>"+mensaje+"</b>"+". Corrijala por un horario que no genere cruces."+
                    "</div>");

    }



    $("#c1").on('ifClicked', function (e) {
        if (!e.currentTarget['checked']) {
            input11.val("").attr('disabled', 'disabled');
            input12.val("").attr('disabled', 'disabled');
            lista1.addClass('alert-warning bloquear lleno').removeClass('alert-danger alert-success');
            divSemana.removeClass('desplegado');
            if (lista2.hasClass('lleno') && lista3.hasClass('lleno'))
                $("#guardadr").removeAttr('disabled');
        }
        else{
            lista1.addClass('alert-danger').removeClass('alert-success alert-warning bloquear lleno');
            input11.removeAttr('disabled');
            $(".contenido").removeClass('desplegado');
            divSemana.addClass('desplegado');
            $("#guardadr").attr('disabled', 'disabled');
        }
    });

    $("#c2").on('ifClicked', function (e) {
        if (!e.currentTarget['checked']) {
            input21.val("").attr('disabled', 'disabled');
            input22.val("").attr('disabled', 'disabled');
            lista2.addClass('alert-warning bloquear lleno').removeClass('alert-danger alert-success');
            divSabado.removeClass('desplegado');
            if (lista1.hasClass('lleno') && lista3.hasClass('lleno'))
                $("#guardadr").removeAttr('disabled');
        }
        else{
            lista2.addClass('alert-danger').removeClass('alert-success alert-warning bloquear lleno');
            input21.removeAttr('disabled');
            $(".contenido").removeClass('desplegado');
            divSabado.addClass('desplegado');
            $("#guardadr").attr('disabled', 'disabled');
        }
    });

    $("#c3").on('ifClicked', function (e) {
        if (!e.currentTarget['checked']) {
            input31.val("").attr('disabled', 'disabled');
            input32.val("").attr('disabled', 'disabled');
            lista3.addClass('alert-warning bloquear lleno').removeClass('alert-danger alert-success');
            divFestivo.removeClass('desplegado');
            if (lista1.hasClass('alert-success') && lista2.hasClass('alert-success'))
                $("#guardadr").removeAttr('disabled');
        }
        else{
            lista3.addClass('alert-danger').removeClass('alert-success alert-warning bloquear lleno');
            input31.removeAttr('disabled');
            $(".contenido").removeClass('desplegado');
            divFestivo.addClass('desplegado');
            $("#guardadr").attr('disabled', 'disabled');
        }
    });



    $(".modal-body").on('click', '.lista', function () {
        var actual = $(this);
        if (!actual.hasClass('bloquear')){
            if(actual.next().hasClass('desplegado'))
                    actual.next().removeClass('desplegado');
                else{
                    $(".contenido").removeClass('desplegado');
                    actual.next().addClass('desplegado');
                }
        }
        else{
            var anterior = actual.parent().parent().prev();
            var listaAnterior = anterior.children().children();
            if (listaAnterior[0] != null) {
                if ($(listaAnterior[0]).hasClass('alert-danger')) {
                    $(anterior[0]).effect("bounce", "fast");
                }
            }
        }
    });


</script>
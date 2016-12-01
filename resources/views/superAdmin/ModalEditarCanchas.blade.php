<div id="NombreDelModal">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> Editar las cnahcas de <b>{{$sitio->nombre}}</b></h4>
    </div>
    <div class="modal-body">
        <div id="canchas" class="row">

            @foreach($arrayCanchas as $cancha)

                <div class="col-xs-12 ">
                    <div id="divCancha{{$cancha["id"]}}" class="borderCanchas container-fluid text-right">
                        <i class='fa fa-times ico-cerrar' aria-hidden='true' data-id='{{$cancha["id"]}}'></i>
                        <div class="col-sm-12" style="margin-bottom: 10px;">
                            <div class="form-group">
                                {!! Form::label('cancha'.$cancha["id"], 'Tipo de cancha (*)',['class'=>'col-sm-5 control-label']) !!}
                                <div class="col-sm-6">
                                    <div class="input-group">
                              <span class="input-group-addon">
                                <input id="check{{$cancha["id"]}}" type="checkbox" aria-label="..."
                                       class="check {{(in_array($cancha["tipo"],["10","9","8"]))?"":"hidden"}}"
                                       {{(!empty($cancha["hijas"]))?"checked":""}} data-id='{{$cancha["id"]}}'>
                              </span>
                                        {!!Form::select('cancha'.$cancha["id"], ["11"=>"Futbol 11","10"=>"Futbol 10","9"=>"Futbol 9","8"=>"Futbol 8","7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], $cancha["tipo"], ['class'=>"form-control selectCanchas",'data-id'=>$cancha["id"],'data-padre'=>"0"])!!}
                                    </div><!-- /input-group -->

                                </div>
                            </div>

                        </div>

                        @if(!empty($cancha["hijas"]))
                            <div id="mini{{$cancha["id"]}}" class="col-sm-12" style="margin-bottom: 10px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('cancha'.$cancha["hijas"][0]["id"], 'Tipo',['class'=>'col-sm-5 control-label']) !!}
                                        <div class="col-sm-7">
                                            {!!Form::select('cancha'.$cancha["hijas"][0]["id"], ["7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], $cancha["hijas"][0]["tipo"], ['class'=>"form-control selectCanchas", 'data-id'=>$cancha["hijas"][0]["id"],'data-padre'=>$cancha["id"]])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('cancha'.$cancha["hijas"][1]["id"], 'Tipo',['class'=>'col-sm-5 control-label']) !!}
                                        <div class="col-sm-7">
                                            {!!Form::select('cancha'.$cancha["hijas"][1]["id"], ["7"=>"Futbol 7","6"=>"Futbol 6","5"=>"Futbol 5"], $cancha["hijas"][1]["tipo"], ['class'=>"form-control selectCanchas", 'data-id'=>$cancha["hijas"][1]["id"],'data-padre'=>$cancha["id"]])!!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>


        <div class="row text-center" style="margin-top: 20px;">
            <a id="nueva" class="btn btn-default" href="#" role="button">Agregar una Cancha</a>
        </div>

    </div>

</div>


<script type="text/javascript">

    var id_sitio;
    $(function () {

        id_sitio = "{{$sitio->id}}";
        $("#nueva").click(function (e) {
            e.preventDefault();
            console.log("nuevacancha");
            $.ajax({
                type: "POST",
                context: document.body,
                url: '{{route('addCancha')}}',
                data: {'id_sitio': id_sitio, "id_padre": 0,'tipo':11},
                success: function (data) {
                    crearPadre(data.id);
                },
                error: function (data) {
                }
            });

        });

    });

    $("#canchas").on("change", ".selectCanchas", function () {
        var ele = $(this);
        var id = ele.data("id");
        console.log("actualizar la cancha " + ele.data("id") + " -> tipo: " + ele.val());
        $.ajax({
            type: "POST",
            context: document.body,
            url: '{{route('cambiarTipoCancha')}}',
            data: {'id': id, 'tipo':ele.val()},
            success: function (data) {
                console.log(data);

            },
            error: function (data) {
            }
        });
        if (ele.data("padre") == 0) {
            if (ele.val() == '8' || ele.val() == '9' || ele.val() == '10') {
                $("#check" + id).removeClass("hidden");
            } else {
                $("#check" + id).addClass("hidden");
            }
        }

    });
    $("#canchas").on("change", ".check", function () {
        var id_padre = $(this).data("id");
        if ($(this).is(":checked")) {
           // console.log("crear hijas a" + $(this).data("id"));
            $.ajax({
                type: "POST",
                context: document.body,
                url: '{{route('addCancha')}}',
                data: {'id_sitio': id_sitio, "id_padre": id_padre,'tipo':7},
                success: function (data) {
                    console.log(data.hijas);
                    crearHijas(id_padre,data.hijas);
                },
                error: function (data) {
                }
            });

        } else {
            console.log("eliminar hijas de " + $(this).data("id"));
            $.ajax({
                type: "POST",
                context: document.body,
                url: '{{route('removeCancha')}}',
                data: {"id_padre": id_padre},
                success: function (data) {
                    eliminarhijas(id_padre);
                },
                error: function (data) {
                }
            });

        }

    });

    $("#canchas").on("click", ".ico-cerrar", function () {
        var id = $(this).data("id");
        console.log("eliminar padre e hijos " + $(this).data("id"));
        $.ajax({
            type: "POST",
            context: document.body,
            url: '{{route('removeCancha')}}',
            data: {'id': id, "id_padre": 0},
            success: function (data) {
                eliminarPadre(id);
            },
            error: function (data) {
            }
        });
    });


    function crearHijas(id_padre,hijas) {

        html = "<div id='mini" + id_padre + "' class='col-sm-12' style='margin-bottom: 10px;'>" +
                "<div class='col-sm-6'>" +
                "<div class='form-group'>" +
                "<label for='cancha" + hijas[0] + "' class='col-sm-5 control-label'>Tipo</label>" +
                "<div class='col-sm-7'>" +
                "<select id='cancha" + hijas[0] + "' name='cancha" + hijas[0] + "' class='form-control selectCanchas' data-id='"+hijas[0]+"'>" +
                "<option value='7'>Futbol 7</option>" +
                "<option value='6'>Futbol 6</option>" +
                "<option value='5'>Futbol 5</option>" +
                "</select>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class='col-sm-6'>" +
                "<div class='form-group'>" +
                "<label for='cancha" + hijas[1] + "' class='col-sm-5 control-label'>Tipo</label>" +
                "<div class='col-sm-7'>" +
                "<select id='cancha" + hijas[1] + "' name='cancha" + hijas[1] + "' class='form-control selectCanchas' data-id='"+hijas[1]+"'>" +
                "<option value='7'>Futbol 7</option>" +
                "<option value='6'>Futbol 6</option>" +
                "<option value='5'>Futbol 5</option>" +
                "</select>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
        $("#divCancha" + id_padre).append(html);

    }

    function eliminarhijas(id_padre) {
        console.log("si");
        $("#mini" + id_padre).remove();
    }

    function crearPadre(id_padre) {
        html = "<div class='col-xs-12 '>" +
                "<div id='divCancha" + id_padre + "' class='borderCanchas container-fluid text-right'>" +
                "<i class='fa fa-times ico-cerrar' aria-hidden='true'  data-id='" + id_padre + "'></i>" +
                "<div class='col-sm-12' style='margin-bottom: 10px;'>" +
                "<div class='form-group'>" +
                "<label class='col-sm-5 control-label' for='cancha" + id_padre + "'>Tipo de cancha label</label>" +
                "<div class='col-sm-6'>" +
                "<div class='input-group'>" +
                "<span class='input-group-addon'>" +
                "<input id='check" + id_padre + "' type='checkbox' aria-label='...' class='check hidden '  data-id='" + id_padre + "'>" +
                "</span>" +
                "<select id='cancha" + id_padre + "' class='form-control selectCanchas' data-id='" + id_padre + "' data-padre='0'>" +
                "<option value='11'>Futbol 11</option>" +
                "<option value='10'>Futbol 10</option>" +
                "<option value='9'>Futbol 9</option>" +
                "<option value='8'>Futbol 8</option>" +
                "<option value='7'>Futbol 7</option>" +
                "<option value='6'>Futbol 6</option>" +
                "<option value='5'>Futbol 5</option>" +
                "</select>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
        $("#canchas").append(html);
    }

    function eliminarPadre(id_padre) {
        $("#divCancha" + id_padre).parent().remove();
    }

    var modal = $('#NombreDelModal');


    function onSuccess(result) {
        result = JSON.parse(result);
        console.log(result);
    }
</script>

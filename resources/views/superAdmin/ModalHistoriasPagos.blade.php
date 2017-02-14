



<div id="NombreDelModal">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> Historial de Pagos</h4>
    </div>
    <div class="modal-body">


        <div class="box-body">
            <table id="histoPagos" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td>{{$pago->fecha_inicio}}</td>
                        <td>{{$pago->fecha_fin}}</td>
                        <td>{{$pago->valor}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

<div class="row">

    <div class="col-xs-12">
        <h3>Ingresar un Pago</h3>


        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Fecha de Inicio {{$fechaInicio}}</h3>
            </div>
            {!!Form::open(['id'=>'formPago'])!!}
            <div class="box-body">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Meses a pagar </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                            <input type="number" class="form-control" id="meses" name="meses" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>días adicionales </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></span>
                            <input type="number" class="form-control" id="dias" name="dias" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Valos a pagar </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span>
                            <input type="number" class="form-control" id="valor" name="valor" placeholder="0">
                        </div>
                    </div>
                </div>
                <label class="col-xs-1 col-lg-5 premiado"><input id="pagos_torneo" name="pagos_torneo" type="checkbox" class="form-control minimal" value="1" > Servicio de Torneos</label>
            </div>
            <!-- /.box-body -->

            <div class="row">
                <div class="col-xs-12">
                    <input type="submit" id="pago" class="btn btn-primary pull-right hidden" value="Registrar Pago" style="margin: 0px 15px ">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0px 15px ">Cerrar</button>

                </div>
            </div>

            {!!Form::close()!!}
        </div>

{{--        <div class="col-xs-5 col-sm-3">Fecha de Inicio</div>
        <div class="col-xs-5 col-sm-3">{{$fechaInicio}}</div>
        <div class="col-xs-5 col-sm-3">Meses a pagar </div>--}}
    </div>

</div>

        <div class="alert alert-danger" id="error" style="display: none"> Algo sali mal! Intentalo más tarde</div>
    </div>
{{--    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
    </div>--}}
</div>



{!!Html::script('plugins/iCheck/icheck.min.js')!!}
<script type="text/javascript">

    $(function() {

            $('#histoPagos').DataTable( {
                //"paging":   false,
                //"ordering": false,
                //"info":     false,
                "lengthMenu": [ 3 ],
                "pageLength": 3,
                "language": {
                    "lengthMenu": "Mostrar  _MENU_ pagos por Página",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            } );


        $("#meses").change(function () {

            if(validadExistencia())
                $("#pago").removeClass("hidden").addClass("show");
            else
                $("#pago").removeClass("show").addClass("hidden");

        });

        $("#dias").change(function () {
            if(validadExistencia())
                $("#pago").removeClass("hidden").addClass("show");
            else
                $("#pago").removeClass("show").addClass("hidden");
        });

        $("#valor").change(function () {
            if(validadExistencia())
                $("#pago").removeClass("hidden").addClass("show");
            else
                $("#pago").removeClass("show").addClass("hidden");
        });



        var formulario = $("#formPago");
        formulario.submit(function(e){
            e.preventDefault();
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('addPago')}}',
                data:formulario.serialize()+"&id={{$id}}",
                success: function(data){
                    if (data=="exito") {
                        modalBs.modal('hide');
                        window.location="sitiosRegistrados";
                    }
                    else {
                        $("#error").css('display','block');
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });


        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

    });


    function validadExistencia() {

        return (($("#meses").val()!=0||$("#dias").val()!=0)&&($("#valor").val()!=0));
    }

    var modal = $('#NombreDelModal');


    function onSuccess(result) {
        result = JSON.parse(result)
        console.log(result);
    }
</script>


<div id="modalToken">
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




<div id="NombreDelModal">
    {!!Form::open(['id'=>'formLogin'])!!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4> Iniciar Sesión</h4>
    </div>
    <div class="modal-body">

        <div class="form-group">
            {!!Form::label('user','Usuario*')!!}
            {!!Form::text('user',null,['class'=>'form-control', 'required'])!!}
        </div>
        <div class="form-group">
            {!!Form::label('password','Contraseña*')!!}
            {!!Form::password('password',['class'=>'form-control', 'required'])!!}
        </div>
        <div class="alert alert-danger" id="error" style="display: none"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
    </div>
    {!!Form::close()!!}
</div>




<script type="text/javascript">

    $(function() {

        var formRetirarToken= $("#formRetirarToken");
        formRetirarToken.submit(function(e){
            e.preventDefault();
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('retirarToken')}}',
                data:formRetirarToken.serialize()+"&id_token="+id_res,
                success: function(data){


                },
                error: function(){
                    console.log('ok');
                }
            });
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
        });
    });

    var modal = $('#modalToken');


    function onSuccess(result) {
        result = JSON.parse(result)
        console.log(result);
    }
</script>



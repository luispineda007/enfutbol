<div id="NombreDelModal">
    {!!Form::open(['id'=>'formLogin'])!!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="text-center" style="margin-bottom: 15px;"> Iniciar Sesión</h3>
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
        <div class="box box-default" style="margin-top: 25px;">
            <div class="box-body">

                <a href="{{route("getEmail")}}" style="font-size: 16px;"><i class="fa fa-key" aria-hidden="true" ></i> Olvide mi contraseña</a><br>
                <a href="{{route("registrarJugador")}}" class="text-center" style="font-size: 16px;"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrarse como Jugador</a>

            </div>
            <!-- /.box-body -->
        </div>
        <div class="alert alert-danger" id="error" style="display: none"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
    </div>
</div>
{!!Form::close()!!}



<script type="text/javascript">

    $(document).ready(function() {

        var formulario = $("#formLogin");
        formulario.submit(function(e){
            e.preventDefault();
            $.ajax({
                type:"POST",
                context: document.body,
                url: '{{route('loginModal')}}',
                data:formulario.serialize(),
                success: function(data){
                    if (data=="login exitoso") {
                        modalBs.modal('hide');
                        window.location="administrador";
                        //window.location.reload();
                    }
                    else {
                        $("#error").text(data);
                        $("#error").css('display','block');

                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });

    var modal = $('#NombreDelModal');


    function onSuccess(result) {
        result = JSON.parse(result)
        console.log(result);
    }
</script>



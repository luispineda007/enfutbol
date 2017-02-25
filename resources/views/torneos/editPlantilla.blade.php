<div class="text-center">
    <h3 class="titulo"><b>Editar plantilla</b></h3>
</div>
{!!Form::open(['id'=>'formPlantilla', 'autocomplete'=>'off', 'class'=>'form-horizontal'])!!}
    <div class="form-group">
        <label for="nombre" class="col-md-2 control-label">Nombre</label>
        <div class="col-md-8">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-th-list"></i>
                </div>
                {!!Form::text('nombre',$plantilla->nombre,['class'=>'form-control','placeholder'=>"Nombre de la plantilla..", 'required', 'id'=> 'nombre'])!!}
                {{--<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la plantilla.." required value="{{$plantilla->nombre}}">--}}
            </div>
        </div>
    </div>



    <div class="form-group">
        <label for="nombre" class="col-md-2 control-label">Genero</label>
        <div class="col-md-8">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-venus-mars"></i>
                </div>
                <select class="form-control" id="genero" name="genero" required>
                    <option value="M" {{($plantilla->genero == 'M')?'selected':''}}>Masculino</option>
                    <option value="F" {{($plantilla->genero == 'F')?'selected':''}}>Femenino</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12 text-center" style="margin-top: 25px;">
            <button type="submit" id="btnPlantilla" class="btn btn-primary">Guardar</button>
        </div>
    </div>
{!!Form::close()!!}


<div class="col-xs-12" style="margin-top: 15px;">
    <div>
        <h3 class="titulo"><b>Integrantes</b>&nbsp;<small>(Max. 15)</small></h3>
    </div>

    @if(count($plantilla->getJugadores) < 15)
        {!!Form::open(['id'=>'formIntegrante','class'=>'form-horizontal','autocomplete'=>'off'])!!}
        <div class="form-group" style="margin-bottom: 20px">
            {!! Form::label('autocompletar', 'Agregar',['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-7">
                {!!Form::text('user',null,['id'=>'autocompletar','class'=>'form-control','placeholder'=>"Identificacion o usuario", 'required', 'data-plantilla'=>"$plantilla->id"])!!}
            </div>
            {!!Form::text('user_id',null,['id'=>'user_id','class'=>'form-control hidden'])!!}

            <div class="col-sm-2">
                <i class="fa fa-user-plus fa-2x hidden manito" data-toggle='tooltip' data-popout='true' data-placement='top' title="Agregar a plantilla" id="iconoIntegrante" style="color: mediumblue; padding-top: 4px"></i>
            </div>
        </div>
        {!!Form::close()!!}
    @endif


    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="text-center">Documento</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">Accion</th>
        </tr>
        </thead>
        <tbody id="participantes" data-torneo="{{$plantilla->id}}">
        @foreach($plantilla->getJugadores as $integrante)

            <tr class="fila">
                <td>{{$integrante->getUsuario->getPersona->identificacion}}</td>
                <td>{{$integrante->getUsuario->getPersona->nombres}}</td>
                <td class="text-center" data-integrante="{{$integrante->id}}">
                    <i class="fa fa-times-circle-o fa-2x eliminar pointer" aria-hidden='true' data-toggle='confirmation' data-singleton="true" data-placement='top' title="Eliminar?"></i>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{--<div class="form-group">--}}
    {{--<div class="col-sm-12 text-center" style="margin-top: 25px;">--}}
        {{--<button type="button" id="btnPlantilla" class="btn btn-primary">Guardar</button>--}}
    {{--</div>--}}
{{--</div>--}}

<script src="plugins/bootstrapConfirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script>
    $(function(){
        var form = $("#formPlantilla");
        form.submit(function(e){
            e.preventDefault();
            console.log('sidufhds');
        });


        $(".eliminar").each(function(){
            $(this).confirmation({
                onConfirm: function () {
                    eliminarJugador($(this).parent());
                }
            });
        });
    });

    $("#participantes").on('click', '.eliminar', function(){
        $(this).confirmation({
            onConfirm: function () {
                eliminarJugador($(this).parent());
            }
        });
    });
</script>
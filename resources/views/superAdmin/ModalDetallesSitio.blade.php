



<div id="NombreDelModal">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="text-center"> {{$sitio->nombre}}</h3>
    </div>
    <div class="modal-body">
        <h4 class="text-center">Información del usuario</h4>
        <dl class="dl-horizontal">
            <dt>Usuario:</dt>
            <dd>{{$sitio->getUsuario->user}}</dd>
            <dt>Administrador:</dt>
            <dd>{{$sitio->getUsuario->getPersona->nombres}}</dd>
            <dt>Telefono:</dt>
            <dd>{{$sitio->getUsuario->getPersona->telefono}}</dd>
            <dt>Email:</dt>
            <dd>{{$sitio->getUsuario->email}}</dd>
        </dl>
        <h4 class="text-center">Información del Sitio</h4>
        <dl class="dl-horizontal">
            <dt>Nombre:</dt>
            <dd>{{$sitio->nombre}}</dd>
            <dt>Estado de Pagos:</dt>
            <dd>{{($sitio->estado_pago=="A")?"Activa":"Inactiva"}}</dd>
            <dt>Ciudad:</dt>
            <dd>{{$sitio->getMunicipio->municipio}}</dd>
            <dt>Dirección:</dt>
            <dd>{{$sitio->direccion}}</dd>
            <dt>Cantidad de canchas:</dt>
            <dd>{{$sitio->getCanchas->count()}}</dd>
            <dt>facebook:</dt>
            <dd>{{$sitio->facebook}}</dd>
            <dt>twitter:</dt>
            <dd>{{$sitio->twitter}}</dd>
        </dl>
    </div>

</div>




<script type="text/javascript">

    $(function() {

    });


    var modal = $('#NombreDelModal');


    function onSuccess(result) {
        result = JSON.parse(result)
        console.log(result);
    }
</script>

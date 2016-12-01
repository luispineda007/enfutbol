<link rel="stylesheet" href="plugins/iCheck/all.css">
<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<style>
    .cabeza{
        background-color: rgba(255, 0, 0, 0.57);
        color: white;
    }

    h3{
        margin-top: 0;
        margin-bottom: 0
    }

    .cuerpo{
        font-size: 16px;
    }
</style>

<div id="NombreDelModal">
    <div class="modal-header cabeza">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="text-center"><b>Error!</b></h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12 cuerpo">
                No puedes configurar el horario de tu sitio en este momento, debido a que existen {{$cantidad}} reservas.
                <b>Cancelalas </b>para continuar esta accion.
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Entendido!</button>
    </div>
</div>
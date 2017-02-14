@extends('layouts.principal')

@section('css')
    {!!Html::style('plugins/iCheck/all.css')!!}
    {!!Html::style('plugins/datatables/dataTables.bootstrap.css')!!}

    <style>
        #histoPagos>tbody>tr>td, #histoPagos>tbody>tr>th, #histoPagos>tfoot>tr>td, #histoPagos>tfoot>tr>th, #histoPagos>thead>tr>td, #histoPagos>thead>tr>th {
            padding: 3px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
    </style>


@endsection
{{------end css--}}

@section('Pageheader')

    <h1>
        Sitios
        <small>registrados</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>

@endsection
{{------end css--}}

@section('content')

    <!-- /.panel-heading -->
    <div class="row">


    <div class="col-sm-10 col-sm-offset-1">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a class="btn btn-default" href="{{route('registrarSitio')}}" role="button">Registrar un Nuevo Sitio</a></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="sitiosRegistrados" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Editar Canchas</th>
                        <th>Ver Historial</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sitios as $sitio)
                        <tr>
                            <td>{{$sitio->nombre}}</td>
                            @if($sitio->estado_pago=="A")
                            <td>   Activo  </td>
                            @else
                                <td> <span class="label label-danger">Inactivo</span></td>
                            @endif
                            <td class="text-center"><a class="btn btn-default accion" href="{{route('modalDetallesSitio',["id"=>$sitio->id])}}" role="button" data-modal="">Detalles</a></td>
                            <td class="text-center"><a class="btn btn-default accion" href="{{route('modalEditarCanchas',["id"=>$sitio->id])}}" role="button" data-modal="">Editar</a></td>
                            <td class="text-center"><a class="btn btn-default accion" href="{{route('modalHistorialPagos',["id"=>$sitio->id])}}" role="button" data-modal="">Pagos</a></td>

                        </tr>
                    @endforeach
                    </tbody>
{{--                    <tfoot>
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                    </tfoot>--}}
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>









@endsection
{{------end content--}}

@section('js')
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}

    <script>
        $(function () {
            $('#sitiosRegistrados').DataTable( {
                "language": {
                    "lengthMenu": "Mostrar  _MENU_ Sitios por Página",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            } );
        });

        $("#sitiosRegistrados").on("click",".accion", function () {
            //$("#myModal").modal("show");
           // alert("ver historial de pagos de sitio "+$(this).data("id"));
        });

    </script>
@endsection
{{------end js--}}
@extends('layouts.principal')

@section('css')
    <script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}

@endsection
{{------end css--}}

@section('Pageheader')

    <h1>
        Dashboard
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>

@endsection
{{------end css--}}

@section('content')

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Launch demo modal
    </button>
    <div id="result"></div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <button id="get" type="button" class="btn btn-default">Get</button>
                    <div id="getinfo"></div>
                    {!!$map['html']!!}
                </div>
                <div id="info"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Ubicacion</button>
                </div>
            </div>
        </div>
    </div>


@endsection
{{------end content--}}

@section('js')

    <script>
        $("#myModal").on("shown.bs.modal", function () {
            var currentCenter = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(currentCenter);
        });

        $("#get").click(function () {
            var infomap = map.getCenter();
            $("#getinfo").html(infomap.lat()+" , "+ infomap.lng());

        });

    </script>

@endsection
{{------end js--}}
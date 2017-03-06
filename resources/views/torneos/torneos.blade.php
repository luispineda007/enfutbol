<div class="row">
    @foreach($torneos as $torneo)

        <div class="col-sm-6 col-md-3 product-grid">
            <div class="thumbnail manito" data-torneo="{{$torneo->id}}">
                <div class="product-location text-center">
                    <span class="fa-map-marker fa"></span> {{$torneo->getMunicipio->municipio}}
                </div>
                <img src="/images/torneos/{{$torneo->url_logo}}" alt="...">
                <div class="caption">
                    <small>{{$torneo->created_at}}</small>
                    <small class="pull-right">
                        <span class="fa-venus-mars fa"></span><b> {{$torneo->genero}}</b>
                    </small>
                    <h4>{{$torneo->nombre}}</h4>
                </div>
            </div>
        </div>

    @endforeach
</div>

<div class="row text-center">
    {!! $torneos->render() !!}
</div>
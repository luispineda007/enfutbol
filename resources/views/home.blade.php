@extends('layouts.frontEnd.principal')

@section('css')
    <title>EnFutbol.co</title>
    <!-- bootstrap datepicker -->
    {!!Html::style('plugins/datepicker/datepicker3.css')!!}
    <!-- Bootstrap time Picker -->
    {!!Html::style('plugins/timepicker/bootstrap-timepicker.min.css')!!}
    <!-- DataTables -->
    {!!Html::style('plugins/jQueryUI/jquery-ui.css')!!}

    <script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}

    <style>

.cargando{
    font-size: 16px;
}


    </style>



@endsection



@section('header')
    <header role="banner" id="fh5co-header">
        <div class="container">
            <!-- <div class="row"> -->
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <!-- Mobile Toggle Menu Button -->
                    <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle " data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                    <a class="navbar-brand" href="{{route("home")}}">enFutbol</a>
                    @if(!Auth::guest())
                        <a href="#" onclick="return false;" class="perfilUserCol  perfilUser hidden-sm hidden-md hidden-lg pull-right" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0">
                            @if(Auth::user()->rol=="admin")
                                <img src="{{URL::to('images/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                            @else
                                <img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                            @endif

                        </a>
                    @endif
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#" onclick="return false;" data-nav-section="home"><span>Inicio</span></a></li>
                        <li><a href="{{route("buscar")}}"  ><span>Buscar</span></a></li>
                        <li class="hidden-md"><a href="#" onclick="return false;" data-nav-section="services"><span>Servicios</span></a></li>
                        <li><a href="#" onclick="return false;" data-nav-section="about"><span>About</span></a></li>
                        <li><a href="#" onclick="return false;" data-nav-section="contact"><span>contacto</span></a></li>

                        @if(Auth::guest())
                            <li><a href="{{route('myLoginModal')}}"   data-modal=""  ><span>Iniciar Sesión</span></a></li>
                        @else
                            {{--<li class="hidden-xs hidden-sm"><a href="{{route('logout')}}"><span>Cerrar Sesión</span></a></li>--}}
                            {{--<li><a href="perfil" data-toggle="tooltip" data-placement="bottom" title="{{Auth::user()->getPersona->nombres}}"><img src="dist/img/avatar3.png" alt="..." class="img-circle" style="width: 30px;height: 30px;"></a></li>--}}
                            <li  class="hidden-xs ">
                                <a href="#" onclick="return false;" class="perfilUser" data-toggle="popover" title="{{Auth::user()->getPersona->nombres}}" tabindex="0">
                                    @if(Auth::user()->rol=="admin")
                                        <img src="{{URL::to('images/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                                    @else
                                        <img src="{{URL::to('dist/img/'.Auth::user()->avatar)}}" alt="..." class="img-circle" style="width: 30px;height: 30px;">
                                    @endif
                                </a>
                            </li>

                        @endif



                    </ul>
                </div>
            </nav>
            <!-- </div> -->
        </div>
    </header>

@endsection



@section('content')

    <section id="fh5co-home" data-section="home" style="background-image: url({{URL::to('images/full_image_22.jpg')}});" data-stellar-background-ratio="0.5">
        <div class="gradient"></div>
        <div class="container">
            <div class="text-wrap">
                <div class="text-inner">
                    <div class="row">
                        <div class="col-md-12 ">

                                <img src="images/logo.png" alt="" class="subtext to-animate" style="width: 310px; /*height: 190px;*/ margin-bottom: 50px;">


                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 subtext to-animate">
                                    <h3>Encuentra el mejor sitio Indicando</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">

                                    {!!Form::open(['route' => 'getCanchasBusqueda','id'=>'canchastipo','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {!! Form::label('tipo', 'Tipo de Cancha',['class'=>'hidden-xs hidden-sm']) !!}

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                {!!Form::select('tipo', ['11' => 'Futbol 11', '10' => 'Futbol 10', '9' => 'Futbol 9', '8' => 'Futbol 8', '7' => 'Futbol 7', '6' => 'Futbol 6', '5' => 'Futbol 5'], null, ['class'=>"form-control",'placeholder' => 'Tipo de Cancha', 'required'])!!}
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            {!! Form::label('fecha', 'Fecha',['class'=>'hidden-xs hidden-sm']) !!}

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="fecha" class="form-control pull-right manito" id="fecha" placeholder="Fecha" readonly>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label class='hidden-xs hidden-sm'>Hora:</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <input id="hora" name="hora" type="text" class="form-control timepicker manito" readonly placeholder="Hora">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </div>

                                    {!!Form::close()!!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slant"></div>
    </section>

    <section id="fh5co-intro">
        <div class="container">
            <div class="row row-bottom-padded-lg">
                <div class="fh5co-block to-animate" style="background-image: url({{URL::to('images/img_7.jpg')}});">
                    <div class="overlay-darker"></div>
                    <div class="overlay"></div>
                    <div class="fh5co-text">

                        <i class="fh5co-intro-icon icon-people"></i>
                        <h2>Jugador</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <p><a href="#" class="btn btn-primary">Get In Touch</a></p>
                    </div>
                </div>
                <div class="fh5co-block to-animate" style="background-image: url({{URL::to('images/img_8.jpg')}});">
                    <div class="overlay-darker"></div>
                    <div class="overlay"></div>
                    <div class="fh5co-text">
                        <i class="fh5co-intro-icon fa fa-user" aria-hidden="true"></i>
                        {{--<i class="fh5co-intro-icon icon-wrench"></i>--}}
                        <h2>Administrador</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <p><a href="#" class="btn btn-primary">Click Me</a></p>
                    </div>
                </div>
                <div class="fh5co-block to-animate" style="background-image: url({{URL::to('images/img_9.jpg')}});">
                    <div class="overlay-darker"></div>
                    <div class="overlay"></div>
                    <div class="fh5co-text">
                        <i class="fh5co-intro-icon fa fa-user-secret" aria-hidden="true"></i>
                        {{--<i class="fh5co-intro-icon icon-rocket"></i>--}}
                        <h2>Entrenador</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <p><a href="#" class="btn btn-primary">Why Us?</a></p>
                    </div>
                </div>
            </div>
            <div class="row watch-video text-center to-animate">
                <span>Ubica tu Sitio</span>
                {!!$map['html']!!}
                {{--<a href="https://vimeo.com/channels/staffpicks/93951774" class="popup-vimeo btn-video"><i class="icon-play2"></i></a>--}}
            </div>
        </div>
    </section>

    <section id="fh5co-work" data-section="work" class="work">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center">
                    <h2 class="to-animate">Sitios recomendados para ti</h2>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>las mejores canchas de la ciudad</h3>
                        </div>
                    </div>
                   {{-- <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">

                            {!!Form::open(['id'=>'canchastipo','class'=>'form-horizontal', 'autocomplete'=>'off'])!!}

                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('tipo', 'Tipo de Cancha',['class'=>'hidden-xs hidden-sm']) !!}

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        {!!Form::select('tipo', ['11' => 'Futbol 11', '10' => 'Futbol 10', '9' => 'Futbol 9', '8' => 'Futbol 8', '7' => 'Futbol 7', '6' => 'Futbol 6', '5' => 'Futbol 5'], null, ['class'=>"form-control",'placeholder' => 'Tipo de Cancha', 'required'])!!}
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('fecha', 'Fecha',['class'=>'hidden-xs hidden-sm']) !!}

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="fecha" class="form-control pull-right manito" id="fecha" placeholder="Fecha" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label class='hidden-xs hidden-sm'>Hora:</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input id="hora" name="hora" type="text" class="form-control timepicker manito" readonly placeholder="Hora">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>

                            {!!Form::close()!!}
                        </div>
                    </div>--}}
                </div>

                @foreach($sitios as $sitio)
                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="sitio/{{$sitio["id_sitio"]}}"  class="fh5co-project-item to-animate perfiSitio" data-id="{{$sitio["id_sitio"]}}">
                            <img src="images/{{$sitio["portada"]}}" alt="Image" class="img-responsive portada">
                            <div class="fh5co-text">
                                <h2>{{$sitio["nombre"]}}</h2>
                                <span>{{$sitio["ciudad"]}}</span>
                            </div>
                        </a>
                    </div>
                @endforeach

                    {{--<div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_3.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_3.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 3</h2>
                                <span>Web</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_4.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_4.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 4</h2>
                                <span>UI/UX</span>
                            </div>
                        </a>
                    </div>

                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_5.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_5.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 1</h2>
                                <span>Photography</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_6.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_6.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 2</h2>
                                <span>Illustration</span>
                            </div>
                        </a>
                    </div>

                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_7.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_7.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 3</h2>
                                <span>Web</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xxs-12">
                        <a href="images/work_8.jpg" class="fh5co-project-item image-popup to-animate">
                            <img src="images/work_8.jpg" alt="Image" class="img-responsive">
                            <div class="fh5co-text">
                                <h2>Project 4</h2>
                                <span>Sketch</span>
                            </div>
                        </a>
                    </div>--}}

                </div>
            </div>
    </section>

{{--    <section id="fh5co-testimonials" data-section="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center">
                    <h2 class="to-animate">Testimonials</h2>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box-testimony">
                        <blockquote class="to-animate-2">
                            <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
                        </blockquote>
                        <div class="author to-animate">
                            <figure><img src="images/person1.jpg" alt="Person"></figure>
                            <p>
                                Jean Doe, CEO <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-testimony">
                        <blockquote class="to-animate-2">
                            <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.&rdquo;</p>
                        </blockquote>
                        <div class="author to-animate">
                            <figure><img src="images/person2.jpg" alt="Person"></figure>
                            <p>
                                John Doe, Senior UI <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-testimony">
                        <blockquote class="to-animate-2">
                            <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.&rdquo;</p>
                        </blockquote>
                        <div class="author to-animate">
                            <figure><img src="images/person2.jpg" alt="Person"></figure>
                            <p>
                                John Doe, Senior UI <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-testimony">
                        <blockquote class="to-animate-2">
                            <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.&rdquo;</p>
                        </blockquote>
                        <div class="author to-animate">
                            <figure><img src="images/person2.jpg" alt="Person"></figure>
                            <p>
                                John Doe, Senior UI <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-testimony">
                        <blockquote class="to-animate-2">
                            <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. &rdquo;</p>
                        </blockquote>
                        <div class="author to-animate">
                            <figure><img src="images/person3.jpg" alt="Person"></figure>
                            <p>
                                Chris Nash, Director <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>


    <section id="fh5co-services" data-section="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-left">
                    <h2 class=" left-border to-animate">Services</h2>
                    <div class="row">
                        <div class="col-md-8 subtext to-animate">
                            <h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 fh5co-service to-animate">
                    <i class="icon to-animate-2 icon-anchor"></i>
                    <h3>Brand &amp; Strategy</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean</p>
                </div>
                <div class="col-md-6 col-sm-6 fh5co-service to-animate">
                    <i class="icon to-animate-2 icon-layers2"></i>
                    <h3>Web &amp; Interface</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean</p>
                </div>

                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-6 col-sm-6 fh5co-service to-animate">
                    <i class="icon to-animate-2 icon-video2"></i>
                    <h3>Photo &amp; Video</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean</p>
                </div>
                <div class="col-md-6 col-sm-6 fh5co-service to-animate">
                    <i class="icon to-animate-2 icon-monitor"></i>
                    <h3>CMS &amp; eCommerce</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean</p>
                </div>

            </div>
        </div>
    </section>--}}

    <section id="fh5co-about" data-section="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center">
                    <h2 class="to-animate">About</h2>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="fh5co-person text-center to-animate">
                        <figure><img src="images/cgh.png" alt="Image" style="width: 120px;height: 120px; "></figure>
                        <h3>Jean Smith</h3>
                        <span class="fh5co-position">Web Designer</span>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts</p>
                        <ul class="social social-circle">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fh5co-person text-center to-animate">
                        <figure><img src="images/ceindetec.jpg" alt="Image" style="width: 120px;height: 120px; "></figure>
                        <h3>Rob Smith</h3>
                        <span class="fh5co-position">Web Developer</span>
                        <p>La Corporación CEINDETEC Llanos es una Entidad Sin Ánimo de Lucro dedicada al fomento de la Investigación y el Desarrollo Tecnológico. Tiene como objetivo contribuir a la apropiación social de la Ciencia y la Tecnología, y al cambio hacia una cultura basada en el Conocimiento y la Investigación, que incorpore el Desarrollo Tecnológico a la cotidianidad y a los procesos productivos dentro de un marco de desarrollo sostenible.</p>
                        <ul class="social social-circle">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-github"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fh5co-person text-center to-animate">
                        <figure><img src="images/smart.png" alt="Image" style="width: 120px;height: 120px; "></figure>
                        <h3>Larry Ben</h3>px
                        <span class="fh5co-position">Web Designer</span>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts</p>
                        <ul class="social social-circle">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-counters" style="background-image: url({{URL::to('images/full_image_1.jpg')}});" data-stellar-background-ratio="0.5">
        <div class="fh5co-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center to-animate">
                    <h2>Fun Facts</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fh5co-counter to-animate">
                        {{--<i class="fh5co-counter-icon icon-briefcase to-animate-2"></i>--}}
                        <i class="fh5co-counter-icon fa fa-map-marker to-animate-2" aria-hidden="true"></i>
                        <span class="fh5co-counter-number js-counter" data-from="0" data-to="89" data-speed="5000" data-refresh-interval="50">89</span>
                        <span class="fh5co-counter-label">Sitios</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fh5co-counter to-animate">
                        {{--<i class="fh5co-counter-icon icon-code to-animate-2"></i>--}}
                        <i class=" fh5co-counter-icon fa fa-futbol-o to-animate-2" aria-hidden="true"></i>
                        <span class="fh5co-counter-number js-counter" data-from="0" data-to="2343409" data-speed="5000" data-refresh-interval="50">2343409</span>
                        <span class="fh5co-counter-label">Canchas</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fh5co-counter to-animate">
                        <i class="fh5co-counter-icon icon-people to-animate-2"></i>
                        <span class="fh5co-counter-number js-counter" data-from="0" data-to="1302" data-speed="5000" data-refresh-interval="50">1302</span>
                        <span class="fh5co-counter-label">Jugadores</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="fh5co-counter to-animate">
                        <i class="fh5co-counter-icon fa fa-sitemap to-animate-2" aria-hidden="true"></i>
                        <span class="fh5co-counter-number js-counter" data-from="0" data-to="52" data-speed="5000" data-refresh-interval="50">52</span>
                        <span class="fh5co-counter-label">Torneos</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fh5co-contact" data-section="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heading text-center">
                    <h2 class="to-animate">Get In Touch</h2>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 subtext to-animate">
                            <h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-bottom-padded-md">
                <div class="col-md-6 to-animate">
                    <h3>Contact Info</h3>
                    <ul class="fh5co-contact-info">
                        <li class="fh5co-contact-address ">
                            <i class="icon-home"></i>
                            5555 Love Paradise 56 New Clity 5655, <br>Excel Tower United Kingdom
                        </li>
                        <li><i class="icon-phone"></i> (123) 465-6789</li>
                        <li><i class="icon-envelope"></i>informacion.enfutbol.co@gmail.com</li>
                        <li><i class="icon-globe"></i> <a href="http://freehtml5.co/" target="_blank">freehtml5.co</a></li>
                    </ul>
                </div>

                <div class="col-md-6 to-animate">

                    {!!Form::open(['id'=>'formContacto','class'=>'form-horizontal'])!!}
                    <h3>Contact Form</h3>
                    <div class="form-group ">
                        <label for="name" class="sr-only">Name</label>
                        <input id="name" name="nombre" class="form-control" placeholder="Nombre" type="text" required>
                    </div>
                    <div class="form-group ">
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" class="form-control" name="email" placeholder="Email" type="email" required>
                    </div>
                    <div class="form-group ">
                        <label for="phone" class="sr-only">Phone</label>
                        <input id="phone" name="telefono" class="form-control" placeholder="Telefono" type="text" required>
                    </div>
                    <div class="form-group ">
                        <label for="message" class="sr-only">Message</label>
                        <textarea name="mensaje" id="message" cols="30" rows="5" class="form-control" placeholder="Mensaje" required></textarea>
                    </div>

                    <div id="alertContacto" class="form-group ">


                    </div>
                    <div class="form-group ">
                        {{--<input class="btn btn-primary btn-lg" value="Send Message" type="submit" >--}}
                        <button class="btn btn-primary btn-lg" type="submit">Enviar <i class="fa fa-spinner fa-pulse fa-3x fa-fw cargando hidden"></i>
                            <span class="sr-only">Loading...</span> </button>



                    </div>
                </div>
            </div>

        </div>
        </div>

    </section>



@endsection

@section('js')

    <!-- bootstrap datepicker -->
    {!!Html::script('plugins/datepicker/bootstrap-datepicker.js')!!}
    <!-- bootstrap time picker -->
    {!!Html::script('plugins//timepicker/bootstrap-timepicker.min.js')!!}
    <!-- DataTables -->
    {!!Html::script('plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('plugins/datatables/dataTables.bootstrap.min.js')!!}
    <script>

        $(function () {
            windowScroll();
            sitiosCanchas(0,"2016-02-02","12");

            $(".timepicker").timepicker({
//                template:'modal',
                showInputs: false,
                showSeconds: false,
                showMeridian: false,
                minuteStep:60,
                defaultTime:false
            }).on('hide.timepicker', function(e) {
                if($("#tipo").val()!=""&&$("#fecha").val()!="") {

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),e.time.hours);

                    $("#canchastipo").submit();
                    //console.log('funcioc( ' + $("#tipo").val() + "  , " + $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , " + e.time.hours + " )");
                }
            }).on('show.timepicker', function(e) {

                if($('#hora').val()=="")
                    $('#hora').timepicker('setTime', '12:00');
            });

            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
                clear: "Clear",
                format: "yyyy-mm-dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $('#fecha').datepicker({
                autoclose: true,
                todayHighlight:true,
                startDate:'+0d',
                endDate:'+15d',
                language: 'es'
            }).on('changeDate', function () {

                if($("#tipo").val()!=""&&$("#hora").val()!=""){

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    $("#canchastipo").submit();
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });

            $("#tipo").change(function () {

                if($("#hora").val()!=""&&$("#fecha").val()!=""){

                    sitiosCanchas($("#tipo").val(),$("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd'),parseInt($("#hora").val().split(":")[0]));
                    $("#canchastipo").submit();
                    //console.log('funcioc( ' + $("#tipo").val()+"  , "+ $("#fecha").data('datepicker').getFormattedDate('yyyy-mm-dd') + " , "+parseInt($("#hora").val().split(":")[0])+" )");
                }

            });



            var formContacto = $("#formContacto");
            formContacto.submit(function(e){
                e.preventDefault();
                $(".cargando").removeClass("hidden");
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('enviar')}}',
                    data:formContacto.serialize(),
                    success: function(data){
                        if (data=="exito") {
                            $(".cargando").addClass("hidden");
                            $("#alertContacto").empty();

                            html = '<div class="alert alert-success">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                            '<strong>Perfecto!</strong> el mensaje fue enviado'+
                            '</div>';


                            $("#alertContacto").append(html);

                        }
                        else {
                            //alert("Se genero un error Interno");
                        }
                    },
                    error: function(){
                        console.log('ok');
                    }
                });
            });








        });

        /*        $('#hora').on('changeTime.timepicker', function(e) {
         console.log('The hour is ' + e.time.hours+"----"+ $("#fecha").getDates);
         });*/


        function sitiosCanchas(tipo,fecha,hora) {

            if(tipo&&fecha&&hora!=null)
                console.log('funcioc( ' + tipo+"  , "+ fecha + " , "+ hora +" )");


            $.ajax({
                 type:"POST",
                 context: document.body,
                 url: '{{route("getCanchasBusqueda")}}',
                 data:{"tipo":tipo,"fecha":fecha,"hora":hora,"vista":false},
                 success: function(data){
                    if (data["estado"]==true) {

                    }
                     else {

                     }
                 },
                 error: function(){
                 console.log('ok');
                 }
             });

        }

        // Window Scroll
        var windowScroll = function() {
            var lastScrollTop = 0;

            $(window).scroll(function(event){

                var header = $('#fh5co-header'),
                        scrlTop = $(this).scrollTop();

                if ( scrlTop > 500 && scrlTop <= 4000 ) {
                    header.addClass('navbar-fixed-top fh5co-animated slideInDown');
                } else if ( scrlTop <= 500) {
                    if ( header.hasClass('navbar-fixed-top') ) {
                        header.addClass('navbar-fixed-top fh5co-animated slideOutUp');
                        setTimeout(function(){
                            header.removeClass('navbar-fixed-top fh5co-animated slideInDown slideOutUp');
                        }, 100 );
                    }
                }

            });
        };
    </script>
@endsection


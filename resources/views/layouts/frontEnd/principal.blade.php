<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Template by FREEHTML5.CO"/>
    <meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive"/>
    <meta name="author" content="FREEHTML5.CO"/>
    <meta name='csrf-param' content='authenticity_token'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        @if (!Auth::guest())
            @if(\Request::route()->getName() != 'completarFormulario')
                @if (Auth::user()->getPersona->identificacion == "")
                window.location = "{{route('completarFormulario')}}";
                @endif
            @endif
        @endif
    </script>
<!--
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE
	DESIGNED & DEVELOPED by FREEHTML5.CO

	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content=""/>
    <meta name="twitter:image" content=""/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:card" content=""/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" type="image/ico" href="/favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet'
          type='text/css'>

    <!-- Animate.css -->
{!!Html::style('css/animate.css')!!}
<!-- Icomoon Icon Fonts-->
{!!Html::style('css/icomoon.css')!!}
<!-- Simple Line Icons -->
{!!Html::style('css/simple-line-icons.css')!!}
<!-- Magnific Popup -->
{!!Html::style('css/magnific-popup.css')!!}
<!-- Bootstrap  -->
{!!Html::style('css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('css/font-awesome.min.css')!!}
{!!Html::style('css/style4.css')!!}

@yield('css')


{!!Html::style('css/style.css')!!}

<!-- Modernizr JS -->
{!!Html::script('js/modernizr-2.6.2.min.js')!!}
<!-- FOR IE9 below -->
    {{--[if lt IE 9]>--}}
    {!!Html::script('js/respond.min.js')!!}
    <![endif]-->


    {!!Html::style('css/style.css')!!}
</head>
<body onmousemove="stim()" onkeypress="stim()">

@yield('header')

@yield('content')

<footer id="footer" role="contentinfo">
    <a href="#" class="gotop js-gotop"><i class="icon-arrow-up2"></i></a>
    <div class="container">
        <div class="">
            <div class="col-md-12 text-center">
                <p>&copy; enfutbol.co 2016 </p>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="social social-circle">
                    <li><a href="#"><i class="icon-twitter"></i></a></li>
                    <li><a href="#"><i class="icon-facebook"></i></a></li>
                    <li><a href="#"><i class="icon-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- jQuery 2.2.3 -->
{!!Html::script('plugins/jQuery/jquery-2.2.3.min.js')!!}
<!-- jQuery Easing -->
{!!Html::script('js/jquery.easing.1.3.js')!!}
<!-- Bootstrap -->
{!!Html::script('js/bootstrap.min.js')!!}
<!-- Waypoints -->
{!!Html::script('js/jquery.waypoints.min.js')!!}
<!-- Stellar Parallax -->
{!!Html::script('js/jquery.stellar.min.js')!!}
<!-- Counter -->
{!!Html::script('js/jquery.countTo.js')!!}
<!-- Magnific Popup -->
{!!Html::script('js/jquery.magnific-popup.min.js')!!}
{!!Html::script('js/magnific-popup-options.js')!!}

@yield('js')

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.perfilUser').each(function (index, elemento) {

            $(elemento).popover({
                placement: "bottom",
                trigger: "focus",
                //title: '<h3 class="popover-title text-center"></h3>',
                content: '<div class="btn-block"><a href="{{route("perfilUsuario")}}"><span class="text-center munuOpen">Perfil</span></a></div>    <div class="btn-block"><a href="{{route("misReservas")}}"><span class="text-center munuOpen">Mis Reservas</span></a></div>   <div class="btn-block"> <a class="btn-block" href="{{route('logout')}}"><span class="text-center munuOpen">Cerrar Sesión</span></a> </div>',
                html: true
            });

        });


    })
    var tim = null;

    function stim() {
        if (tim != null)clearTimeout(tim);
        tim = setTimeout("show()", 600000);
        return tim;
    }

    function show() {
        window.location.reload();
    }
</script>
<!-- Main JS (Do not remove) -->
{!!Html::script('js/main.js')!!}

<div id='modalBs' class='modal fade bs-example-modal-lg'>
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
{!!Html::script('js/inicio.js')!!}
</body>
</html>


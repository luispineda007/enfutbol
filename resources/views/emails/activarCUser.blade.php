<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .img-circle{
            border-radius: 50%;
        }
        #mi-imagen{
            background-image: url('http://enfutbol.ceindetec.org.co/images/logo.png');
            background-size: contain;
            background-repeat: no-repeat;
            width: 200px;
            height: 150px;
            margin: 0 auto;
        }
        .lin{
            text-decoration: none;
        }
        #pie{
            font-size: 9px;
            color: #989898;
        }
    </style>
</head>
<body>

<div id="mi-imagen">

</div>

<h3>Bienvenido a Enfutbol.co</h3>


<p>Para iniciar a disfrutar de los servicios de enFutbol.co es necesaria Activar tu cuanta a través del siguiente link </p>
<p> <strong><a class="lin" href="{!! $ruta !!}">{!! $ruta !!}</a></strong></p>

<p id="pie">Este e-mail se ha generado automáticamente. Por favor, no conteste a este e-mail.</p>


</body>

</html>
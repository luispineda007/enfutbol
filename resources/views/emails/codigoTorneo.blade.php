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
            margin-top: 50px;
            font-size: 9px;
            color: #989898;
        }
    </style>
</head>
<body>

<div id="mi-imagen">

</div>

<h3>Felicidades:</h3>

<p>Has sido invitado a participar en el torneo <b>{{$torneo}}</b>. Para continuar, es necesario inscribir tu equipo ingresando a nuestra plataforma o haciendo click en el siguiente enlace: </p>
<p> <strong><a class="lin" href="{!! $ruta !!}">{!! $ruta !!}</a></strong></p>
<br>
<p>Posteriormente, ingresa el siguiente codigo <b>{{$codigo}}</b> cuando el sistema te lo solicite, para culminar el proceso de inscripcion.</p>
<br>
<p>Cordial Saludo.</p>
<p><b>Equipo enFutbol.co</b></p>



<p id="pie">Este e-mail se ha generado automáticamente. Por favor, no conteste a este e-mail.</p>


</body>

</html>
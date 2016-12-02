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

<p>Hola <b>{!! $nombres !!}</b>.</p>
<br>
<p>El administrador del sitio <b>"{{$sitio}}"</b> ha cancelado las siguiente reserva:</p>

<p> <b>Cancha: </b> {!! $cancha !!} (Futbol {{$tipo}}) </p>
<p>  <strong>Fecha: </strong>{!! $fecha !!} </p>
<p> <b>Hora: </b>{{$hora}}:00</p>
<br>
<p>Para más información ponte en contacto con el administrador del sitio.</p>


</body>

</html>
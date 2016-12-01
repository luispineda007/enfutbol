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


<p>Ya puedes disfrutar de los servicios que encontraras en enFutbol.co. </p>
<p>Tu usuario de registro es <strong><a class="lin" href="#" onclick="return false;">{!! $user !!}</a></strong>, con el podrás solicitar los token (o permiso) en tus Sitios preferidos para relaizar reservas </p>
<p><strong>Recuerda</strong> actualizar tus datos personales en la sección de perfil, el email que se uso para este registro fue <strong><a class="lin" href="#" onclick="return false;">{!! $email !!}</a></strong> </p>
<p>En caso de dudas o preguntas puede contactar con nosotros.</p>


<p id="pie">Este e-mail se ha generado automáticamente. Por favor, no conteste a este e-mail.</p>


</body>

</html>
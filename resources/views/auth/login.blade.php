<!DOCTYPE html>
<html style="background: url({{URL::to('images/full_image_22.jpg')}}); background-size: cover;" >
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login enFutbol</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  {!!Html::style('css/bootstrap.min.css')!!}
  <!-- Font Awesome -->
  {!!Html::style('css/font-awesome.min.css')!!}
  <!-- Ionicons -->
  {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">--}}
  <!-- Theme style -->
  {!!Html::style('dist/css/AdminLTE.css')!!}
  <!-- iCheck -->
  {!!Html::style('plugins/iCheck/square/blue.css')!!}

  <style>

    .login-page, .register-page {
      background: rgba(210, 214, 222, 0);
    }

    #grade{
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: -1;
      opacity: .7;
      -webkit-backface-visibility: hidden;
      background-color: #A4D792;
      background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zd…AiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjdnNnZykiIC8+PC9zdmc+);
      background-image: -webkit-gradient(linear, 0% 0%, 100% 100%, color-stop(0, #21825c), color-stop(1, #a4d792));
      background-image: -webkit-linear-gradient(top left, #21825c 0%, #a4d792 100%);
      background-image: linear-gradient(to bottom right, #21825c 0%, #a4d792 100%);
      background-image: -ms-linear-gradient(top left, #21825c 0%, #a4d792 100%);


    }

    .login-box{
      z-index: 2000;
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
<!--  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div id="grade">
</div>

<div class="login-box">
  <div class="login-logo">

    <a href="{{route("home")}}"><img src="../images/logo.png" alt="" class="subtext to-animate" style="width: 240px; /*height: 190px;*/"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><b style="font-size:18px; ">Iniciar Sesión</b></p>

    {!!Form::open()!!}
      <div class="form-group has-feedback">
        <input name="user" type="text" class="form-control" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
    <div class="alert alert-danger" id="error" style="display: none">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
      <div class="row">
{{--        <div class="col-xs-7">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>--}}
        <!-- /.col -->

        <div class="col-xs-5">

          <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
        </div>
        <!-- /.col -->
      </div>
    {!!Form::close()!!}


    <div class="box box-default" style="margin-top: 25px;">
      <div class="box-body">

        <a href="{{route("getEmail")}}"><i class="fa fa-key" aria-hidden="true"></i> Olvide mi contraseña</a><br>
        <a href="{{route("registrarJugador")}}" class="text-center"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrarse como Jugador</a>

      </div>
      <!-- /.box-body -->
    </div>






{{--    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>--}}
    <!-- /.social-auth-links -->



  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
{!!Html::script('plugins/jQuery/jquery-2.2.3.min.js')!!}
<!-- Bootstrap 3.3.6 -->
{!!Html::script('bootstrap/js/bootstrap.min.js')!!}
<!-- iCheck -->
{!!Html::script('plugins/iCheck/icheck.min.js')!!}
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    var formulario = $('form');
    formulario.submit(function (e) {
      e.preventDefault();

      $.ajax({
        type:"POST",
        context: document.body,
        url: '{{route('loginModal')}}',
        data:formulario.serialize(),
        success: function(data){
          if (data=="login exitoso") {
            window.location="{{route("administrador")}}";
            //window.location.reload();
          }
          else {
            $("#error").append(data);
            $("#error").css('display','block');

          }
        },
        error: function(data){
          console.log(data);
        }
      });
    });




  });
</script>
</body>
</html>

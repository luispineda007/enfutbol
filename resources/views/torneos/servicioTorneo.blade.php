@extends('layouts.principal')

@section('css')

    <style>

    </style>
@endsection

@section('Pageheader')
    <h1>
        Administración
        <small>Torneos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Torneos</li>
    </ol>
@endsection
@section('content')

    <section id="introduction">
        <h2 class="page-header"><a href="#introduction">Introductión</a></h2>
        <p class="lead">
            En <b>enFutbol.co</b> encontrarás el servicio de crear y administrar tornos, en donde los usuarios registraran a sus equipos
            para poder participar en los torneos, dependiendo de la privacidad del torneo los usuarios enviaran invitaciones para ser aceptadas
            por el administrador del torneo o el administrador le entregara un código único con el que podrá inscribir su equipo al torneo


        </p>
    </section><!-- /#introduction -->


    <!-- ============================================================= -->

    <section id="download">
        <h2 class="page-header"><a href="#download">Tipos de Competición</a></h2>
        <p class="lead">
            AdminLTE can be downloaded in two different versions, each appealing to different skill levels and use case.
        </p>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Todos contra todos </h3>
                        <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>Compiled and ready to use in production. Download this version if you don't want to customize AdminLTE's LESS files.</p>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Eliminacion directa</h3>
                        <span class="label label-danger pull-right"><i class="fa fa-database"></i></span>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>All files including the compiled CSS. Download this version if you plan on customizing the template. <b>Requires a LESS compiler.</b></p>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <pre class="hierarchy bring-up"><code class="language-bash" data-lang="bash">File Hierarchy of the Source Code Package

AdminLTE/
├── dist/
│   ├── CSS/
│   ├── JS
│   ├── img
├── build/
│   ├── less/
│   │   ├── AdminLTE's Less files
│   └── Bootstrap-less/ (Only for reference. No modifications have been made)
│       ├── mixins/
│       ├── variables.less
│       ├── mixins.less
└── plugins/
    ├── All the customized plugins CSS and JS files</code></pre>
    </section>


@endsection


@section('js')

    <script>

    </script>
@endsection
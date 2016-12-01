@extends('layouts.principal')

@section('css')


@endsection
//----end css

@section('content')

    <div class="panel panel-primary">
        <div class="panel-heading">
            Registrar un Usuario
        </div>
        <div class="panel-body">

            {!!Form::open(['id'=>'formUsuario','class'=>'form-horizontal'])!!}

            <div class="col-sm-6">

                <div class="form-group">
                    {!! Form::label('id', 'No. Identificación',['class'=>'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!!Form::text('id',null,['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('nombre', 'Nombres',['class'=>'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!!Form::text('nombre',null,['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('apellido', 'Apellidos',['class'=>'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!!Form::text('apellido',null,['class'=>'form-control'])!!}
                    </div>
                </div>

            </div>
            <div class="col-sm-6">

                <div class="form-group">
                    {!! Form::label('correo', 'E-Mail',['class'=>'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!!Form::email('correo',null,['class'=>'form-control', 'data-email-msg'=>'Formato de correo no valido'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('genero', 'Genero',['class'=>'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!!Form::select('genero', [''=>'Selecionar Genero','M' => 'M', 'F' => 'F'],null ,['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('telefono', 'No. Telefono',['class'=>'col-sm-4 control-label']) !!}

                    <div class="col-sm-8">
                        {!! Form::number('telefono',null,['class'=>'form-control']) !!}

                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-6 col-sm-offset-3 text-center">
                    <div class="form-group">


                        {!! Form::label('Rol', 'rol',['class'=>'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                            {!!Form::select('rol', ["admin"=>"Administrador","profe"=>"Profesor"] ,null ,['class'=>'form-control','id'=>'rol'])!!}
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div class="panel-footer text-right">

            {!! Form::submit('Registrar Usuario',['class'=>'btn btn-primary center-block']) !!}

        </div>

        {!!Form::close()!!}

    </div>

@endsection
//----end content

@section('js')


@endsection
//----end js
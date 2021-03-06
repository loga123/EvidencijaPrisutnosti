@extends('layouts.Osnovno')

@section('content')

<div class="container">
<div class="row">
    @include('errors.session_error_poruke')
    @include('errors.session_poruke')
    @if(Auth::user()->razina_prava==1)
    <div class="col-md-4 col-md-offset-4">
        @elseif(Auth::user()->razina_prava==2)
            <div class="col-md-4 col-md-offset-4" style="margin-top: 10%;">
            @endif
        <div class="panel panel-default panel-login-register">
        <div class="panel-heading text-center">Unos novoga korisnika</div>
        <div class="panel-body">
        {!!  Form::open(['action' => 'UsersController@store']) !!}
         <!--IME-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('ime') ? ' has-error' : '' }}">
                {!! Form::text('ime', null, ['class' => 'col-md-4 form-control','placeholder' =>'Ime']) !!}
                @if ($errors->has('ime'))
                    <span class="help-block">
                    <strong>{{ $errors->first('ime') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <!--PREZIME-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('prezime') ? ' has-error' : '' }}">
                {!! Form::text('prezime', null, ['class' => 'col-md-4 form-control','placeholder' =>'Prezime']) !!}
                @if ($errors->has('prezime'))
                    <span class="help-block">
                    <strong>{{ $errors->first('prezime') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <!--BROJ X-ICE-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('broj_iskaznice') ? ' has-error' : '' }}">
                {!! Form::number('broj_iskaznice', null, ['class' => 'col-md-4 form-control ',
                'placeholder' =>'Broj X-ice']) !!}
                @if ($errors->has('broj_iskaznice'))
                    <span class="help-block">
                    <strong>{{ $errors->first('broj_iskaznice') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <!--E-MAIL-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::email('email', null, ['class' => 'col-md-4 form-control','placeholder' =>'E-mail']) !!}
                @if ($errors->has('email'))
                    <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                @endif
            </div>
        </div>
        <!--LOZINKA-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {!! Form::password('password', ['class' => 'col-md-4 form-control','placeholder' =>'Lozinka']) !!}
                @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <!--PONOVI LOZINKU-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('password_confirmation') ? ' has-error':''}}">
                {!! Form::password('password_confirmation',['class' => 'col-md-4 form-control',
                'placeholder' =>'Ponovite lozinku']) !!}
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <!--RAZINA PRAVA-->
        <div class="row">
            <div class="col-md-10 col-md-offset-1 form-group{{ $errors->has('razina_prava') ? ' has-error' : '' }}">
                @if(Auth::user()->razina_prava==1)
            {{ Form::select('razina_prava', ['1' => 'Administrator','2' => 'Profesor','3' => 'Student'], 3,
            ['class' => 'col-md-4 form-control']) }}
                @elseif(Auth::user()->razina_prava==2)
                    {{ Form::select('razina_prava', ['3' => 'Student'], 3, ['class' => 'col-md-4 form-control']) }}
                @endif
                @if ($errors->has('razina_prava'))
                    <span class="help-block">
                    <strong>{{ $errors->first('razina_prava') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1" style="margin-left: 30%">
                <button type="submit" value="Submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i>Unos korisnika
                </button>
            </div>
        </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
</div>
</div>
@endsection

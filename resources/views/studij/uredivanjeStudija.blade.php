@extends('layouts.Osnovno')

@section('content')

    <div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">

        @if(Auth::user()->razina_prava==1)

        {!! Form::model($studij, ['method'=> 'PATCH', 'action' => ['StudijController@update', $studij->sifra_studija]]) !!}


        <div class="row">

            <div class="col-md-10">

                <h1>Uređivanje "{{ $studij->naziv }}"</h1>

            </div>

        </div>

        <p class="lead">Uredi i spremi Studij, ili <a href="{{ url('admin/studij') }}">povratak na prikaz svih studija.</a></p>
        <hr>

        <div class="row">

            <div class="col-md-9">

                @include('errors.session_error_poruke')
                @include('errors.session_poruke')

            </div>

        </div>

        <div class="row">

            <div class="col-md-9 form-group {{ $errors->has('naziv') ? 'has-error' : ''  }}">


                {!! Form::text('naziv', null, ['class' => 'form-control','placeholder'=>'Naziv studija']) !!}

                @if ($errors->has('naziv'))

                    <span class="help-block">

                        <strong>{{ $errors->first('naziv') }}</strong>

                    </span>

                @endif

            </div>

        </div>

        <div class="row">

            <div class="col-md-9">

                {!! Form::submit('Ažuriraj studij', ['class' => 'btn btn-primary form-control'] ) !!}

            </div>

        </div>

        {!! Form::close() !!}
        @elseif(Auth::user()->razina_prava==2)
            <hr> <hr> <p class="lead">Nemate ovlasti za uređivanje studija, <a href="{{ url('admin/studij') }}">povratak na prikaz svih studija.</a></p>
        @endif

    </div>


@endsection
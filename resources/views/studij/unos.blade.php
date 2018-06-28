@extends('layouts.Osnovno')

@section('content')

<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">

    @if(Auth::user()->razina_prava==1)

    {!!  Form::open(['action' => 'StudijController@store']) !!}

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')

            <h2 class="text-center">Dobrodošli u sučelje za unos studija</h2>

        </div>

    </div>


    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('naziv') ? 'has-error' : ''  }}">



            {!! Form::text('naziv', null, ['class' => 'form-control','placeholder'=>'Naziv studija']) !!}

            @if ($errors->has('naziv'))

                <span class="help-block">

                        <strong>{{ $errors->first('naziv') }}</strong>

                    </span>

            @endif

        </div>

    </div>


    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            {!! Form::submit('Unesi studij', ['class' => 'btn btn-primary form-control'] ) !!}

        </div>

    </div>

    {!! Form::close() !!}

        @elseif(Auth::user()->razina_prava==2)
        <div class="row" style="margin-left: 4%">

            <div class="col-md-9">

                <h2 class="text-center">Nemate ovlast za unos studija. Obratite se administratoru</h2>

            </div>

        </div>
        @endif
</div>
@endsection
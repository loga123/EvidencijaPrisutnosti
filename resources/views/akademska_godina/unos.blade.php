@extends('layouts.Osnovno')

@section('content')

<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">


   {!!  Form::open(['action' => 'AkademskaGodinaController@store']) !!}

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')

            <h2 class="text-center">Dobrodošli u sučelje za unos godine studija</h2>

        </div>

    </div>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('sifra_studija') ? 'has-error' : ''  }}">



            <select class="form-control" name="sifra_studija" id="sifra_studija">


                @foreach($studiji as $studij)

                    <option value="{{$studij->sifra_studija}}" selected="0">{{$studij->naziv}}</option>

                @endforeach


                <option value="0" selected="selected">--Odaberite studij--</option>

            </select>

            @if ($errors->has('sifra_studija'))

                <span class="help-block">

                        <strong>{{ $errors->first('sifra_studija') }}</strong>

                    </span>

            @endif

        </div>

    </div>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('broj') ? 'has-error' : ''  }}">



            {!! Form::text('broj', null, ['class' => 'form-control','placeholder'=>'Godina studija --> npr. 1. GODINA']) !!}

            @if ($errors->has('broj'))

                <span class="help-block">

                        <strong>{{ $errors->first('broj') }}</strong>

                    </span>

            @endif

        </div>

    </div>


    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            {!! Form::submit('Unesi godinu studija', ['class' => 'btn btn-primary form-control'] ) !!}

        </div>

    </div>

    {!! Form::close() !!}


</div>

@endsection
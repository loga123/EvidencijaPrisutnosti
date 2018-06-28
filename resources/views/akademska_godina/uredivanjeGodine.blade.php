@extends('layouts.Osnovno')

@section('content')

    <div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">

        @if(Auth::user()->razina_prava==1)

        {!! Form::model($godina, ['method'=> 'PATCH', 'action' => ['AkademskaGodinaController@update', $godina->sifra_godine]]) !!}


        <div class="row">

            <div class="col-md-10">

                <h1>Uređivanje "{{ $godina->broj }}"</h1>

            </div>

        </div>

        <p class="lead">Uredi i spremi Godinu studija, ili <a href="{{ url('admin/godina_studija') }}">povratak na prikaz svih godina studija.</a></p>
        <hr>

        <div class="row">

            <div class="col-md-9">

                @include('errors.session_error_poruke')
                @include('errors.session_poruke')

            </div>

        </div>

            <div class="row">

                <div class="col-md-9 form-group {{ $errors->has('sifra_studija') ? 'has-error' : ''  }}">

                    <select class="form-control" name="sifra_studija" id="sifra_studija">

                        <option value="0">--Odaberite studij--</option>
                        <option value="{{$nazivStudija->sifra_studija}}" selected="selected">{{ $nazivStudija->naziv }} </option>

                        @foreach($studiji as $studij)

                            <option value="{{$studij->sifra_studija}}">{{$studij->naziv}}</option>

                        @endforeach

                    </select>

                    @if ($errors->has('sifra_studija'))

                        <span class="help-block">

                        <strong>{{ $errors->first('sifra_studija') }}</strong>

                    </span>

                    @endif

                </div>

            </div>

        <div class="row">

            <div class="col-md-9 form-group {{ $errors->has('broj') ? 'has-error' : ''  }}">


                {!! Form::text('broj', null, ['class' => 'form-control','placeholder'=>'Godina studija']) !!}

                @if ($errors->has('broj'))

                    <span class="help-block">

                        <strong>{{ $errors->first('broj') }}</strong>

                    </span>

                @endif

            </div>

        </div>

        <div class="row">

            <div class="col-md-9">

                {!! Form::submit('Ažuriraj godinu studija', ['class' => 'btn btn-primary form-control'] ) !!}

            </div>

        </div>

        {!! Form::close() !!}
        @elseif(Auth::user()->razina_prava==2)
            <hr> <hr> <p class="lead">Nemate ovlasti za uređivanje godine studija, <a href="{{ url('admin/godina_studija') }}">povratak na prikaz svih godina studija.</a></p>
        @endif

    </div>


@endsection
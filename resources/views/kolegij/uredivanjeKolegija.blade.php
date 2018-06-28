@extends('layouts.Osnovno')

<script type="text/javascript">


    function popuniGodine(sifra_studija, sifra_godine){
        var godine = {!! json_encode($godine) !!};
        var i;

        sifra_godine.options.length = 0;

        createOption(sifra_godine, 0, '--Odaberite godinu studija--');

        for(i=0; i<godine.length; i++){
            if(godine[i].sifra_studija == sifra_studija.value){
                createOption(sifra_godine, godine[i].sifra_godine, godine[i].broj);;
            }
        }
    }

    //Create option in Godine select
    function createOption(id_div,value,text){
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        id_div.options.add(opt);
    }

</script>

@section('content')


    <div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px;">

        {!! Form::model($kolegij, ['method'=> 'PATCH', 'action' => ['KolegijController@update', $kolegij->sifra_kolegija]]) !!}


        <div class="row">

            <div class="col-md-10">

                <h1>Uređivanje "{{ $kolegij->naziv }}"</h1>

            </div>

        </div>

        <p class="lead">Uredi i spremi Kolegij, ili <a href="{{ url('admin/kolegij') }}">povratak na prikaz svih kolegija.</a></p>
        <hr>

        <div class="row">

            <div class="col-md-9">

                @include('errors.session_error_poruke')
                @include('errors.session_poruke')

            </div>

        </div>

        <div class="row">

            <div class="col-md-9 form-group {{ $errors->has('sifra_studija') ? 'has-error' : ''  }}">

                <select class="form-control" name="sifra_studija" id="sifra_studija" onchange="popuniGodine(this, document.getElementById('sifra_godine'))">

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

            <div class="col-md-9 form-group {{ $errors->has('sifra_godine') ? 'has-error' : ''  }}">

                <select class="form-control" name="sifra_godine" id="sifra_godine">

                    <option value="0">--Odaberite godinu studija--</option>
                    <option value="{{$nazivGodine->sifra_godine}}" selected="selected">{{ $nazivGodine->broj }} </option>

                    @foreach($godine as $godina)

                        <option value="{{$godina->sifra_godine}}">{{$godina->broj}}</option>

                    @endforeach

                </select>

                @if ($errors->has('sifra_godine'))

                    <span class="help-block">

                        <strong>{{ $errors->first('sifra_godine') }}</strong>

                    </span>

                @endif

            </div>

        </div>

        <div class="row">

            <div class="col-md-9 form-group {{ $errors->has('naziv') ? 'has-error' : ''  }}">


                {!! Form::text('naziv', null, ['class' => 'form-control','placeholder'=>'Naziv kolegija']) !!}

                @if ($errors->has('naziv'))

                    <span class="help-block">

                        <strong>{{ $errors->first('naziv') }}</strong>

                    </span>

                @endif

            </div>

        </div>

        <div class="row">

            <div class="col-md-9 form-group {{ $errors->has('sifra_profesora') ? 'has-error' : ''  }}">



                <select class="form-control" name="sifra_profesora" id="sifra_profesora">

                    @foreach($profesori as $profesor)

                        <option value="{{$profesor->sifra_korisnika}}">{{$profesor->ime}} {{$profesor->prezime}}</option>

                    @endforeach


                        @if($kolegij->sifra_profesora!=0)
                        <option value="0">--Odaberite nositelja kolegija--</option>
                        <option value="{{$kolegij->sifra_profesora}}" selected="selected">{{ $nazivProfesora->ime }} {{ $nazivProfesora->prezime }}</option>
                        @else
                        <option value="0" selected="selected">--Odaberite nositelja kolegija--</option>
                            @endif
                </select>

                @if ($errors->has('sifra_profesora'))

                    <span class="help-block">

                        <strong>{{ $errors->first('sifra_profesora') }}</strong>

                    </span>

                @endif

            </div>

        </div>

        <br><br>

        <div class="row">

            <div class="col-md-9">

                {!! Form::submit('Ažuriraj kolegij', ['class' => 'btn btn-primary form-control'] ) !!}

            </div>

        </div>

        {!! Form::close() !!}


    </div>


@endsection
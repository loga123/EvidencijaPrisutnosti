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

   {!!  Form::open(['action' => 'KolegijController@store']) !!}

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')

            <h2 class="text-center">Dobrodošli u sučelje za unos kolegija</h2>

        </div>

    </div>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('sifra_studija') ? 'has-error' : ''  }}">



            <select class="form-control" name="sifra_studija" id="sifra_studija" onchange="popuniGodine(this, document.getElementById('sifra_godine'))">

                @foreach($studiji as $studij)

                    <option value="{{$studij->sifra_studija}}" selected="0">{{$studij->naziv}}</option>

                @endforeach

                <option value="0" selected="selected">--Odaberite studij --</option>

            </select>

            @if ($errors->has('sifra_studija'))

                <span class="help-block">

                        <strong>{{ $errors->first('sifra_studija') }}</strong>

                    </span>

            @endif

        </div>

    </div>
    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('sifra_godine') ? 'has-error' : ''  }}">



            <select class="form-control" name="sifra_godine" id="sifra_godine" >

                @foreach($godine as $godina)

                    <option value="{{$godina->sifra_godine}}" selected="0">{{$godina->broj}}</option>

                @endforeach

                <option value="0" selected="selected">--Odaberite godinu studija--</option>

            </select>

            @if ($errors->has('sifra_godine'))

                <span class="help-block">

                        <strong>{{ $errors->first('sifra_godine') }}</strong>

                    </span>

            @endif

        </div>

    </div>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('naziv') ? 'has-error' : ''  }}">



            {!! Form::text('naziv', null, ['class' => 'form-control','placeholder'=>'Naziv kolegija']) !!}

            @if ($errors->has('naziv'))

                <span class="help-block">

                        <strong>{{ $errors->first('naziv') }}</strong>

                    </span>

            @endif

        </div>

    </div>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9 form-group {{ $errors->has('sifra_korisnika') ? 'has-error' : ''  }}">



            <select class="form-control" name="sifra_korisnika" id="sifra_korisnika">

                @foreach($profesori as $profesor)

                    <option value="{{$profesor->sifra_korisnika}}" selected="0">{{$profesor->ime}} {{$profesor->prezime}}</option>

                @endforeach

                <option value="0" selected="selected">--Odaberite nositelja kolegija--</option>

            </select>

            @if ($errors->has('sifra_korisnika'))

                <span class="help-block">

                        <strong>{{ $errors->first('sifra_korisnika') }}</strong>

                    </span>

            @endif

        </div>

    </div>

    <br><br>

    <div class="row" style="margin-left: 4%">

        <div class="col-md-9">

            {!! Form::submit('Unesi kolegij', ['class' => 'btn btn-primary form-control'] ) !!}

        </div>

    </div>

    {!! Form::close() !!}

</div>

@endsection
@extends('layouts.Osnovno')


@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


    <div class="row">

        <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')
            <?php $i=0; $j=0;?>


                <h1 class="text-center"><b><a href="{{ url('admin/kolegij/'.$kolegij->sifra_kolegija.'/') }}">{{$kolegij->naziv}}</a></b></h1>

            <p class="lead">Spremi prisutnost studenata, ili <a href="{{ url('evidencija') }}">povratak na prikaz svih evidencija.</a></p>
            <?php
            $originalDateCREATED = ''.$termin->datum.'';

            $datumCREATED = Datetime::createFromFormat('Y-m-d',$originalDateCREATED);
            $datum = $datumCREATED->format('d.m.Y');
            ?>
            <h3 class="text-center"><b>{{$datum}}</b></h3>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-info">
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Broj iskaznice</th>
                            <th>E-mail</th>
                            <th colspan="2">Prisutnost</th>
                        </tr>
                        </thead>
                        <tbody>

                        {!!  Form::open(['action' => 'EvidencijaStudentiController@store']) !!}
                        {{ Form::hidden('sifra_termina',$termin->sifra_termina ) }}
                        @foreach($korisnici as $korisnik)
                            <?php $i++; $j++; ?>
                                <tr>
                                    {{ Form::hidden('sifra_studenta_na_kolegiju['.$i.']',$korisnik->sifra_studenta_na_kolegiju ) }}
                                    <td>{{ $i }}</td>
                                    <td>{{ $korisnik->ime }}</td>
                                    <td>{{ $korisnik->prezime }}</td>
                                    <td>{{ $korisnik->broj_iskaznice }}</td>
                                    <td>{{ $korisnik->email }}</td>
                                    <td>

                                            {!! Form::label('da', 'DA',['class' => 'control-label']) !!}
                                            {{ Form::radio('prisutnost['.$j.']', 1,false, ['class' => 'field']) }}

                                    </td>
                                    <td>
                                            {!! Form::label('ne', 'NE',['class' => 'control-label']) !!}
                                            {{ Form::radio('prisutnost['.$j.']', 0,true,  ['class' => 'field']) }}

                                    </td>

                                </tr>

                        @endforeach

                            </tbody>

                        </table>

                    {!! Form::submit('Potvrdi prisustvo', ['class' => 'btn btn-primary form-control'] ) !!}

                    {!! Form::close() !!}
        </div>

    </div>

@endsection
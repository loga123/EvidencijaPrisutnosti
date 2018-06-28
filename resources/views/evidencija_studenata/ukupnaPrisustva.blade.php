@extends('layouts.Osnovno')

@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<div class="row" >



    <div  class="col-md-6 col-md-offset-3" style="margin-top: 50px;">

        @include('errors.session_error_poruke')
        @include('errors.session_poruke')
        <?php   $i=0;   ?>

        <h1 class="text-center"><b><a href="{{ url('admin/kolegij/'.$kolegij->sifra_kolegija.'/') }}">{{$kolegij->naziv}}</a></b></h1>

            <div class="row">

            <div class="col-md-4 col-md-offset-2">

                <a href="{{ url('evidencija') }}" class="btn btn-info">Prikaz svih evidencija</a>

            </div>

        </div>

        <hr>

        <div class="row">

            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="bg-info">
                    <th>#</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Broj iskaznice</th>
                    <th>E-mail</th>
                    <th colspan="2">Prisustvo</th>
                </tr>
                </thead>
                <tbody>

                @forelse($users as $korisnik)

                    <?php $i++;

                    $brojPrisustva = DB::table('users')
                        ->leftJoin('student_na_kolegiju', 'student_na_kolegiju.sifra_korisnika', '=', 'users.sifra_korisnika')
                        ->leftJoin('evidencija', 'student_na_kolegiju.sifra_studenta_na_kolegiju', '=', 'evidencija.sifra_studenta_na_kolegiju')
                        ->leftJoin('termin', 'evidencija.sifra_termina', '=', 'termin.sifra_termina')
                        ->leftJoin('kolegij', 'termin.sifra_kolegija', '=', 'kolegij.sifra_kolegija')
                        //->where('kolegij.sifra_kolegija', '=', $kolegij->sifra_kolegija)
                        // ->where('evidencija.prisutnost', '=', 1)
                        ->where('student_na_kolegiju.sifra_kolegija', '=', $kolegij->sifra_kolegija)
                        ->where('student_na_kolegiju.sifra_korisnika', '=', $korisnik->sifra_korisnika)
                        ->where('evidencija.prisutnost', '=', 1)
                        ->count();

                    $postotak = ($brojPrisustva/$Brojtermina)*100;

                    ?>

                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $korisnik->ime }}</td>
                        <td>{{ $korisnik->prezime }}</td>
                        <td>{{ $korisnik->broj_iskaznice }}</td>
                        <td>{{ $korisnik->email }}</td>
                        <td > <b>{{$brojPrisustva }}/{{$Brojtermina}}</b> </td>
                        <td>{{ number_format($postotak, 2) }}%</td>
                    </tr>
                    
                @empty
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td> Nema prijavljenih studenata za ovaj kolegij </td>
                        <td>--------</td>
                        <td>--------</td>
                        <td>--------</td>
                        <td><a href="{{ url('evidencija') }}" class="btn btn-primary">Prijavi studente</a></td>
                    </tr>

                @endforelse
                </tbody>

            </table>


        </div>

    </div>

</div>

@endsection
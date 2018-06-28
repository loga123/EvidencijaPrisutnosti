@extends('layouts.Osnovno')


@section('content')


<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


    <div class="row">
        <?php $i=0;  $j=0;?>



        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
            @foreach($studiji as $studij)

                <h1 class="text-center"><b><a href="{{ url('admin/studij/'.$studij->sifra_studija.'/') }}">{{$studij->naziv}}</a></b></h1>

                @foreach($godine as $godina)

                    @if($studij->sifra_studija == $godina->sifra_studija )

                    <h4 class="text-center"><b ><a style="color: #4eadff;" href="{{ url('admin/godina_studija/'.$godina->sifra_godine.'/') }}" >{{$godina->broj}}</a></b></h4>

                        <table class="table table-striped table-bordered table-hover ">
                            <thead>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Naziv</th>
                                <th colspan="1">Akcija</th>
                            </tr>
                            </thead>

                            <tbody>
                    @endif

                    @foreach($kolegiji as $kolegij)

                            @if($godina->sifra_godine == $kolegij->sifra_godine && $studij->sifra_studija==$godina->sifra_studija )

                                <?php $i++;?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                       {{ $kolegij->naziv }}
                                        <br><br>
                                    <a href="{{ url('evidencija/kolegij/'.$kolegij->sifra_kolegija.'/ukupna_prisutnost') }}" class="btn btn-info">Ukupno prisustvo</a>
                                    </td>
                                    <td>

                                        <table class="table table-striped table-bordered table-hover ">
                                            <thead>
                                            <tr class="bg-success">
                                                <th>#</th>
                                                <th>Termin</th>
                                                <th colspan="3">Akcije</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($termini as $termin)

                                                @if($termin->sifra_kolegija == $kolegij->sifra_kolegija)
                                                    <?php
                                                        $j++;
                                                        $originalDateCREATED = ''.$termin->datum.'';

                                                        $datumCREATED = Datetime::createFromFormat('Y-m-d',$originalDateCREATED);
                                                        $datum = $datumCREATED->format('d.m.Y');

                                                    $provjeraKoristenjaTermina = DB::table('evidencija')
                                                        ->leftJoin('termin', 'termin.sifra_termina', '=', 'evidencija.sifra_termina')
                                                        ->where('evidencija.sifra_termina','=',$termin->sifra_termina)
                                                        ->count();
                                                    ?>
                                                    <tr>
                                                        <td>{{ $j }}</td>
                                                        <td>{{ $datum }}</td>
                                                        @if($provjeraKoristenjaTermina != 0)
                                                            <td><a href="{{url('evidencija/termin/'.$termin->sifra_termina.'')}}" class="btn btn-primary">Pregled prisustva</a></td>
                                                            <td><a href="{{url('evidencija/termin/'.$termin->sifra_termina.'/edit')}}" class="btn btn-warning">Uredi prisustvo</a></td>
                                                            <td><a href="{{url('evidencija/termin/'.$termin->sifra_termina.'/unos')}}" class="btn btn-success">Dodaj studente</a></td>
                                                        @else
                                                            <td><a href="{{url('evidencija/termin/'.$termin->sifra_termina.'/unos')}}" class="btn btn-success">Zabilježi prisustvo</a></td>
                                                        @endif
                                                    </tr>

                                                @endif

                                            @endforeach

                                            </tbody>
                                        </table>


                                    </td>
                                   <!-- <td><a href="{{url('evidencija/kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Zabilježi prisustvo</a></td>-->
                                </tr>
                                <?php
                                $j=0;?>
                            @endif
                    @endforeach
                        </tbody>

                    </table>
                @endforeach

            @endforeach

        </div>

    </div>

@endsection
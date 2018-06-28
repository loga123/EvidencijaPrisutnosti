@extends('layouts.Osnovno')

@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<div class="row" >

    <div class="col-md-2"></div>

    <div  class="col-md-4 col-md-offset-2" style="margin-top: 50px;">

        @include('errors.session_error_poruke')
        @include('errors.session_poruke')

        <h3 class="text-center">{{ $godina->broj }}</h3>

        @if(Auth::user()->razina_prava==1)
             <div class="row">

            <div class="col-md-4">

                <a href="{{ url('admin/godina_studija') }}" class="btn btn-info"><i class="fa fa-eye"></i>Prikaz svih godina studija</a>

            </div>

            <div class="col-md-4">

                <a href="{{ url('admin/godina_studija/'.$godina->sifra_godine.'/edit/') }}" class="btn btn-primary"><i class="fa fa-edit"></i>Uređivanje godine studija</a>

            </div>

            <!-- Modal Dialog -->
        @include('layouts.delete_confirm')
        <!-- END Modal Dialog -->

            <div class="col-md-4" style="margin-left: -2px">

              {!!  Form::open(['method' => 'DELETE','action' => ['AkademskaGodinaController@destroy', $godina->sifra_godine]]) !!}

              {{ Form::button('Obrišite godinu studija', ['type' => 'button', 'class' => 'btn btn-danger btn-delete',' data-toggle'=>'modal','data-target'=>'#confirmDelete','data-title'=>'Brisanje godine studija','data-message'=>'Da li ste sigurni da želite obrisati godinu studija: '.$godina->broj.''] )  }}

              {!! Form::close() !!}
            </div>

            <!-- Script -->
            <script type="text/javascript">

                $('#confirmDelete').on('show.bs.modal', function (e) {

                    e.preventDefault();

                    $message = $(e.relatedTarget).attr('data-message');

                    $(this).find('.modal-body p').text($message);

                    $title = $(e.relatedTarget).attr('data-title');

                    $(this).find('.modal-title').text($title);

                    // Pass form reference to modal for submission on yes/ok

                    var form = $(e.relatedTarget).closest('form');

                    $(this).find('.modal-footer #confirm').data('form', form);

                });

                <!-- Form confirm (yes/ok) handler, submits form -->
                $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){

                    $(this).data('form').submit();

                });

            </script>
            <!-- End script -->
        </div><hr>
             <div class="row">
               <h1 class="text-center"><b><a href="{{ url('admin/studij/'.$studij->sifra_studija.'/') }}">{{$studij->naziv}}</a></b></h1>

                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                        <tr class="bg-info">
                            <th>Šifra kolegija</th>
                            <th>Naziv kolegija</th>
                            <th>Nositelj kolegija</th>
                            <th colspan="1">Akcija</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($kolegiji as $kolegij)
                            <?php
                            $nositelj= DB::table('users')
                                ->select('users.ime','users.prezime')
                                ->leftJoin('kolegij', 'kolegij.sifra_profesora', '=', 'users.sifra_korisnika')
                                ->where('kolegij.sifra_kolegija','=',$kolegij->sifra_kolegija)
                                ->first();

                            ?>
                            <tr>
                                <td>{{ $kolegij->sifra_kolegija }}</td>
                                <td>{{ $kolegij->naziv }}</td>
                                @if(!isset($nositelj->ime))
                                    <td>-------------</td>
                                @else
                                    <td>{{ $nositelj->ime }} {{ $nositelj->prezime }}</td>
                                @endif

                                <td><a href="{{url('kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Prikaz</a></td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>



            </div>
        @elseif(Auth::user()->razina_prava==2)
            <div class="row">

                <div class=" col-md-6 col-md-offset-3">

                    <a href="{{ url('admin/godina_studija') }}" class="btn btn-info"><i class="fa fa-eye"></i>Prikaz svih godina studija</a>

                </div>

            </div><hr>
            <div class="row">
                <h1 class="text-center"><b><a href="{{ url('admin/studij/'.$studij->sifra_studija.'/') }}">{{$studij->naziv}}</a></b></h1>




                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-info">
                            <th>Šifra kolegija</th>
                            <th>Naziv kolegija</th>
                            <th>Nositelj kolegija</th>
                            <th colspan="1">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kolegiji as $kolegij)

                            <?php
                            $nositelj= DB::table('users')
                                ->select('users*')
                                ->leftJoin('kolegij', 'kolegij.sifra_profesora', '=', 'users.sifra_profesora')
                                ->where('kolegij.sifra_kolegija','=',$kolegij->sifra_kolegija)
                                ->get();

                            ?>
                                <tr>
                                    <td>{{ $kolegij->sifra_kolegija }}</td>
                                    <td>{{ $kolegij->naziv }}</td>
                                    @if($nositelj->isEmpty())
                                        <td>------------------- </td>
                                    @else
                                        <td>{{ $nositelj->ime }} {{ $nositelj->prezime }}</td>
                                    @endif

                                    <td><a href="{{url('kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Prikaz</a></td>
                                </tr>
                        @endforeach
                        </tbody>

                    </table>

            </div>
        @endif
    </div>

</div>

@endsection
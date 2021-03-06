@extends('layouts.Osnovno')

@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<div class="row" >



    <div  class="col-md-6 col-md-offset-3" style="margin-top: 50px;">

        @include('errors.session_error_poruke')
        @include('errors.session_poruke')
        <?php $originalDateCREATED = ''.$termin->datum.'';

        $datumCREATED = Datetime::createFromFormat('Y-m-d',$originalDateCREATED);
        $datum = $datumCREATED->format('d.m.Y');
         $i=0;
         $brojac=0;
        ?>

        <h1 class="text-center"><b><a href="{{ url('admin/kolegij/'.$kolegij->sifra_kolegija.'/') }}">{{$kolegij->naziv}}</a></b></h1>
        <h3 class="text-center">{{ $datum }}</h3>

        @if(Auth::user()->razina_prava==1)
            <div class="row">

            <div class="col-md-4 col-md-offset-2">


                    <a href="{{ url('evidencija') }}" class="btn btn-info">Prikaz svih termina po kolegiju</a>

                </div>


                <!-- Modal Dialog -->
            @include('layouts.delete_confirm')
            <!-- END Modal Dialog -->

            <div class="col-md-4 col-md-offset-2" style="margin-left: -2px">

                {!! Form::open(['method' => 'DELETE','action' => ['TerminController@destroy', $termin->sifra_termina]]) !!}

                {{ Form::button('Obrišite termin', ['type' => 'button', 'class' => 'btn btn-danger ',' data-toggle'=>'modal','data-target'=>'#confirmDelete','data-title'=>'Brisanje termina','data-message'=>'Da li ste sigurni da želite obrisati termin: '.$termin->datum.''] )  }}

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
        </div>
        @elseif(Auth::user()->razina_prava==2)
            <div class="row">

                <div class="col-md-12 text-center">


                    <a href="{{ url('evidencija') }}" class="btn btn-info"><i class="fa fa-eye"></i>Prikaz svih termina po kolegiju</a>

                </div>

            </div>
        @endif
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
                    <th colspan="1">Prisustvo</th>
                </tr>
                </thead>
                <tbody>


                @forelse($users as $korisnik)

                    <?php $i++; ?>

                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $korisnik->ime }}</td>
                        <td>{{ $korisnik->prezime }}</td>
                        <td>{{ $korisnik->broj_iskaznice }}</td>
                        <td>{{ $korisnik->email }}</td>
                        <td >
                            @if($korisnik->prisutnost==1)
                             <span style="color: #00cc00;"><b>Prisutan</b></span>
                                @else
                                <span style="color: #cc1f00;">Odsutan</span>
                            @endif
                        </td>

                    </tr>
                    
                @empty
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td> Nema prijavljenih studenata za ovaj termin </td>
                        <td>--------</td>
                        <td>--------</td>
                        <td>--------</td>
                        <td><a href="{{url('evidencija/termin/'.$termin->sifra_termina.'/unos')}}" class="btn btn-primary">Prijavi studente</a></td>
                    </tr>

                @endforelse
                </tbody>

            </table>


        </div>

    </div>

</div>

@endsection
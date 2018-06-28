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

        <div class="row">

            <div class="col-md-10">

                <h1>Uređivanje prisutnosti studenata na terminu "{{ $datum }}"</h1>

            </div>

        </div>

        <p class="lead">Uredi i spremi prisutnost studenata, ili <a href="{{ url('evidencija') }}">povratak na prikaz svih evidencija.</a></p>
        <hr>

        <div class="row">

            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="bg-info">
                    <th>#</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>E-mail</th>
                    <th>Broj iskaznice</th>
                    <th>Prisutnost</th>
                    <th colspan="1">Akcija</th>
                </tr>
                </thead>
                <tbody>

                @forelse($users as $korisnik)

                    <?php $i++; ?>



                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $korisnik->ime }}</td>
                        <td>{{ $korisnik->prezime }}</td>
                        <td>{{ $korisnik->email }}</td>
                        <td>{{ $korisnik->broj_iskaznice }}</td>
                        <td >
                            @if($korisnik->prisutnost==1)

                                <span style="color: #00cc00;"><b>Prisutan</b></span>
                            @else
                                <span style="color: #cc1f00;">Odsutan</span>
                            @endif
                        </td>
                        <td>
                            @if($korisnik->prisutnost==1)

                                <!-- Modal Dialog -->
                                    <div class="modal fade" id="confirmDelete{{$brojac}}" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">

                                        <div class="modal-dialog">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                                    <h4 class="modal-title"></h4>

                                                </div>

                                                <div class="modal-body">

                                                    <p></p>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Natrag</button>
                                                    <button type="button" class="btn btn-danger" id="confirm">Obriši</button>


                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- END Modal Dialog -->

                                {!!  Form::open(['method' => 'PATCH','action' => ['EvidencijaStudentiController@update', $termin->sifra_termina]]) !!}
                                {{ Form::hidden('sifra_evidencije', ''.$korisnik->sifra_evidencije.'') }}
                                {{ Form::hidden('sifra_studenta', ''.$korisnik->sifra_korisnika.'') }}
                                {{ Form::hidden('termin', ''.$termin->sifra_termina.'') }}
                                {{ Form::button('Obriši studenta', ['type' => 'button', 'class' => 'btn btn-danger ',' data-toggle'=>'modal','data-target'=>'#confirmDelete'.$brojac.'','data-title'=>'Brisanje korisnika','data-message'=>'Da li ste sigurni da želite obrisati korisnika: "'.$korisnik->ime.' '.$korisnik->prezime.'" s termina prisustva '] )  }}
                                {!!  Form::close() !!}

                            @else

                                <!-- Modal Dialog -->
                                    <div class="modal fade" id="confirmDelete{{$brojac}}" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">

                                        <div class="modal-dialog">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                                    <h4 class="modal-title"></h4>

                                                </div>

                                                <div class="modal-body">

                                                    <p></p>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Natrag</button>
                                                    <button type="button" class="btn btn-primary" id="confirm">Evidentiraj studenta</button>


                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- END Modal Dialog -->

                                {!!  Form::open(['method' => 'DELETE','action' => ['EvidencijaStudentiController@updateOdsustvo', $termin->sifra_termina]]) !!}
                                {{ Form::hidden('sifra_evidencije', ''.$korisnik->sifra_evidencije.'') }}
                                {{ Form::hidden('sifra_studenta', ''.$korisnik->sifra_korisnika.'') }}
                                {{ Form::hidden('termin', ''.$termin->sifra_termina.'') }}
                                {{ Form::button('Evidentiraj studenta', ['type' => 'button', 'class' => 'btn btn-primary ',' data-toggle'=>'modal','data-target'=>'#confirmDelete'.$brojac.'','data-title'=>'Evidentiranje korisnika','data-message'=>'Da li ste sigurni da želite evidentirat korisnika: "'.$korisnik->ime.' '.$korisnik->prezime.'" na termin prisustva '] )  }}
                                {!!  Form::close() !!}
                            @endif

                        </td>
                    </tr>

                    <!-- Script -->
                    <script type="text/javascript">

                        $('#confirmDelete{{$brojac}}').on('show.bs.modal', function (e) {

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
                        $('#confirmDelete{{$brojac}}').find('.modal-footer #confirm').on('click', function(){

                            $(this).data('form').submit();

                        });

                    </script>
                    <!-- End script -->
                <?php $brojac++; ?>
                @empty
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td> Nema prijavljenih studenata za ovaj termin </td>
                        <td>--------</td>
                        <td>--------</td>
                        <td>--------</td>
                    </tr>

                @endforelse
                </tbody>

            </table>


        </div>

    </div>

</div>

@endsection
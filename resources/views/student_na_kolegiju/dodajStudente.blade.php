@extends('layouts.Osnovno')


@section('content')

    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <div class="row">

        <div class="row">

            <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">

                <h1 class="text-center"><b><a href="{{ url('admin/kolegij/'.$kolegij->sifra_kolegija.'/') }}">{{$kolegij->naziv}}</a></b></h1>

            </div>

        </div>

        <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')
            <?php $j=1;$brojac=0; $i=1; ?>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr class="bg-info">
                        <th>#</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Broj iskaznice</th>
                        <th>E-mail</th>
                        <th colspan="2">Akcija</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($studenti_na_kolegiju as $student)

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

                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $student->ime }}</td>
                                <td>{{ $student->prezime }}</td>
                                <td>{{ $student->broj_iskaznice }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    {!! Form::open(['method' => 'DELETE','action' => ['StudentNaKolegijuController@destroy1', $student->sifra_studenta_na_kolegiju]]) !!}

                                    {{ Form::button('Obriši', ['type' => 'button', 'class' => 'btn btn-danger ',' data-toggle'=>'modal','data-target'=>'#confirmDelete'.$brojac.'','data-title'=>'Brisanje korisnika','data-message'=>'Da li ste sigurni da želite obrisati korisnika: "'.$student->ime.' '.$student->prezime.'" sa kolegija "'.$kolegij->naziv.'" '] )  }}

                                    {!! Form::close() !!}
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

                            <?php $brojac++; $i++;?>

                    @endforeach

                        <tr class="bg-info">
                            <td>----</td>
                            <td>-----------</td>
                            <td>-----------</td>
                            <td>-----------</td>
                            <td>-----------</td>
                            <td>-----------</td>

                        </tr>

                    @foreach($korisnici as $student)

                       <?php $ostali = DB::table('users')
                        ->leftJoin('student_na_kolegiju', 'student_na_kolegiju.sifra_korisnika', '=', 'users.sifra_korisnika')
                        ->where('student_na_kolegiju.sifra_korisnika','=',$student->sifra_korisnika)
                        ->where('student_na_kolegiju.sifra_kolegija','=',$kolegij->sifra_kolegija)
                        ->count(); ?>

                       @if($ostali==1)

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
                                        <button type="button" class="btn btn-primary" id="confirm">Dodaj</button>


                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- END Modal Dialog -->

                        <tr class="bg-success">
                            <td class="bg-success">{{ $j }}</td>
                            <td class="bg-success">{{ $student->ime }}</td>
                            <td class="bg-success">{{ $student->prezime }}</td>
                            <td class="bg-success">{{ $student->broj_iskaznice }}</td>
                            <td class="bg-success">{{ $student->email }}</td>
                            <td class="bg-success">
                                {!! Form::open(['method' => 'PATCH','action' => ['StudentNaKolegijuController@postaviStudenta', $student->sifra_korisnika]]) !!}
                                {{ Form::hidden('sifra_kolegija',$kolegij->sifra_kolegija ) }}
                                {{ Form::button('Dodaj', ['type' => 'button', 'class' => 'btn btn-primary ',' data-toggle'=>'modal','data-target'=>'#confirmDelete'.$brojac.'','data-title'=>'Dodavanje korisnika','data-message'=>'Da li ste sigurni da želite unijet korisnika: "'.$student->ime.' '.$student->prezime.'" na kolegij "'.$kolegij->naziv.'" '] )  }}

                                {!! Form::close() !!}
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

                        <?php $brojac++; $j++; ?>
                        @endif

                    @endforeach

                    </tbody>

                </table>

        </div>

    </div>

@endsection
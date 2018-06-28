@extends('layouts.Osnovno')

@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<div class="row" >

    <div class="col-md-2"></div>

    <div  class="col-md-4 col-md-offset-2" style="margin-top: 50px;">

        @include('errors.session_error_poruke')
        @include('errors.session_poruke')

        <h3 class="text-center">{{ $studij->naziv }}</h3>

        @if(Auth::user()->razina_prava==1)
             <div class="row">

            <div class="col-md-4">

                <a href="{{ url('admin/studij') }}" class="btn btn-info"><i class="fa fa-eye"></i>Prikaz svih studija</a>

            </div>

            <div class="col-md-4">

                <a href="{{ url('admin/studij/'.$studij->sifra_studija.'/edit/') }}" class="btn btn-primary"><i class="fa fa-edit"></i>Uređivanje studija</a>

            </div>

            <!-- Modal Dialog -->
        @include('layouts.delete_confirm')
        <!-- END Modal Dialog -->

            <div class="col-md-4" style="margin-left: -2px">

              {!!  Form::open(['method' => 'DELETE','action' => ['StudijController@destroy', $studij->sifra_studija]]) !!}

              {{ Form::button('Obrišite studij', ['type' => 'button', 'class' => 'btn btn-danger btn-delete',' data-toggle'=>'modal','data-target'=>'#confirmDelete','data-title'=>'Brisanje studija','data-message'=>'Da li ste sigurni da želite obrisati studij: '.$studij->naziv.''] )  }}

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

                @foreach($godine as $godina)

                    <h1 class="text-center"><b><a href="{{ url('admin/godina_studija/'.$godina->sifra_godine.'/') }}">{{$godina->broj}}</a></b></h1>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-info">
                            <th>Šifra kolegija</th>
                            <th>Naziv kolegija</th>
                            <th colspan="1">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kolegiji as $kolegij)

                            @if($kolegij->sifra_godine == $godina->sifra_godine)

                                <tr>
                                    <td>{{ $kolegij->sifra_kolegija }}</td>
                                    <td>{{ $kolegij->naziv }}</td>
                                    <td><a href="{{url('kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Prikaz</a></td>

                                </tr>

                            @endif



                        @endforeach

                        </tbody>

                    </table>

                @endforeach


            </div>
        @elseif(Auth::user()->razina_prava==2)
            <div class="row">

                <div class=" col-md-6 col-md-offset-3">

                    <a href="{{ url('admin/studij') }}" class="btn btn-info"><i class="fa fa-eye"></i>Prikaz svih studija</a>

                </div>

            </div><hr>
            <div class="row">

                @foreach($godine as $godina)

                    <h1 class="text-center"><b>{{$godina->broj}}</b></h1>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-info">
                            <th>Šifra kolegija</th>
                            <th>Naziv kolegija</th>
                            <th colspan="1">Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kolegijiProfesora as $kolegij)

                            @if($kolegij->sifra_godine == $godina->sifra_godine)

                                <tr>
                                    <td>{{ $kolegij->sifra_kolegija }}</td>
                                    <td>{{ $kolegij->naziv }}</td>
                                    <td><a href="{{url('kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Prikaz</a></td>

                                </tr>

                            @endif



                        @endforeach

                        </tbody>

                    </table>

                @endforeach


            </div>
        @endif
    </div>

</div>

@endsection
@extends('layouts.Osnovno')


@section('content')

<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<script type="text/javascript">

    function addTable(id_profesora) {
        var kolegiji = {!! json_encode($kolegiji) !!};
        var i;
        var brojac = 0;


        var myTableDiv = document.getElementById("myDynamicTable");

        var table = document.createElement('TABLE');
        table.className = 'table table-striped table-bordered table-hover';

        var tableThead = document.createElement('THEAD');
        table.appendChild(tableThead);

        var tr1 = document.createElement('TR');
        tr1.className = 'bg-info';
        tableThead.appendChild(tr1);


        var th = document.createElement('TH');
        th.appendChild(document.createTextNode("Naziv kolegija"));
        tr1.appendChild(th);

        var th1 = document.createElement('TH');
        th1.colSpan="3";
        th1.appendChild(document.createTextNode("Akcije"));
        tr1.appendChild(th1);

        var tableBody = document.createElement('TBODY');
        table.appendChild(tableBody);

        for(i=0; i<kolegiji.length; i++) {



            if (kolegiji[i].sifra_profesora == id_profesora.value) {

                var div1 = document.createElement('DIV');
                div1.setAttribute('class',"modal fade");
                div1.setAttribute('id',"confirmDelete"+brojac);
                div1.setAttribute('role',"dialog");
                div1.setAttribute('aria-labelledby',"confirmDeleteLabel");
                div1.setAttribute('aria-hidden',"true");

                var div2 = document.createElement('DIV');
                div2.className= "modal-dialog";

                var div3 = document.createElement('DIV');
                div3.className= "modal-content";

                var div4 = document.createElement('DIV');
                div4.className= "modal-header";

                var btnM = document.createElement("button");
                btnM.setAttribute('type',"button");
                btnM.setAttribute('class',"close");
                btnM.setAttribute('data-dismiss',"modal");
                btnM.setAttribute('aria-hidden',"true");
                btnM.appendChild(document.createTextNode('&times;'));

                var h4 = document.createElement("h4");
                h4.setAttribute('class',"modal-title");

                div4.appendChild(btnM);
                div4.appendChild(h4);

                var div5 = document.createElement('DIV');
                div5.className= "modal-body";

                var p = document.createElement('p');
                div5.appendChild(p);

                var div6 = document.createElement("div");
                div6.setAttribute('class',"modal-footer");

                var btnM1 = document.createElement("button");
                btnM1.setAttribute('type',"button");
                btnM1.setAttribute('class',"btn btn-default");
                btnM1.setAttribute('data-dismiss',"modal");
                btnM1.appendChild(document.createTextNode("Natrag"));

                var btnM2 = document.createElement("button");
                btnM2.setAttribute('type',"button");
                btnM2.setAttribute('class',"btn btn-danger");
                btnM2.setAttribute('id',"confirm");
                btnM2.appendChild(document.createTextNode("Obriši"));

                div6.appendChild(btnM1);
                div6.appendChild(btnM2);

                div3.appendChild(div4);
                div3.appendChild(div5);
                div3.appendChild(div6);
                div2.appendChild(div3);
                div1.appendChild(div2);

                var tr = document.createElement('TR');
                tableBody.appendChild(tr);

                var td = document.createElement('TD');
                td.appendChild(document.createTextNode( kolegiji[i].naziv));

                var td1 = document.createElement('TD');
                var a1 = document.createElement('A');
                a1.className = 'btn btn-primary';
                a1.appendChild(document.createTextNode("Prikaz"));
                a1.href = "/kolegij/"+ kolegiji[i].sifra_kolegija;
                td1.appendChild(a1);

                var td2 = document.createElement('TD');
                var a2 = document.createElement('A');
                a2.className = 'btn btn-warning';
                a2.appendChild(document.createTextNode("Uređivanje"));
                a2.href = "/admin/kolegij/"+ kolegiji[i].sifra_kolegija+'/edit';
                td2.appendChild(a2);

                var td3 = document.createElement('TD');


                var f = document.createElement("form");//otvaranje forme
                f.setAttribute('method',"POST");
                f.action.value="/admin/profesor-kolegij/"+kolegiji[i].sifra_kolegija;
                f.acceptCharset = "UTF-8";

                var hidden = document.createElement("input"); //input element token, hidden
                hidden.setAttribute('name',"_method");
                hidden.setAttribute('type',"hidden");
                hidden.setAttribute('value',"DELETE");

                var token = document.createElement("input"); //input element token, hidden
                token.setAttribute('name',"_token");
                token.setAttribute('type',"hidden");
                token.setAttribute('value',{!! json_encode(csrf_token()) !!});

                var btn = document.createElement("button");
                btn.setAttribute('type',"button");
                btn.setAttribute('class',"btn btn-danger");
                btn.setAttribute('data-toggle',"modal");
                btn.setAttribute('data-target',"#confirmdelete");
                btn.setAttribute('data-title',"Brisanje kolegija s liste nositelja");
                btn.setAttribute('data-message',"Da li ste sigurni da želite obrisati kolegij: "+ kolegiji[i].naziv+" iz liste nositelja!");
                btn.appendChild(document.createTextNode("Obriši"));

                f.appendChild(hidden);
                f.appendChild(token);
                f.appendChild(btn);
                td3.appendChild(f);

                tr.appendChild(td);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);

                $('#confirmDelete'+brojac).on('show.bs.modal', function (e) {

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
                $('#confirmDelete'+brojac).find('.modal-footer #confirm').on('click', function(){

                    $(this).data('form').submit();

                });

                brojac++;

            }
        }
        myTableDiv.appendChild(div1);
        myTableDiv.appendChild(table);

    }

</script>

    <div class="row">



        <div class="col-md-6 col-md-offset-3 margin-t-50" >

            @include('errors.session_error_poruke')
            @include('errors.session_poruke')
            <?php $brojac=0; ?>



            <select class="form-control" name="id_profesora" id="id_profesora" onchange="addTable(this, document.getElementById('myDynamicTable'))">

                @foreach($profesori as $profesor)

                    <option value="{{$profesor->sifra_korisnika}}" selected="">{{$profesor->ime}} {{$profesor->prezime}}</option>

                @endforeach

                <option value="0" selected="selected">---Profesor---</option>

            </select>

            <div id="myDynamicTable" ></div>


            @foreach($profesori as $profesor)

                    <h1 class="text-center"><b><a href="{{ url('admin/korisnik/'.$profesor->sifra_korisnika.'/') }}">{{$profesor->ime}} {{$profesor->prezime}}</a></b></h1>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="bg-info">
                            <th>Naziv kolegija</th>
                            <th colspan="3">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>

                @foreach($kolegiji as $kolegij)

                        @if($kolegij->sifra_profesora == $profesor->sifra_korisnika)


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
                            <td>{{ $kolegij->naziv }}</td>
                            <td><a href="{{url('kolegij',$kolegij->sifra_kolegija)}}" class="btn btn-primary">Prikaz</a></td>
                            <td><a href="{{route('kolegij.edit',$kolegij->sifra_kolegija)}}" class="btn btn-warning">Uređivanje</a></td>
                            <td>
                                {!! Form::open(['method' => 'DELETE','action' => ['KolegijController@destroy1', $kolegij->sifra_kolegija]]) !!}

                                {{ Form::button('Obriši', ['type' => 'button', 'class' => 'btn btn-danger ',' data-toggle'=>'modal','data-target'=>'#confirmDelete'.$brojac.'','data-title'=>'Brisanje kolegija s liste nositelja','data-message'=>'Da li ste sigurni da želite obrisati kolegij: '.$kolegij->naziv.' iz liste nositelja "'.$profesor->ime.' '.$profesor->prezime.'"!'] )  }}

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

                        <?php $brojac++; ?>


                        @endif

                @endforeach

                        </tbody>

                    </table>

            @endforeach

        </div>

    </div>



@endsection

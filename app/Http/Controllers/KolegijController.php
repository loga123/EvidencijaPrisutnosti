<?php

namespace App\Http\Controllers;

use App\Kolegij;
use App\StudentNaKolegiju;
use App\User;
use Illuminate\Http\Request;
use DB;
use Session;


class KolegijController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  //auth ako je korisnik prijavljen inače guest da se može bilo tko prijaviti
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kolegiji = DB::table('kolegij')->orderBy('naziv', 'asc')->get();


        return view('kolegij.index',compact('kolegiji'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studiji = DB::table('studij')->orderBy('naziv', 'asc')->get();
        $godine = DB::table('akademska_godina')->orderBy('broj', 'asc')->get();
        $profesori = DB::table('users')->where('razina_prava','=',2)->orderBy('ime', 'asc')->get();

        return view('kolegij.unos',compact('profesori','studiji','godine'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'naziv' => 'required',
            'sifra_studija' => 'required|not_in:0',
            'sifra_godine' => 'required|not_in:0',

        ],[
            //Custom Error poruke
            'naziv.required' => 'Niste unijeli naziv kolegija!',
            'sifra_studija.required' => 'Niste odabrali studij!',
            'sifra_studija.not_in' => 'Niste odabrali studij!',
            'sifra_godine.required' => 'Niste odabrali godinu studija!',
            'sifra_godine.not_in' => 'Niste odabrali godinu studija!',

        ]);

        $provjeraPostojanja = DB::table('kolegij')
            ->leftJoin('akademska_godina', 'akademska_godina.sifra_godine', '=', 'kolegij.sifra_godine')
            ->leftJoin('studij', 'akademska_godina.sifra_studija', '=', 'studij.sifra_studija')
            ->where('kolegij.naziv', '=', $request->naziv)
            ->where('akademska_godina.sifra_godine', '=', $request->sifra_godine)
            ->where('studij.sifra_studija', '=', $request->sifra_studija)
            ->count();

        if($provjeraPostojanja==1){

            Session::flash('flash_message1', 'Uneseni naziv kolegija već postoji za tu akademsku godinu i taj studij!');
            return redirect()->back();
        }

        if($request->get('sifra_korisnika')!=0){

            $kolegij = new Kolegij(array(

                'naziv' => $request->get('naziv'),
                'sifra_profesora' => $request->get('sifra_korisnika'),
                'sifra_godine' => $request->get('sifra_godine'),
            ));

            if($kolegij->save()){

                Session::flash('flash_message', 'Uspješan unos kolegija: "'.$kolegij->naziv.'" ');

                return redirect()->back();

            }else

                Session::flash('flash_message1', 'Kolegij nije spremljen!');

            return redirect()->back();

        }

        else{

            $kolegij = new Kolegij(array(

                'naziv' => $request->get('naziv'),
                'sifra_godine' => $request->get('sifra_godine'),

            ));

            if($kolegij->save()){

                Session::flash('flash_message', 'Uspješan unos kolegija: "'.$kolegij->naziv.'" ');

                return redirect()->back();

            }else

                Session::flash('flash_message1', 'Kolegij nije spremljen!');

            return redirect()->back();


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kolegij  $kolegij
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kolegij = Kolegij::findOrFail($id);

        $korisnici = DB::table('users')->where('razina_prava','=',3)->get();

        $studenti_na_kolegiju = DB::table('student_na_kolegiju')->where('sifra_kolegija','=',$id)->get();

        $profesor = DB::table('users')
            ->select('users.sifra_korisnika','users.ime','users.prezime')
            ->where('sifra_korisnika','=',$kolegij->sifra_profesora)
            ->first();


        return view('kolegij.prikaziKolegijpoID-u',compact('kolegij','profesor','korisnici','studenti_na_kolegiju'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kolegij  $kolegij
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kolegij = Kolegij::findOrFail($id);
        $profesori = DB::table('users')->where('razina_prava','=',2)->orderBy('ime', 'asc')->get();
        $studiji = DB::table('studij')->orderBy('naziv', 'asc')->get();
        $godine = DB::table('akademska_godina')->orderBy('broj', 'asc')->get();


        $nazivProfesora = DB::table('users')
            ->select('users.ime','users.prezime')
            ->join('kolegij', 'users.sifra_korisnika', '=', 'kolegij.sifra_profesora')
            ->where('users.sifra_korisnika', '=', $kolegij->sifra_profesora)
            ->first();

        $nazivStudija = DB::table('studij')
            ->select('studij.*')
            ->join('akademska_godina', 'akademska_godina.sifra_studija', '=', 'studij.sifra_studija')
            ->where('akademska_godina.sifra_godine', '=', $kolegij->sifra_godine)
            ->first();

        $nazivGodine = DB::table('akademska_godina')
            ->select('akademska_godina.*')
            ->where('akademska_godina.sifra_godine', '=', $kolegij->sifra_godine)
            ->first();

        return view('kolegij.uredivanjeKolegija',compact('kolegij','profesori','nazivProfesora','studiji','nazivStudija','godine','nazivGodine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kolegij  $kolegij
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $kolegij = Kolegij::findOrFail($id);

        $this->validate($request,[

            'naziv' => 'required',
            //'sifra_profesora' => 'required|numeric|not_in:0',
            'sifra_studija' => 'required|numeric|not_in:0',
            'sifra_godine' => 'required|numeric|not_in:0',
            'sifra_profesora' => 'required|numeric|not_in:0',



        ],[
            //Custom Error poruke
            'naziv.required' => 'Niste unijeli naziv kolegija!',
            //'sifra_profesora.required' => 'Niste odabrali nositelja kolegija!',
            //'sifra_profesora.not_in' => 'Niste odabrali nositelja kolegija!',
           // 'sifra_profesora.numeric' => 'Vrijednost odabranog nositelja kolegija mora biti u brojčanom formatu!',
            'sifra_studija.required' => 'Niste odabrali studij!',
            'sifra_studija.not_in' => 'Niste odabrali studij!',
            'sifra_studija.numeric' => 'Vrijednost odabranog studija mora biti u brojčanom formatu!',
            'sifra_godine.required' => 'Niste odabrali akademsku godinu!',
            'sifra_godine.not_in' => 'Niste odabrali akademsku godinu!',
             'sifra_godine.numeric' => 'Vrijednost odabrane akademske godine mora biti u brojčanom formatu!',
            'sifra_profesora.required' => 'Niste odabrali nositelja kolegija!',
            'sifra_profesora.not_in' => 'Niste odabrali nositelja kolegija!',
            'sifra_profesora.numeric' => 'Vrijednost odabranog nositelja kolegija mora biti u brojčanom formatu!',
        ]);
        $input = $request->all();

        $provjeraPostojanja = DB::table('kolegij')
            ->leftJoin('akademska_godina', 'akademska_godina.sifra_godine', '=', 'kolegij.sifra_godine')
            ->leftJoin('studij', 'akademska_godina.sifra_studija', '=', 'studij.sifra_studija')
            ->where('kolegij.naziv', '=', $request->naziv)
            ->where('akademska_godina.sifra_godine', '=', $request->sifra_godine)
            ->where('studij.sifra_studija', '=', $request->sifra_studija)
            ->count();

        /*if($provjeraPostojanja==1){

            Session::flash('flash_message1', 'Uneseni naziv kolegija već postoji za tu akademsku godinu i taj studij!');
            return redirect()->back();
        }

        $provjeraKoristenjaFKStudentNaKolegiju = DB::table('student_na_kolegiju')
            ->leftJoin('kolegij', 'student_na_kolegiju.sifra_kolegija', '=', 'kolegij.sifra_kolegija')
            ->where('student_na_kolegiju.sifra_kolegija', '=',$id)
            ->count();



        if($provjeraKoristenjaFKStudentNaKolegiju !=0){


            Session::flash('flash_message1', 'Kolegij "'.$kolegij->naziv.'" ne možete izmijenjiti! Studenti pohađaju taj kolegij!!!');

            return redirect()->back();

        }

*/

        if($kolegij->update($input)){

            Session::flash('flash_message', 'Kolegij "'.$kolegij->naziv.'" je uspješno ažuriran!');

            return redirect()->back();

        }else{

            Session::flash('flash_message1', 'Kolegij nije ažuriran!');

            return redirect()->back();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kolegij  $kolegij
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kolegij = Kolegij::findOrFail($id);

        $provjeraKoristenjaFKStudentNaKolegiju = DB::table('student_na_kolegiju')
            ->leftJoin('kolegij', 'student_na_kolegiju.sifra_kolegija', '=', 'kolegij.sifra_kolegija')
            ->where('student_na_kolegiju.sifra_kolegija', '=',$id)
            ->count();

        if($provjeraKoristenjaFKStudentNaKolegiju !=0){


            Session::flash('flash_message1', 'Kolegij "'.$kolegij->naziv.'" ne možete obrisati! Studenti pohađaju taj kolegij!!!');

            return redirect()->back();

        }

        if($kolegij->delete()){

            Session::flash('flash_message', 'Kolegij uspješno obrisan!');

            return redirect('admin/kolegij');

        }else{

            Session::flash('flash_message1', 'Koelgij nije obrisan!');

            return redirect()->back();

        }
    }


    //PROFEOSRI _ KOLEGIJI
    /**PRIKAZI PROFESORE I NJIHOVE KOLEGIJE*/
    public function index1()
    {
        $kolegiji = Kolegij::all();

        $profesori = DB::table('users')->where('razina_prava','=',2)->orderBy('ime', 'asc')->get();


        return view('kolegij.povezivanjeProfesoraIKolegija.index',compact('kolegiji','profesori'));
    }

    public function create1()
    {
        $kolegiji = DB::table('kolegij')->whereNull('sifra_profesora')->orderBy('naziv','asc')->get();
        $profesori = DB::table('users')->where('razina_prava','=',2)->orderBy('ime', 'asc')->get();

        return view('kolegij.povezivanjeProfesoraIKolegija.unos1',compact('profesori','kolegiji'));

    }

    /**SPREMI NOSITELJA ZA KOLEGIJ*/
    public function store1(Request $request)
    {
        $this->validate($request,[
            'sifra_kolegija' => 'required|not_in:0',
            'sifra_korisnika' => 'required|not_in:0',

        ],[
            //Custom Error poruke
            'sifra_kolegija.required' => 'Niste odabrali kolegij!',
            'sifra_kolegija.not_in' => 'Niste odabrali kolegij!',
            'sifra_korisnika.required' => 'Niste odabrali nositelja kolegija!',
            'sifra_korisnika.not_in' => 'Niste odabrali nositelja kolegija!',

        ]);


        $kolegij = DB::table('kolegij')
            ->where('sifra_kolegija','=', $request->sifra_kolegija)
            ->update(['sifra_profesora' => $request->sifra_korisnika]);

        $profesor = DB::table('users')
            ->select('users.sifra_korisnika','users.ime','users.prezime')
            ->where('sifra_korisnika','=',$request->sifra_korisnika)
            ->first();

        $nazivKolegija = DB::table('kolegij')
            ->select('kolegij.sifra_kolegija','kolegij.naziv')
            ->where('sifra_kolegija','=',$request->sifra_kolegija)
            ->first();

            if($kolegij){

                Session::flash('flash_message', 'Uspješan unos nositelja "'.$profesor->ime.' '.$profesor->prezime.'" za kolegij "'.$nazivKolegija->naziv.'" ');

                return redirect()->back();

            }else

                Session::flash('flash_message1', 'Nositelj nije spremljen!');

            return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kolegij  $kolegij
     * @return \Illuminate\Http\Response
     */
    public function destroy1($id)
    {
        $kolegij = Kolegij::findOrFail($id);
        $sortBy = null;
        $izbrisiNositeljaZaKolegij = DB::table('kolegij')
            ->where('sifra_kolegija','=', $kolegij->sifra_kolegija)
            ->update(['sifra_profesora' => $sortBy]);

        $profesor = DB::table('users')
            ->select('users.sifra_korisnika','users.ime','users.prezime')
            ->where('sifra_korisnika','=',$kolegij->sifra_profesora)
            ->first();


        if($izbrisiNositeljaZaKolegij){

            Session::flash('flash_message', 'Kolegij uspješno obrisan iz liste nositelja "'.$profesor->ime.' '.$profesor->prezime.'"!');

            return redirect('admin/profesor-kolegij');

        }else{

            Session::flash('flash_message1', 'Kolegij nije obrisan!');

            return redirect()->back();

        }
    }


}

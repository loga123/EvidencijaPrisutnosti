<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('kolegij/{id}','KolegijController@show');



Route::get('korisnik/{id}/edit-password','UsersController@edit_password');
Route::post('korisnik/{id}/edit-password','UsersController@update_password');


//Route::group(['middleware' => 'is_admin'], function() {

//});

//ADMINISTRATOR
Route::group(['middleware' => 'is_admin'], function() {

Route::get('admin','UsersController@indexAdmin');
Route::get('admin/profesor-kolegij/create','KolegijController@create1');
Route::get('admin/profesor-kolegij','KolegijController@index1');
Route::post('admin/profesor-kolegij','KolegijController@store1');
Route::delete('admin/profesor-kolegij/{id}','KolegijController@destroy1');

Route::resource('admin/razina-prava', 'RazinaPravaController');
Route::resource('admin/student-kolegij', 'StudentNaKolegijuController',['except' => ['update','edit']]);

});
//ADMINISTRATOR I PROFESOR
Route::group(['middleware' => 'is_admin_is_profesor'], function() {

    Route::get('register', 'Auth\RegisterController@admin');
    Route::get('student-kolegij', 'StudentNaKolegijuController@index1');
    Route::get('evidencija', 'EvidencijaStudentiController@index');
    Route::get('evidencija/termin/{id}/unos','EvidencijaStudentiController@show');
    Route::get('evidencija/termin/{id}','EvidencijaStudentiController@show1');
    Route::get('evidencija/kolegij/{id}/ukupna_prisutnost','EvidencijaStudentiController@show2');
    Route::get('evidencija/termin/{id}/edit','EvidencijaStudentiController@edit');
    Route::post('evidencija/termin','EvidencijaStudentiController@store');
    Route::patch('evidencija/termin/{id}/edit', 'EvidencijaStudentiController@update')->name('updatePrisustvo');
    Route::delete('evidencija/termin/{id}/edit', 'EvidencijaStudentiController@updateOdsustvo')->name('updateOdsustvo');
    Route::delete('student-kolegij/{student_kolegij}','StudentNaKolegijuController@destroy1');


    Route::get('student-kolegij/kolegij/{id}/unos','StudentNaKolegijuController@show1');
    Route::patch('student-kolegij/kolegij/{id}/unos', 'StudentNaKolegijuController@postaviStudenta')->name('postaviStudenta');

   // Route::resource('evidencija1', 'EvidencijaStudentiController',['except' => ['update','edit']]);
    Route::resource('admin/studij', 'StudijController');
    Route::resource('admin/kolegij', 'KolegijController');
    Route::resource('korisnik', 'UsersController',['except' => ['destroy']]);
    Route::resource('korisnik', 'UsersController',['except' => ['destroy']]);
    Route::resource('termin', 'TerminController',['except' => ['update','edit']]);
    Route::resource('admin/godina_studija', 'AkademskaGodinaController');

    Route::delete('korisnik/{id}','UsersController@destroy1');

});

//STUDENT
Route::get('prijava-prisutnosti', 'EvidencijaController@index');
Route::post('prijava-prisutnosti','EvidencijaController@store');
Route::get('moja-prisutnost', 'EvidencijaController@indexPrisutnost');



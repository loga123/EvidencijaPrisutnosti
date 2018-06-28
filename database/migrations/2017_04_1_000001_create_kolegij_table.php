<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKolegijTable extends Migration
{

    public function up()
    {
        Schema::create('kolegij', function(Blueprint $table){
            $table->increments('sifra_kolegija')->unsigned();
            $table->string('naziv', 70);
            $table->integer('sifra_profesora')->nullable()->unsigned();
            $table->timestamps();


            $table->foreign('sifra_profesora')->references('sifra_korisnika')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolegij');
    }
}

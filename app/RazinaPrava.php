<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class RazinaPrava extends Model
{
    public $table = "razina_prava";
    use Notifiable;
    protected $primaryKey = 'sifra_razine';

    protected $fillable = [
        'opis',
    ];

    protected $hidden = [
        'sifra_razine',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abschnitt extends Model
{
    protected $table = "abschnitt";

    public $timestamps = false;

    public function strecke()
    {
        return $this->belongsTo("App\Strecke")->get();
    }

    public function fahrraeder()
    {
        return $this->hasMany("App\Fahrrad")->get();
    }
}

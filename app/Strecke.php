<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Strecke extends Model
{
    protected $table = "strecke";

    public $timestamps = false;

    public function abschnitte()
    {
        return $this->hasMany("App\Abschnitt")->get();
    }
}

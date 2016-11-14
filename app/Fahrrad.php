<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fahrrad extends Model
{
    protected $table = "fahrrad";

    public function fahrer()
    {
        return $this->belongsTo("App\Fahrer")->first();
    }

    public function abschnitt()
    {
        return $this->belongsTo("App\Abschnitt")->get();
    }
}

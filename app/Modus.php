<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modus extends Model
{
    protected $table = "modus";

    public function fahrer()
    {
        return $this->hasOne("App\Fahrer");
    }

    public function fahrrad()
    {
        return $this->hasOne("App\Fahrrad");
    }


    public function getName(){
        return $this->name;
    }
}

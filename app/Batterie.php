<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batterie extends Model
{
    protected $table = "batterie";

    public static function getCurrent(){
        $batterie = Batterie::all()->last();
        return $batterie;
    }
}

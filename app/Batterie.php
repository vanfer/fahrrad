<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Batterie
 * @package App
 */
class Batterie extends Model
{
    /**
     * @var string
     */
    protected $table = "batterie";

    /**
     * @return mixed
     */
    public static function getCurrent(){
        $batterie = Batterie::all()->last();
        return $batterie;
    }
}

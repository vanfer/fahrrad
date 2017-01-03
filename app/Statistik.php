<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    protected $table = "statistik";

    public static function addTeilnehmer()
    {
        $statistik = Statistik::find(1);
        $statistik->teilnehmer++;
        $statistik->save();
    }

    public static function addKilometer($num)
    {
        $statistik = Statistik::find(1);
        $statistik->kilometer += $num;
        $statistik->save();
    }

    public static function addHoehenmeter($num)
    {
        $statistik = Statistik::find(1);
        $statistik->hoehenmeter += $num;
        $statistik->save();
    }

    public static function addEnergie($num)
    {
        $statistik = Statistik::find(1);
        $statistik->energie += $num;
        $statistik->save();
    }

    public static function get(){
        return Statistik::find(1);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    protected $table = "statistik";
    protected $fillable = ["fahrer_id", "modus", "geschwindigkeit", "gesamtleistung", "strecke", "hoehenmeter", "fahrdauer", "vorgang"];


    public function fahrer(){
        return $this->belongsTo("App\Fahrer");
    }

    public static function addEntry(\App\Fahrer $fahrer, \App\Fahrrad $fahrrad){
        Statistik::create([
            "fahrer_id" => $fahrer->id,
            "modus_id" => $fahrer->modus->name,
            "vorgang" => $fahrer->vorgang,
            "geschwindigkeit" => $fahrrad->geschwindigkeit,
            "gesamtleistung" => $fahrrad->istLeistung,
            "strecke" => $fahrrad->strecke,
            "hoehenmeter" => $fahrrad->hoehenmeter,
            "fahrdauer" => time() - $fahrrad->zugeordnet_at,
        ]);
    }

    public static function getTeilnehmerGesamt()
    {

    }

    public static function getKilometerGesamt()
    {

    }

    public static function getHoehenmeterGesamt()
    {

    }

    public static function getEnergieGesamt()
    {

    }
}

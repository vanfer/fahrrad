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
        return Statistik::all()->groupBy('fahrer_id')->count();
    }

    public static function getKilometerGesamt()
    {
        $gesamt = 0;

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            $gesamt += $statistik->last()->strecke;
        }

        return $gesamt;
    }

    public static function getHoehenmeterGesamt()
    {
        $gesamt = 0;

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            $gesamt += $statistik->last()->hoehenmeter;
        }

        return $gesamt;
    }

    public static function getEnergieGesamt()
    {
        $gesamt = 0;
        $gesamtWatt = 0;

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            foreach ($statistik as $s){
                $gesamtWatt += $s["attributes"]["gesamtleistung"];
            }
            $durchschnittWatt = $gesamtWatt / $statistik->count();

            $gesamt += ((($durchschnittWatt * $statistik->last()->fahrdauer) / 60) / 1000);
            $gesamt = number_format((float)$gesamt, 2, '.', '');
        }

        return $gesamt;
    }

    public static function getGesamtStatistik()
    {
        return [
            "teilnehmer"    => Statistik::getTeilnehmerGesamt(),
            "kilometer"     => Statistik::getKilometerGesamt(),
            "hoehenmeter"   => Statistik::getHoehenmeterGesamt(),
            "energie"       => Statistik::getEnergieGesamt()
        ];
    }
}

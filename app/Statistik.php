<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Statistik
 * @package App
 */
class Statistik extends Model
{
    /**
     * @var string
     */
    protected $table = "statistik";
    /**
     * @var array
     */
    protected $fillable = ["fahrer_id", "modus", "geschwindigkeit", "gesamtleistung", "strecke", "hoehenmeter", "fahrdauer", "vorgang"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fahrer(){
        return $this->belongsTo("App\Fahrer");
    }

    /**
     * @param Fahrer $fahrer
     * @param Fahrrad $fahrrad
     */
    public static function addEntry(\App\Fahrer $fahrer, \App\Fahrrad $fahrrad){
        if($fahrrad->istLeistung > 0){
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
    }

    /**
     * @return mixed
     */
    public static function getTeilnehmerGesamt()
    {
        return Statistik::all()->groupBy('fahrer_id')->count();
    }

    /**
     * @return int
     */
    public static function getKilometerGesamt()
    {
        $gesamt = 0;

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            $gesamt += $statistik->last()->strecke;
        }

        return $gesamt;
    }

    /**
     * @return int
     */
    public static function getHoehenmeterGesamt()
    {
        $gesamt = 0;

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            $gesamt += $statistik->last()->hoehenmeter;
        }

        return $gesamt;
    }

    /**
     * @return float|int|string
     */
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

            $gesamt += ((($durchschnittWatt * $statistik->last()->fahrdauer) / 3600) / 1000);
            $gesamt = number_format((float)$gesamt, 2, '.', '');
        }

        return $gesamt;
    }

    /**
     * @return array
     */
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

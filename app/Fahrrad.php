<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fahrrad
 * @package App
 */
class Fahrrad extends Model
{
    /**
     * @var string
     */
    protected $table = "fahrrad";
    /**
     * @var array
     */
    protected $touches = ['fahrer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fahrer()
    {
        return $this->belongsTo("App\Fahrer");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modus()
    {
        return $this->belongsTo("App\Modus");
    }

    /**
     * @return mixed
     */
    public function modusName()
    {
        return Modus::whereId($this->modus_id)->pluck("name")->first();
    }


    /**
     * @return bool
     */
    public function aktiv()
    {
        return $this->fahrer_id != 0;
    }

    /**
     * @return string
     */
    public function getFahrerName()
    {
        $fahrer = Fahrer::where("id", $this->fahrer_id)->first();
        if($fahrer){
            return $fahrer->name;
        }

        return "-";
    }

    /**
     * @return int
     */
    public function getFahrerID()
    {
        $fahrer = Fahrer::where("id", $this->fahrer_id)->first();
        if($fahrer){
            return $fahrer->id;
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function abschnitt()
    {
        return $this->belongsTo("App\Abschnitt")->get();
    }


    /**
     *
     */
    public function resetData()
    {
        $this->abschnitt_id = null;
        $this->geschwindigkeit = 0;
        $this->istLeistung = 0;
        $this->sollLeistung = null;
        $this->sollDrehmoment = null;
        $this->strecke = 0;
        $this->hoehenmeter = 0;
    }
}

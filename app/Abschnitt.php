<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Abschnitt
 * @package App
 */
class Abschnitt extends Model
{
    /**
     * @var string
     */
    protected $table = "abschnitt";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function strecke()
    {
        return $this->belongsTo("App\Strecke")->get();
    }

    /**
     * @return mixed
     */
    public function fahrraeder()
    {
        return $this->hasMany("App\Fahrrad")->get();
    }
}

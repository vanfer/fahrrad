<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Strecke
 * @package App
 */
class Strecke extends Model
{
    /**
     * @var string
     */
    protected $table = "strecke";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function abschnitte()
    {
        return $this->hasMany("App\Abschnitt")->get();
    }
}

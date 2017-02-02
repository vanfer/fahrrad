<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Modus
 * @package App
 */
class Modus extends Model
{
    /**
     * @var string
     */
    protected $table = "modus";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fahrer()
    {
        return $this->hasOne("App\Fahrer");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fahrrad()
    {
        return $this->hasOne("App\Fahrrad");
    }


    /**
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }
}

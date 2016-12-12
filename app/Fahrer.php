<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fahrer extends Authenticatable
{
    use Notifiable;

    protected $table = "fahrer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'groesse', 'gewicht'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function fahrrad()
    {
        return $this->hasOne("App\Fahrrad");
    }

    public function modus()
    {
        return $this->belongsTo("App\Modus");
    }

    public function modusName()
    {
        return Modus::whereId($this->modus_id)->pluck("name")->first();
    }
}

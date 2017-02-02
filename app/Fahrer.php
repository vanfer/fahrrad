<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Fahrer
 * @package App
 */
class Fahrer extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = "fahrer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'groesse', 'gewicht', 'vorgang'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fahrrad()
    {
        return $this->hasOne("App\Fahrrad");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistik(){
        return $this->hasMany("App\Statistik");
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
}

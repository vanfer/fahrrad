<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fahrrad extends Model
{
    protected $table = "fahrrad";

    public function fahrer()
    {
        return $this->belongsTo("App\Fahrer")->get();
    }

    public function aktiv()
    {
        return $this->fahrer_id != 0;
    }

    public function getFahrerName()
    {
        $fahrer = Fahrer::where("id", $this->fahrer_id)->first();
        if($fahrer){
            return $fahrer->name;
        }

        return "-";
    }

    public function getFahrerID()
    {
        $fahrer = Fahrer::where("id", $this->fahrer_id)->first();
        if($fahrer){
            return $fahrer->id;
        }

        return 0;
    }

    public function abschnitt()
    {
        return $this->belongsTo("App\Abschnitt")->get();
    }
}

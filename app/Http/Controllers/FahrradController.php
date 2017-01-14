<?php

namespace App\Http\Controllers;

use App\Fahrrad;
use App\Modus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FahrradController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  \App\Fahrrad $fahrrad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Fahrrad $fahrrad)
    {
        if($request->has("modus_id")){
            $fahrrad->resetData();

            $modus_id = Input::get("modus_id");
            $fahrrad->modus_id = $modus_id;

            if($modus_id != 1){ // Nicht Strecke
                if($request->has("modus_value")){
                    $modus_value = Input::get("modus_value");
                }else{
                    $modus_value = 200; // Standardwert
                }

                if($modus_id == 2){ // Drehmoment
                    $fahrrad->sollLeistung = null;
                    $fahrrad->sollDrehmoment = $modus_value;
                }elseif($modus_id == 3){ // Leistung
                    $fahrrad->sollDrehmoment = null;
                    $fahrrad->sollLeistung = $modus_value;
                }
            }
        }

        // Eine Strecke hat für jeden Abschnitt verschiedene Drehmomente
        if($request->has("strecke_update_drehmoment")){
            $fahrrad->sollDrehmoment = Input::get("strecke_update_drehmoment");
        }

        $fahrrad->touch();
        $fahrrad->save();

        return $fahrrad;
    }

    public function zuordnungHerstellen(Request $request, \App\Fahrrad $fahrrad, \App\Fahrer $fahrer)
    {
        $fahrer_fahrrad = Fahrrad::whereFahrerId($fahrer->id)->first();
        if($fahrrad->fahrer_id == null && !$fahrer_fahrrad){

            if(Input::has("modus_id")){
                $fahrrad->modus_id = Input::get("modus_id");
            }

            $fahrrad->strecke = 0;
            $fahrrad->fahrer_id = $fahrer->id;
            $fahrrad->zugeordnet_at = time();
            $fahrrad->touch();

            $fahrrad->save();

            return response()->json([
                "fahrrad" => $fahrrad,
                "fahrer" => $fahrer,
                "modi" => Modus::all()
            ], 200);
        }else{
            return response()->json(["msg" => "wird schon benutzt"], 400);
        }
    }

    public function zuordnungLoeschen(\App\Fahrrad $fahrrad)
    {
        $fahrrad->touch();
        $fahrrad->fahrer()->touch();

        $fahrrad->fahrer_id = null;
        $fahrrad->modus_id = 1;
        $fahrrad->abschnitt_id = null;

        $fahrrad->save();

        if($fahrrad->fahrer_id == null){
            return response()->json(["msg" => "ok"], 200);
        }

        return response()->json(["msg" => "Error"], 400);
    }

    // Gibt die Daten zu allen Fahrrädern, inkl. Modi und Fahrerinformationen zurück
    public function getData()
    {
        return response()->json([
            "data" => [
                "fahrrad" => Fahrrad::with("modus")->with("fahrer")->get()
            ]
        ], 200);
    }
}

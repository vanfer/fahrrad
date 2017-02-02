<?php

namespace App\Http\Controllers;

use App\Fahrer;
use App\Fahrrad;
use App\Modus;
use App\Statistik;
use App\StatistikMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class FahrradController
 * @package App\Http\Controllers
 */
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

    /**
     * @param Request $request
     * @param $fahrrad_id
     * @param $fahrer_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function zuordnungHerstellen(Request $request, $fahrrad_id, $fahrer_id)
    {
        $fahrrad = Fahrrad::whereId($fahrrad_id)->first();
        if(!$fahrrad){
            return response()->json(["msg" => "Fahrrad nicht gefunden", "err" => 3], 200);
        }

        $fahrer = Fahrer::whereId($fahrer_id)->first();
        if(!$fahrer){
            return response()->json(["msg" => "Fahrer nicht gefunden", "err" => 4], 200);
        }

        $fahrer_fahrrad = Fahrrad::whereFahrerId($fahrer->id)->first();
        if($fahrer_fahrrad){
            return response()->json(["msg" => "Fahrer schon zugeordnet", "err" => 1], 200);
        }else{
            if($fahrrad->fahrer_id == null){

                if(Input::has("modus_id")){
                    $fahrrad->modus_id = Input::get("modus_id");
                }

                $fahrer->vorgang = str_random(20);
                $fahrer->touch();
                $fahrer->save();

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
                return response()->json(["msg" => "Fahrrad ist besetzt", "err" => 2], 200);
            }
        }
    }

    /**
     * @param Fahrrad $fahrrad
     * @return \Illuminate\Http\JsonResponse
     */
    public function zuordnungLoeschen(\App\Fahrrad $fahrrad)
    {
        $fahrer = Fahrer::whereId($fahrrad->fahrer_id)->first();
        if($fahrer){
            Statistik::addEntry($fahrer, $fahrrad);

            $email_sent = false;
            if(!empty($fahrer->email)){
                if(StatistikMail::sendMail($fahrer)){
                    $email_sent = true;
                }
            }

            // Reset
            $fahrrad->fahrer_id = null;
            $fahrrad->zugeordnet_at = null;
            $fahrrad->modus_id = 1;
            $fahrrad->resetData();

            $fahrer->vorgang = null;

            // Update
            $fahrrad->touch();
            $fahrrad->save();

            $fahrer->touch();
            $fahrer->save();

            // Return success
            if($fahrrad->fahrer_id == null){
                return response()->json(["msg" => "ok", "email" => $email_sent], 200);
            }
        }

        return response()->json(["msg" => "Error"], 400);
    }

    /**
     * Gibt die Daten zu allen Fahrrädern, inkl. Modi und Fahrerinformationen zurück
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return response()->json([ "data" => ["fahrrad" => Fahrrad::with("modus")->with("fahrer")->get()] ], 200);
    }
}

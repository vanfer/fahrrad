<?php

namespace App\Http\Controllers;

use App\Abschnitt;
use App\Batterie;
use App\Fahrer;
use App\Fahrrad;
use App\Statistik;
use App\Strecke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCentral()
    {
        return view('central.index')->with("fahrraeder", Fahrrad::all());
    }

    // Fahrer wechselt den Streckenabschnitt
    // Update von fahrrad.abschnitt_id / fahrrad.sollDrehmoment (abhängig von fahrer.gewicht und fahrer.goresse)
    // Update und Berechnung der zurückgelegten Hoehenmeter im Abschnitt
    /**
     * @param Request $request
     */
    public function setAbschnitt(Request $request)
    {
        $this->validate($request, [
            "fahrrad_id" => "required",
            "abschnitt_id" => "required"
        ]);

        $fahrrad = Fahrrad::whereId(Input::get("fahrrad_id"))->first();
        if($fahrrad && $fahrrad->modus_id == 1){
            $fahrer = Fahrer::whereId($fahrrad->fahrer_id)->first();

            Statistik::addEntry($fahrer, $fahrrad);

            $abschnitt_id      = Input::get("abschnitt_id");
            $abschnitt         = Abschnitt::whereId($abschnitt_id)->first();
            $abschnitt_folgend = Abschnitt::whereId($abschnitt_id+1)->first();
            $abschnitt_zuletzt = Abschnitt::whereId($abschnitt_id-1)->first();

            if(!empty($abschnitt) && !empty($abschnitt_folgend)){
                if(!empty($abschnitt_zuletzt)){
                    $hoehenDifferenz = $abschnitt->hoehe - $abschnitt_zuletzt->hoehe;
                    if($hoehenDifferenz > 0){
                        $fahrrad->hoehenmeter += $hoehenDifferenz;
                    }
                }

                $fahrrad->abschnitt_id = $abschnitt->id;

                // Berechnen von sollDrehmoment
                $h = $abschnitt_folgend->hoehe - $abschnitt->hoehe;
                $l = $abschnitt->laenge;

                // Steigung des Abschnitts in Prozent
                $prozent = intval($h / $l * 100);

                //$a = atan($prozent / 100);

                $aFahrer = $fahrer->groesse * 0.28; // 0.28 Korrekturfaktor (http://www.veloagenda.ch/Velophysik/luftwid.htm)
                $kSteigung = sin(atan($prozent / 100));
                $mHinterrad = ($fahrer->gewicht + 15) * 9.81 * ($kSteigung + 0.01) + (0.5 * $aFahrer) * 0.55 * 1.2 * (($fahrrad->geschwindigkeit / 3.6) * ($fahrrad->geschwindigkeit / 3.6));
                $mRad = (2.1 / (2 * pi())) * $mHinterrad;
                $mPed = $mRad;

                $fahrrad->sollDrehmoment = intval($mPed);

                $fahrrad->touch();
                $fahrrad->save();
            }
        }
    }

    /**
     * @param Strecke $strecke
     * @return array
     */
    public function strecke(\App\Strecke $strecke)
    {
        return ["strecke" => [ "name" => $strecke->name, "abschnitte" => $strecke->abschnitte()]];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function strecken()
    {
        return Strecke::all();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fahrerstrecke(){
        $fahrraeder = Fahrrad::where("fahrer_id", "<>", null)->get();
        $result = [];

        foreach ($fahrraeder as $fahrrad){
            $result[] = [
                "id" => $fahrrad->getFahrerID(),
                "name" => $fahrrad->getFahrerName(),
                "strecke" => $fahrrad->strecke
            ];
        }

        return response()->json(["fahrerstrecke" => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function leistung()
    {
        $fahrraeder = Fahrrad::where("fahrer_id", "<>", null)->get();
        $result = [];

        foreach ($fahrraeder as $fahrrad){
            $result[] = [
                "id" => $fahrrad->getFahrerID(),
                "name" => $fahrrad->getFahrerName(),
                "istLeistung" => $fahrrad->istLeistung
            ];
        }

        return response()->json(["fahrerleistung" => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistik()
    {
        return response()->json([
            "statistik" => Statistik::getGesamtStatistik()
        ], 200);
    }

    /**
     * @param Request $request
     */
    public function statistikUpdate(Request $request)
    {
        $fahrraeder = Fahrrad::all();

        foreach($fahrraeder as $fahrrad){
            if($fahrrad->fahrer_id != null){
                $fahrer = Fahrer::whereId($fahrrad->fahrer_id)->first();
                Statistik::addEntry($fahrer, $fahrrad);
            }
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batterie()
    {
        return response()->json([
            "batterie" => Batterie::getCurrent()
        ], 200);
    }

    /**
     * @return array
     */
    public function highscore(){
        $highscoreListe = [];

        $statistiken = Statistik::all()->groupBy('vorgang');

        foreach ($statistiken as $statistik){
            $gesamtWatt = 0;
            foreach ($statistik as $s){
                $gesamtWatt += $s["attributes"]["gesamtleistung"];
            }

            $gesamtWh = (((($gesamtWatt / $statistik->count()) * $statistik->last()->fahrdauer) / 60));
            $gesamtWh = number_format((float)$gesamtWh, 2, '.', '');

            $fahrer_name = Fahrer::whereId($statistik[0]->fahrer_id)->first()->name;
            array_push($highscoreListe, [$fahrer_name, $gesamtWh]);
        }

        usort($highscoreListe, function($a, $b) {
            return $b[1] - $a[1];
        });

        $resultArray = [];

        if(isset($highscoreListe[0])){
            array_push($resultArray, $highscoreListe[0]);
        }
        if(isset($highscoreListe[1])){
            array_push($resultArray, $highscoreListe[1]);
        }
        if(isset($highscoreListe[2])){
            array_push($resultArray, $highscoreListe[2]);
        }

        return $resultArray;
    }
}

<?php

namespace App\Http\Controllers;

use App\Abschnitt;
use App\Fahrer;
use App\Fahrrad;
use App\Strecke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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

    public function setData(Request $request)
    {
        $v = Validator::make($request->all(), [
            "ip" => "required",
            "strecke" => "required|numeric",
            "geschwindigkeit" => "required|numeric",
            "istLeistung" => "required|numeric",
        ]);

        if ($v->fails()) {
            return response()->json(["msg" => "Validation Error", "input" => Input::all()], 400);
        }

        $fahrrad = Fahrrad::where("ip", $request->input("ip"))->first();

        if($fahrrad){
            $fahrrad->strecke = $fahrrad->strecke + $request->input("strecke");
            $fahrrad->geschwindigkeit = $request->input("geschwindigkeit");
            $fahrrad->istLeistung = $request->input("istLeistung");
            $fahrrad->save();
            $fahrrad->touch();

            return response()->json(null, 204);
        }
        else{
            return response()->json(["msg" => "Not Found"], 404);
        }
    }

    public function getData()
    {
        return response()->json([
            "data" => [
                "fahrrad" => Fahrrad::with("modus")->with("fahrer")->get()
            ]
        ], 200);
    }

    public function strecke(\App\Strecke $strecke)
    {
        return ["strecke" => [ "name" => $strecke->name, "abschnitte" => $strecke->abschnitte()]];
    }

    public function strecken()
    {
        return Strecke::all();
    }

    public function leistung()
    {
        $fahrraeder = Fahrrad::where("fahrer_id", "<>", null)->get();
        $result = [];

        foreach ($fahrraeder as $fahrrad){
            $result[] = [
                "id" => $fahrrad->getFahrerID(),
                "name" => $fahrrad->getFahrerName(),
                "istLeistung" => $fahrrad->istLeistung,
            ];
        }

        return response()->json(["fahrerleistung" => $result], 200);
    }


}

<?php

namespace App\Http\Controllers;

use App\Abschnitt;
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
    public function index()
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
            $fahrrad->strecke = $request->input("strecke");
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
        return ["fahrrad" => Fahrrad::all()];
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
        $fahrraeder = Fahrrad::all();
        $result = null;

        foreach ($fahrraeder as $fahrrad){
            if($fahrrad->fahrer()){
                $result[] = [
                    "id" => $fahrrad->fahrer()->id,
                    "name" => $fahrrad->fahrer()->name,
                    "istLeistung" => $fahrrad->istLeistung,
                ];
            }
        }

        return response()->json(["fahrerleistung" => $result], 200);
    }
}

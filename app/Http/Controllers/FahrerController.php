<?php

namespace App\Http\Controllers;

use App\Fahrer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FahrerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required"
        ]);

        $fahrer = Fahrer::create([
            "name" => Input::get("name")
        ]);

        $id = $fahrer->id;

        if($request->has("email")){
            $fahrer->email = Input::get("email");
        }

        if($request->has("gewicht")){
            $fahrer->gewicht = Input::get("gewicht");
        }

        if($request->has("groesse")){
            $fahrer->groesse = Input::get("groesse");
        }

        $fahrer->save();
        $fahrer->touch();

        return Fahrer::find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  \App\Fahrer $fahrer
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Fahrer $fahrer)
    {
        return $fahrer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  \App\Fahrer $fahrer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Fahrer $fahrer)
    {
        if($request->has("name")){
            $fahrer->name = Input::get("name");
        }

        if($request->has("email")){
            if(Input::get("email") == "_"){
                $fahrer->email = null;
            }else{
                $fahrer->email = Input::get("email");
            }
        }

        if($request->has("gewicht")){
            $fahrer->gewicht = Input::get("gewicht");
        }

        if($request->has("groesse")){
            $fahrer->groesse = Input::get("groesse");
        }

        if($request->has("modus_id")){
            $fahrer->modus_id = Input::get("modus_id");
        }

        $fahrer->save();
        $fahrer->touch();

        return $fahrer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \App\Fahrer $fahrer
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Fahrer $fahrer)
    {
        $fahrradId = $fahrer->fahrrad()->pluck("id");

        $fahrer->delete();

        if(!Fahrer::find($fahrer->id)){
            if($fahrradId){ // Beim löschen die Fahrrad ID mitgeben für Interface Update
                return response()->json(["msg" => "ok", "id" => $fahrradId[0]], 200);
            }
            return response()->json(["msg" => "ok"], 200);
        }

        return response()->json(["msg" => "error"], 400);
    }
}

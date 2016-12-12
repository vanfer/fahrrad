<?php

namespace App\Http\Controllers;

use App\Fahrrad;
use App\Modus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FahrradController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  \App\Fahrrad $fahrrad
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Fahrrad $fahrrad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \App\Fahrrad $fahrrad
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Fahrrad $fahrrad)
    {
        //
    }

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
            $fahrrad->modus_id = Input::get("modus_id");
        }

        $fahrrad->touch();
        $fahrrad->save();

        return $fahrrad;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \App\Fahrrad $fahrrad
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Fahrrad $fahrrad)
    {
        //
    }

    public function zuordnungHerstellen(Request $request, \App\Fahrrad $fahrrad, \App\Fahrer $fahrer)
    {
        $fahrer_fahrrad = Fahrrad::whereFahrerId($fahrer->id)->first();
        if($fahrrad->fahrer_id == null && !$fahrer_fahrrad){

            if(Input::has("modus_id")){
                $fahrrad->modus_id = Input::get("modus_id");
            }

            $fahrrad->fahrer_id = $fahrer->id;
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

        $fahrrad->save();

        if($fahrrad->fahrer_id == null){
            return response()->json(["msg" => "ok"], 200);
        }

        return response()->json(["msg" => "Error"], 400);
    }
}

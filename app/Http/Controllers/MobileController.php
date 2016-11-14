<?php

namespace App\Http\Controllers;

use App\Fahrrad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $fahrrad = Fahrrad::where("fahrer_id", Auth::user()->id)->first();
        if($fahrrad){
            return view('mobile.index')->with("fahrrad", $fahrrad);
        }else{
            return view('mobile.index')->withErrors("fahrrad", "Fehler");
        }
    }
}

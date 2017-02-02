<?php

namespace App\Http\Controllers;

use App\Fahrrad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class MobileController
 * @package App\Http\Controllers
 */
class MobileController extends Controller
{
    /**
     * MobileController constructor.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * @return $this
     */
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

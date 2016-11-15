<?php

namespace App\Http\Controllers;

use App\Fahrer;
use App\Fahrrad;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index()
    {
        return view("auth.login");
    }


    public function logout(Request $request){
        Auth::logout();
        return redirect()->intended($this->redirectTo);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            "name" => 'required',
            "fahrrad" => 'required|numeric',
        ]);

        $name = $request->input("name");
        $email = $request->input("email");
        $groesse = $request->input("groesse");
        $gewicht = $request->input("gewicht");

        $fahrer = Fahrer::where("name", $name)->first();
        if($fahrer){ // Fahrer existiert bereits, einloggen und zuordnen
            if($request->has("email")){
                if($fahrer->email == $email){
                    $this->tryLogin($request, $fahrer);
                }
            }else{ // Kein einzigartiger Name
                return view("auth.login")
                    ->with("err_name", "Name schon vergeben! Bist du ".$name."? Gib deine E-Mail an um dich erneut anzumelden");
            }
        }else{ // Neuen Fahrer anlegen und zuordnen
            $fahrer = new Fahrer();
            $fahrer->name = $name;
            if($request->has("email")){
                $fahrer->email = $email;
            }
            if($request->has("groesse")){
                $fahrer->groesse = $groesse;
            }
            if($request->has("gewicht")){
                $fahrer->gewicht = $gewicht;
            }
            $fahrer->save();
            $fahrer->touch();

            return $this->tryLogin($request, $fahrer);
        }
    }

    private function tryLogin(Request $request, Fahrer $fahrer)
    {
        $fahrrad = Fahrrad::where("id", $request->input("fahrrad"))->first();
        if($fahrrad->aktiv() == false){

            $fahrrad->fahrer_id = $fahrer->id;
            $fahrrad->save();
            $fahrrad->touch();

            Auth::login($fahrer, true);

            return redirect()->intended($this->redirectTo);
        }

        return view("auth.login")
            ->withInput($request->input()->all())
            ->with("err_fahhrad", "Fahrrad schon besetzt");
    }
}

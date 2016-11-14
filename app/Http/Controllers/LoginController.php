<?php

namespace App\Http\Controllers;

use App\Fahrer;
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
        return redirect()->to($this->redirectTo);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            "name" => 'required',
        ]);

        $name = $request->input("name");
        $email = $request->input("email");

        $fahrer = Fahrer::where("name", $name)->first();
        if($fahrer){ // Fahrer existiert bereits
            if($request->has("email")){
                if($fahrer->email == $email){
                    Auth::login($fahrer, true);
                }
                return redirect()->to($this->redirectTo);
            }else{ // Kein einzigartiger Name
                return view("auth.login")
                    ->with("err_name", "Name schon vergeben")
                    ->with("err_msg", "Bist du ".$name."? Gib deine E-Mail an um dich erneut anzumelden");
            }
        }else{
            $fahrer = new Fahrer();
            $fahrer->name = $name;
            if($request->has("email")){
                $fahrer->email = $email;
            }
            $fahrer->save();
            $fahrer->touch();

            Auth::login($fahrer, true);

            return redirect()->to($this->redirectTo);
        }
    }
}

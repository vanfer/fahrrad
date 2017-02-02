<?php

namespace App\Http\Controllers;

use App\Fahrer;
use App\Fahrrad;
use App\Http\Middleware\Admin;
use App\Modus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use League\Flysystem\Exception;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * @var string
     */
    protected $admin_password = "test";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index')
            ->with("fahrer", Fahrer::all())
            ->with("modi", Modus::all())
            ->with("fahrraeder", Fahrrad::all());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view("admin.login");
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function login(Request $request)
    {
        if($request->password == $this->admin_password){
            return redirect("admin")->cookie('admin', '1', 3600);
        }
        return redirect("admin/login")
            ->withErrors(["password" => ('Falsches Passwort')]);
    }

    /**
     * @return $this
     */
    public function logout()
    {
        return redirect("admin")->cookie('admin', '1', -1);
    }
}

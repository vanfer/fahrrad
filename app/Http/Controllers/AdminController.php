<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use League\Flysystem\Exception;

class AdminController extends Controller
{
    protected $admin_password = "test";

    public function index()
    {
        return view("admin.index");
    }

    public function getLogin()
    {
        return view("admin.login");
    }
    
    public function login(Request $request)
    {
        if($request->password == $this->admin_password){
            return redirect("admin")->cookie('admin', '1', 3600);
        }
        return redirect("admin/login")
            ->withErrors(["password" => "Falsches Passwort!"]);
    }

    public function logout()
    {
        return redirect("admin")->cookie('admin', '1', -1);
    }
}

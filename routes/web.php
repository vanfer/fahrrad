<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Resourcen*/
Route::resource("fahrer", "FahrerController");
Route::resource("fahrrad", "FahrradController");

/*
|--------------------------------------------------------------------------
| Zentrale Ansicht
|
| Zeigt die Startseite mit Informationen an
|--------------------------------------------------------------------------
*/
Route::get("central", "MainController@showCentral"); /*  */
Route::get("/", function (){ return redirect("central"); });

/*
|--------------------------------------------------------------------------
| Mobile Ansicht
|--------------------------------------------------------------------------


Route::get("login", "LoginController@index");
Route::post("login", "LoginController@login");
Route::post("logout", "LoginController@logout");

Route::get("mobile", "MobileController@index");*/

/*
|--------------------------------------------------------------------------
| Administrative Ansicht
|--------------------------------------------------------------------------
*/

Route::get("admin/login", "AdminController@getLogin");
Route::post("admin/login", "AdminController@login");

Route::group(['middleware' => \App\Http\Middleware\Admin::class], function () {
    Route::get("admin", "AdminController@index");
    Route::get("admin/logout", "AdminController@logout");
});

/*
|--------------------------------------------------------------------------
| Datenaustausch
|--------------------------------------------------------------------------
*/
Route::get('search/autocomplete', 'SearchController@autocompleteName');

Route::post("data", "MainController@setData");
Route::post("batterydata", "MainController@setBatteryData");
Route::get("data", "MainController@getData");

Route::get("strecke", "MainController@strecken");
Route::get("strecke/{strecke}", "MainController@strecke");

Route::get("leistung", "MainController@leistung");

Route::get("fahrerstrecke", "MainController@fahrerstrecke");

Route::get("statistik", "MainController@statistik");

Route::get("fahrrad/{fahrrad}/fahrer/{fahrer}", "FahrradController@zuordnungHerstellen");
Route::delete("fahrrad/{fahrrad}", "FahrradController@zuordnungLoeschen");

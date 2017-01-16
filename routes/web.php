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

Route::resource("fahrer", "FahrerController");

Route::resource("fahrrad", "FahrradController");
Route::get("fahrrad/{fahrrad}/fahrer/{fahrer}", "FahrradController@zuordnungHerstellen");
Route::delete("fahrrad/{fahrrad}", "FahrradController@zuordnungLoeschen");

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
| Mail
|
|--------------------------------------------------------------------------
*/
Route::get('mail', "MailController@sendmail");

/*
|--------------------------------------------------------------------------
| Datenaustausch
|--------------------------------------------------------------------------
*/
Route::get('search/autocomplete', 'SearchController@autocompleteName');
Route::get("data", "FahrradController@getData");
Route::get("leistung", "MainController@leistung");
Route::post("abschnitt", "MainController@setAbschnitt");
Route::get("strecke", "MainController@strecken");
Route::get("strecke/{strecke}", "MainController@strecke");
Route::get("fahrerstrecke", "MainController@fahrerstrecke");
Route::get("statistik", "MainController@statistik");
Route::get("batterie", "MainController@batterie");
Route::get("highscore", "MainController@highscore");

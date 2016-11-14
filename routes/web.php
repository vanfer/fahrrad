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

/*
|--------------------------------------------------------------------------
| Zentrale Ansicht
|--------------------------------------------------------------------------
*/

Route::get("central", "MainController@index"); /* Zeigt die Startseite mit Informationen an */

/*
|--------------------------------------------------------------------------
| Mobile Ansicht (Standardansicht)
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get("/", function (){ return redirect("mobile"); });
Route::get("mobile", "MobileController@index");


/*
|--------------------------------------------------------------------------
| Datenaustausch
|--------------------------------------------------------------------------
*/
Route::post("data", "MainController@setData");
Route::get("data", "MainController@getData");

Route::get("strecke", "MainController@strecken");
Route::get("strecke/{strecke}", "MainController@strecke");
Route::get("leistung", "MainController@leistung");
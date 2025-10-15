<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('people', 'App\Http\Controllers\SearchController@people');
Route::get('childskill', 'App\Http\Controllers\SearchController@childskills');
Route::get('locations', 'App\Http\Controllers\SearchController@locations');
Route::get('searchskill', 'App\Http\Controllers\SearchController@searchskill');
Route::get('searchname', 'App\Http\Controllers\SearchController@searchname');

Route::get('validatename', 'App\Http\Controllers\SearchController@validatename');


Route::get('searchbyid', 'App\Http\Controllers\SearchController@searchbyid');

Route::get('searchprojectsbyid', 'App\Http\Controllers\SearchController@searchprojectsbyid');
Route::get('randomprojects', 'App\Http\Controllers\SearchController@randomprojects');


Route::post('sendemail', 'App\Http\Controllers\MailController@sendmail');

Route::post('deletedesiredskill', 'App\Http\Controllers\ProfileController@deletedesiredskill');




Route::get('getskillid', 'App\Http\Controllers\ProfileController@getskill_id');

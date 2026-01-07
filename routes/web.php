<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoomController;

Route::get('/zoom/webinar/add-dropdown', [ZoomController::class, 'addWebinarDropdown']);


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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/mailable', function () {
    return new App\Mail\ConnectNotification($msg='Hello World', $user_id=2, $user_name='Mira');
});

require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth', 'verified']], function () { 
    Route::get('/dashboard', 'App\Http\Controllers\SearchController@dashboard')->name('dashboard');
    Route::get('people/','App\Http\Controllers\SearchController@searchprofile');
    Route::get('projects/','App\Http\Controllers\SearchController@searchproject');
	Route::get('profile/{user_id}','App\Http\Controllers\ProfileController@index');
	Route::get('profile/{user_id}/projects','App\Http\Controllers\ProfileController@projects');
	Route::get('profile/{user_id}/skills','App\Http\Controllers\ProfileController@skills');
	Route::get('search/','App\Http\Controllers\SearchController@searchresults');
	Route::get('project/{id}','App\Http\Controllers\ProjectsController@index')->name('project');

	Route::post('project/update','App\Http\Controllers\ProjectsController@updateproject');

	Route::get('createproject/','App\Http\Controllers\ProjectsController@createproject');

	Route::post('createproject/','App\Http\Controllers\ProjectsController@createprojectpost');

	Route::get('/logout', '\App\Http\Controllers\LoginController@logout');

	Route::get('adddesiredskills','App\Http\Controllers\ProfileController@adddesiredskills')->name('adddesiredskills');
	Route::post('adddesiredskills','App\Http\Controllers\ProfileController@adddesiredskillspost');

	Route::get('addskills','App\Http\Controllers\ProfileController@addskills')->name('addskills');
	Route::post('addskills','App\Http\Controllers\ProfileController@addskillspost');


	Route::get('updatelanguage','App\Http\Controllers\ProfileController@updatelanguage')->name('updatelanguage');
	Route::post('updatelanguage','App\Http\Controllers\ProfileController@updatelanguagepost');

	Route::get('myprofile','App\Http\Controllers\ProfileController@myprofile')->name('myprofile');
	Route::post('myprofile','App\Http\Controllers\ProfileController@updateprofile');

	Route::post('updateimage', 'App\Http\Controllers\ProfileController@storeImage');


});


Route::group(['middleware' => ['auth']], function () { 

	Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
});

Route::get('/symlink', function() {
    Artisan::call('storage:link');
    return "symlink created!";
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache cleared!";
});

Route::get('/clear-config', function() {
    Artisan::call('config:clear');
    return "Config cleared!";
});

Route::get('/user-count', function() {
	$count = DB::table('users')->get()->count();
    return $count;
});
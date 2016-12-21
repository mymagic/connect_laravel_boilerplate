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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/callback', 'Auth\AuthController@login');


Auth::routes();

Route::group(['middleware' => 'guest'], function () {

    Route::get('/redirect', function () {
        $query = http_build_query([
            'client_id' => env('CONNECT_CLIENT_ID'),
            'redirect_uri' => env('CONNECT_CLIENT').'/callback',
            'response_type' => 'code',
            'scope' => '*'
        ]);
        return redirect(env('CONNECT_SERVER').'/oauth/authorize?' . $query);
    });

});
Route::get('/home', 'HomeController@index');

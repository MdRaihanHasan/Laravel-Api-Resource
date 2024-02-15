<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// group routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('books', 'App\Http\Controllers\BookController');
    Route::post('books/{book}/ratings', 'App\Http\Controllers\RatingController@store');
    Route::post('uploaded', 'App\Http\Controllers\AuthController@upload');
    Route::post('multi-upload', 'App\Http\Controllers\AuthController@multiUpload');

    Route::get('uploads/{filename}', function($filename) {

        $filePath = (base_path() . "/uploads/" . $filename);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404);
        }

    });

});

Route::get('/abd/dabba', function() {
    return 'dabba hai dabba uncle ka tv dabba';
})->name('login');


Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::post('login', 'App\Http\Controllers\AuthController@login');


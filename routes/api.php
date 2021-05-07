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

Route::group( [
    'namespace' => 'API',
    //'middleware' => 'auth:api'
], function()
{
    Route::get('categories/parents', 'CategoryController@getParents');
    Route::get('categories/{parent_id}/child', 'CategoryController@getChild');
    Route::get('categories/{category_id}/products', 'ProductController@getByCategory');
    Route::get('favourites', 'FavouriteController@index');
    Route::post('favourites', 'FavouriteController@store');
});

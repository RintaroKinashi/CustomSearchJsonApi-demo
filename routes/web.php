<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $language = trans('search_options.lang_ja');
    return view('googleSearch', compact('language'));
});
Route::get(
    '/google_search',
    'App\Http\Controllers\GoogleSearchController@text'
)->name('text_search');

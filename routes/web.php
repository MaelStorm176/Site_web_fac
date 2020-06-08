<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
Route::get('/', 'HomeController@index')->name('/');

Auth::routes();

Route::post('upload', 'FileController@store')->middleware('auth')->name('upload');
Route::post('update', 'FileController@update')->middleware('auth')->name('update');
Route::get('delete', 'FileController@delete')->middleware('auth')->name('delete');
Route::get('afficherForm', 'FileController@afficherForm')->middleware('auth')->name('afficherForm');
Route::get('afficher', 'FileController@afficher')->name('afficher');


Route::get('{licence}/download/{fichier}','FileController@download');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/delete_all','FileController@delete_all');


Route::get('/{licence}/{info}','FileController@afficher');

Route::post('/{licence}/{info}','FileController@afficher');



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

Route::get('{licence}/{info}/download/{fichier}','FileController@download');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });

    Route::get('/admin-panel','Admin@index')->name('admin-panel');
    Route::get('/admin-panel/files','Admin@files_afficher')->name('files');
    Route::get('/admin-panel/users','Admin@users_afficher')->name('users');
    Route::get('/admin-panel/users/details','Admin@users_details')->name('users_details');
    Route::get('/admin-panel/users/details?page=','Admin@users_details')->name('users_details_page');
    Route::get('/delete_all','FileController@delete_all');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user-panel','UserController@index')->name('user-panel');
    Route::get('/user-panel/files','UserController@files_afficher')->name('user-files');
});

Route::get('/{licence}/{info}','FileController@afficher');
Route::post('/{licence}/{info}','FileController@afficher');



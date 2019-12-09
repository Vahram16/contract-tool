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

Route::get('/', "Auth\LoginController@index")->name('index');
Route::post('/login', "Auth\LoginController@login")->name('login');
Route::get('/register', "Auth\RegisterController@index")->name('registerIndex');
Route::post('/create-register', "Auth\RegisterController@create")->name('registerCreate');
Route::get('/logout', "Auth\LoginController@logout")->name('logout');

Route::prefix('/text')->middleware('auth')->group(function () {


    Route::get('/index', 'ContractController@createContract')->name('contractIndex');
    Route::post('/store-main-contract', 'ContractController@storeMainContract')->name('storeMainContract');
    Route::get('/create-chapter', 'ChapterController@createChapter')->name('createChapter');
    Route::post('/store-chapter', 'ChapterController@storeChapter')->name('storeChapter');
    Route::get('/create-subchapter', 'ChapterController@createSubchapter')->name('createSubchapter');
    Route::get('/chapter2/subchapter', 'ChapterController@createChapter2Sub')->name('chapter2');
    Route::get('/chapter3/subchapter', 'ChapterController@createChapter3Sub')->name('chapter3');
    Route::get('/chapter4/subchapter', 'ChapterController@createChapter4Sub')->name('chapter4');
    Route::post('/storeSubchapter', 'ChapterController@storeSubchapter')->name('storeSubchapter');
    Route::post('/store-sub-variable', 'ChapterController@storeSubVariable')->name('storeSubVariable');
    Route::post('/store-word-document', 'ContractController@storeWordDocument')->name('storeWordDocument');


});

Route::get('/text', 'TextController@index');
Route::get('/test3', 'TextController@test3');

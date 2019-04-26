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

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::resource(
    'categories',
    'CategoryController', [
        'names' => [
            'index' => 'categories',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'update' => 'categories.update',
            'destroy' => 'categories.delete',
        ]
    ]
)->middleware('auth');

Route::post('articles/{article}/preview_front', 'ArticleController@preview_front')->name('articles.preview.front');
Route::post('articles/{article}/preview_back', 'ArticleController@preview_back')->name('articles.preview.back');
Route::resource(
    'articles',
    'ArticleController', [
        'names' => [
            'index' => 'articles',
            'create' => 'articles.create',
            'store' => 'articles.store',
            'update' => 'articles.update',
            'destroy' => 'articles.delete',
        ]
    ]
)->middleware('auth');
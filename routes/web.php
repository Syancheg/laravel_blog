<?php

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

Route::group(['namespace' => 'Main'], function(){
    Route::get('/', 'IndexController');
});

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function (){
    Route::group(['namespace' => 'Main'], function(){
        Route::get('/', 'IndexController')->name('admin.main')->middleware('auth');
    });
    Route::group(['prefix' => 'content'], function (){
        Route::group(['namespace' => 'Category', 'prefix' => 'categories'], function(){
            Route::get('/', 'IndexController')->name('admin.category.index')->middleware('auth');
            Route::get('/create', 'CreateController')->name('admin.category.create')->middleware('auth');
            Route::post('/', 'StoreController')->name('admin.category.store')->middleware('auth');
            Route::get('/{category}', 'ShowController')->name('admin.category.show')->middleware('auth');
            Route::get('/{category}/edit', 'EditController')->name('admin.category.edit')->middleware('auth');
            Route::patch('/{category}', 'UpdateController')->name('admin.category.update')->middleware('auth');
            Route::delete('/{category}', 'DeleteController')->name('admin.category.delete')->middleware('auth');
        });
        Route::group(['namespace' => 'Tag', 'prefix' => 'tags'], function(){
            Route::get('/', 'IndexController')->name('admin.tag.index')->middleware('auth');
            Route::get('/create', 'CreateController')->name('admin.tag.create')->middleware('auth');
            Route::post('/', 'StoreController')->name('admin.tag.store')->middleware('auth');
            Route::get('/{tag}', 'ShowController')->name('admin.tag.show')->middleware('auth');
            Route::get('/{tag}/edit', 'EditController')->name('admin.tag.edit')->middleware('auth');
            Route::patch('/{tag}', 'UpdateController')->name('admin.tag.update')->middleware('auth');
            Route::delete('/{tag}', 'DeleteController')->name('admin.tag.delete')->middleware('auth');
        });
        Route::group(['namespace' => 'Post', 'prefix' => 'posts'], function(){
            Route::get('/', 'IndexController')->name('admin.post.index')->middleware('auth');
            Route::get('/create', 'CreateController')->name('admin.post.create')->middleware('auth');
            Route::post('/', 'StoreController')->name('admin.post.store')->middleware('auth');
            Route::get('/{post}', 'ShowController')->name('admin.post.show');
            Route::get('/{post}/edit', 'EditController')->name('admin.post.edit')->middleware('auth');
            Route::patch('/{post}', 'UpdateController')->name('admin.post.update')->middleware('auth');
            Route::delete('/{post}', 'DeleteController')->name('admin.post.delete')->middleware('auth');
        });
    });
});

Auth::routes();

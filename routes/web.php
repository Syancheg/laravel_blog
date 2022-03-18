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
    Route::get('/', 'IndexController')->name('top-menu.main');
    Route::get('/categories', 'CategoryController')->name('top-menu.categories');
    Route::get('/contact', 'ContactController')->name('top-menu.contact');
    Route::get('/categories/{category:slug}', 'CategoryController@getCategory')
        ->where('category:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
        ->name('detail.category');
    Route::get('/categories/{category:slug}/posts/{post:slug}', 'PostController')
        ->where('category:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
        ->where('post:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
        ->name('detail.post');
});

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::group(['namespace' => 'Admin', 'middleware'=> 'auth', 'prefix' => 'admin'], function (){
    Route::group(['namespace' => 'Main'], function(){
        Route::get('/', 'IndexController')->name('admin.main');
    });
    Route::group(['namespace' => 'Common', 'prefix' => 'filemanager'], function(){
        Route::post('/get-file', 'FilemanagerController@getFiles')->name('admin.filemanager.get');
        Route::post('/upload-file', 'FilemanagerController@uploadFiles')->name('admin.filemanager.upload');
        Route::post('/new-folder', 'FilemanagerController@newFolder')->name('admin.filemanager.new_folder');
        Route::post('/delete', 'FilemanagerController@deleteEntity')->name('admin.filemanager.delete');
    });
    Route::group(['namespace' => 'Common','prefix' => 'setting'], function () {
        Route::get('/left_menu', 'MenuController')->name('admin.setting.left_menu');
        Route::get('/left_menu/refresh', 'MenuController@refreshPath')->name('admin.setting.left_menu.refresh');
        Route::post('/left_menu/edit', 'MenuController@editPath')->name('admin.setting.left_menu.edit');
    });
    Route::group(['prefix' => 'content'], function (){
        Route::group(['namespace' => 'Category', 'prefix' => 'category'], function(){
            Route::get('/', 'IndexController')->name('admin.category.index');
            Route::get('/create', 'CreateController')->name('admin.category.create');
            Route::post('/', 'StoreController')->name('admin.category.store');
            Route::get('/{category}', 'ShowController')->name('admin.category.show');
            Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
            Route::patch('/{category}', 'UpdateController')->name('admin.category.update');
            Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
        });
        Route::group(['namespace' => 'Tag', 'prefix' => 'tag'], function(){
            Route::get('/', 'IndexController')->name('admin.tag.index');
            Route::get('/create', 'CreateController')->name('admin.tag.create');
            Route::post('/', 'StoreController')->name('admin.tag.store');
            Route::get('/{tag}', 'ShowController')->name('admin.tag.show');
            Route::get('/{tag}/edit', 'EditController')->name('admin.tag.edit');
            Route::patch('/{tag}', 'UpdateController')->name('admin.tag.update');
            Route::delete('/{tag}', 'DeleteController')->name('admin.tag.delete');
        });
        Route::group(['namespace' => 'Post', 'prefix' => 'post'], function(){
            Route::get('/', 'IndexController')->name('admin.post.index');
            Route::get('/create', 'CreateController')->name('admin.post.create');
            Route::post('/', 'StoreController')->name('admin.post.store');
            Route::get('/{post}', 'ShowController')->name('admin.post.show');
            Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
            Route::patch('/{post}', 'UpdateController')->name('admin.post.update');
            Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');
        });
        Route::group(['namespace' => 'Banner', 'prefix' => 'banner'], function(){
            Route::get('/', 'IndexController')->name('admin.banner.index');
            Route::get('/create', 'CreateController')->name('admin.banner.create');
            Route::post('/', 'StoreController')->name('admin.banner.store');
            Route::get('/{banner}', 'ShowController')->name('admin.banner.show');
            Route::get('/{banner}/edit', 'EditController')->name('admin.banner.edit');
            Route::patch('/{banner}', 'UpdateController')->name('admin.banner.update');
            Route::delete('/{banner}', 'DeleteController')->name('admin.banner.delete');
        });
    });
});

Auth::routes();


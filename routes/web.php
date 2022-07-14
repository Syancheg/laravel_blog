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
    Route::group(['namespace' => 'Home'], function() {
        Route::get('/', 'IndexController')->name('public.home.index');
        Route::get('/contact', 'ContactController')->name('public.home.contact');
    });
    Route::group(['namespace' => 'Content'], function() {
        Route::get('/blog', 'BlogController')->name('public.content.blog');
        Route::get('/blog/tag/{tag:id}', 'BlogController@getPostForTag')->name('public.content.tag');
        Route::get('/blog/{category:slug}', 'BlogController')->name('public.content.category');
        Route::get('/blog/{category:slug}/{post:slug}', 'PostController')->name('public.content.post');

        Route::get('/all-dogs', 'DogsController')->name('public.content.dogs');
        Route::get('/all-dogs/{dog:slug}', 'DogController')->name('public.content.dog');
    });

//    Route::get('/categories', 'CategoryController')->name('top-menu.categories');
//    Route::get('/contact', 'ContactController')->name('top-menu.contact');
//    Route::get('/categories/{category:slug}', 'CategoryController@getCategory')
//        ->where('category:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
//        ->name('detail.category');
//    Route::get('/categories/{category:slug}/posts/{post:slug}', 'PostController')
//        ->where('category:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
//        ->where('post:slug', '^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$')
//        ->name('detail.post');
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
    Route::group(['prefix' => 'setting'], function () {
        Route::group(['namespace' => 'Common', 'prefix' => 'left_menu'], function () {
            Route::get('/', 'MenuController')->name('admin.setting.left_menu');
            Route::get('/refresh', 'MenuController@refreshPath')->name('admin.setting.left_menu.refresh');
            Route::post('/edit', 'MenuController@editPath')->name('admin.setting.left_menu.edit');
        });
        Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
            Route::get('/', 'IndexController')->name('admin.setting.user');
            Route::post('/ajax/change-password/{user?}', 'UpdateController@changePassword')->name('admin.setting.user.change-password');
            Route::post('/ajax/edit/{user?}', 'UpdateController@editUser')->name('admin.setting.user.edit');
        });
    });
    Route::group(['namespace' => 'Entity', 'prefix' => 'entity'], function() {
        Route::group(['namespace' => 'Dog', 'prefix' => 'dog'], function() {
            Route::get('/', 'IndexController')->name('admin.entity.dog.index');
            Route::get('/create', 'CreateController')->name('admin.entity.dog.create');
            Route::post('/', 'StoreController')->name('admin.entity.dog.store');
            Route::get('/{dog}', 'ShowController')->name('admin.entity.dog.show');
            Route::get('/{dog}/edit', 'EditController')->name('admin.entity.dog.edit');
            Route::patch('/{dog}', 'UpdateController')->name('admin.entity.dog.update');
            Route::delete('/{dog}', 'DeleteController')->name('admin.entity.dog.delete');
            Route::get('/api/dogs/{dog:id}', 'EditController@activateDogs')->name('public.api.activate.dogs');
        });
    });
    Route::group(['prefix' => 'content'], function (){
        Route::group(['namespace' => 'Common', 'prefix' => 'image-gallary'], function () {
            Route::get('/', 'GallaryController')->name('admin.gallary.index');
            Route::post('/', 'GallaryController@storeGallary')->name('admin.gallary.store');
            Route::get('/create', 'GallaryController@createGallary')->name('admin.gallary.create');
            Route::get('/{gallary}/edit', 'GallaryController@editGallary')->name('admin.gallary.edit');
            Route::patch('/{gallary}', 'GallaryController@updateGallary')->name('admin.gallary.update');
            Route::delete('/{gallary}', 'GallaryController@deleteGallary')->name('admin.gallary.delete');
            Route::get('/{gallary}/copy', 'GallaryController@copyGallary')->name('admin.gallary.copy');
        });
        Route::group(['namespace' => 'Category', 'prefix' => 'category'], function(){
            Route::get('/', 'IndexController')->name('admin.category.index');
            Route::get('/create', 'CreateController')->name('admin.category.create');
            Route::post('/', 'StoreController')->name('admin.category.store');
            Route::get('/{category}', 'ShowController')->name('admin.category.show');
            Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
            Route::patch('/{category}', 'UpdateController')->name('admin.category.update');
            Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
            Route::get('/api/categories/{category:id}', 'EditController@activateCategories')->name('public.api.activate.categories');
        });
        Route::group(['namespace' => 'Tag', 'prefix' => 'tag'], function(){
            Route::get('/', 'IndexController')->name('admin.tag.index');
            Route::post('/ajax/new-tag', 'IndexController@newTag')->name('admin.tag.new-tag');
            Route::post('/ajax/rename-tag/{tag?}', 'IndexController@renameTag')
//                ->where('tag', '\d')
                ->name('admin.tag.rename-tag');
            Route::get('/ajax/delete-tag/{tag?}', 'IndexController@deleteTag')
//                ->where('tag', '\d')
                ->name('admin.tag.delete-tag');
        });
        Route::group(['namespace' => 'Post', 'prefix' => 'post'], function(){
            Route::get('/', 'IndexController')->name('admin.post.index');
            Route::get('/create', 'CreateController')->name('admin.post.create');
            Route::post('/', 'StoreController')->name('admin.post.store');
            Route::get('/{post}', 'ShowController')->name('admin.post.show');
            Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
            Route::patch('/{post}', 'UpdateController')->name('admin.post.update');
            Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');
            Route::get('/api/posts/{post:id}', 'EditController@activatePosts')->name('public.api.activate.posts');
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

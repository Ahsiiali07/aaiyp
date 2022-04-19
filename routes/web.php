<?php

use Illuminate\Support\Facades\Auth;
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

Route::get( '/', 'WelcomeController@index' )->name( 'welcome' );

Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::prefix( 'users' )->group( static function () {
    Route::get( '/', 'Web\UserController@indexUser' )->name( 'users' );
    Route::get( '/patient', 'Web\UserController@indexPatient' )->name( 'users-patient' );
    Route::get( '/psw', 'Web\UserController@indexPSW' )->name( 'users-psw' );
    Route::get('export/', 'Web\UserController@export')->name('user-export');
    Route::get( '/{id}', 'Web\UserController@show' )->name( 'user' );
    Route::get( '/{id}/edit', 'Web\UserController@edit' )->name( 'user-edit' );
    Route::post( '/{id}/update', 'Web\UserController@update' )->name( 'user-status-update' );
    Route::delete( '/{id}/delete', 'Web\UserController@destroy' )->name( 'user-delete' );
    Route::post( '/{id}/approve', 'Web\UserController@approve' )->name( 'user-approve' );
    Route::get( '/{id}/show-answers', 'Web\QuestionController@showAnswersForSpecificUser' )->name( 'user-answers' );
    Route::get( '/{id}/show-documents', 'Web\QuestionController@showDocumentsForSpecificUser' )->name( 'user-documents' );
} );

Route::prefix( 'leaders' )->group( static function () {
    Route::get( '/', 'Web\UserController@indexLeader' )->name( 'leaders' );
    Route::get( '/leader', 'Web\UserController@indexLeader' )->name( 'leaders-patient' );
    Route::get( '/psw', 'Web\UserController@indexPSW' )->name( 'leaders-psw' );
    Route::get('export/', 'Web\UserController@export')->name('leader-export');
    Route::get( '/{id}', 'Web\UserController@showLeader' )->name( 'leader' );
    Route::get( '/{id}/edit', 'Web\UserController@editLeader' )->name( 'leader-edit' );
    Route::post( '/{id}/update', 'Web\UserController@update' )->name( 'leader-status-update' );
    Route::delete( '/{id}/delete', 'Web\UserController@destroyLeader' )->name( 'leader-delete' );
    Route::post( '/{id}/approve', 'Web\UserController@approveLeader' )->name( 'leader-approve' );
    Route::get( '/{id}/show-answers', 'Web\QuestionController@showAnswersForSpecificUser' )->name( 'leader-answers' );
    Route::get( '/{id}/show-documents', 'Web\QuestionController@showDocumentsForSpecificUser' )->name( 'leader-documents' );
} );

Route::prefix( 'categories' )->group( static function () {
    Route::get( '/', 'Web\CategoryController@index' )->name( 'categories' );
    Route::get( '/create', 'Web\CategoryController@create' )->name( 'category-create' );
    Route::post( '/store', 'Web\CategoryController@store' )->name( 'category-store' );
    Route::get( '/{id}', 'Web\CategoryController@show' )->name( 'category' );
    Route::delete( '/{id}', 'Web\CategoryController@destroy' )->name( 'category-delete' );
    Route::get( '/{id}/edit', 'Web\CategoryController@edit' )->name( 'category-edit' );
    Route::post( '/{id}/update', 'Web\CategoryController@update' )->name( 'category-update' );
} );


Route::prefix( 'feeds' )->group( static function () {
    Route::get( '/', 'Web\FeedsController@index' )->name( 'feeds' );
    Route::get( '/create', 'Web\FeedsController@create' )->name( 'feed-create' );
    Route::post( '/store', 'Web\FeedsController@store' )->name( 'feed-store' );
    Route::get( '/{id}', 'Web\FeedsController@show' )->name( 'feed' );
    Route::delete( '/{id}', 'Web\FeedsController@destroy' )->name( 'feed-delete' );
    Route::get( '/{id}/edit', 'Web\FeedsController@edit' )->name( 'feed-edit' );
    Route::post( '/{id}/update', 'Web\FeedsController@update' )->name( 'feed-update');
    Route::post('/{id}/detail','Web\FeedsController@detail')->name('feed-detail');
} );

Route::prefix( 'groups' )->group( static function () {
    Route::get( '/', 'Web\GroupsController@index' )->name( 'groups' );
    Route::get( '/create', 'Web\GroupsController@create' )->name( 'group-create' );
    Route::post( '/store', 'Web\GroupsController@store' )->name( 'group-store' );
    Route::get( '/{id}', 'Web\GroupsController@show' )->name( 'group' );
    Route::delete( '/{id}', 'Web\GroupsController@destroy' )->name( 'group-delete' );
    Route::get( '/{id}/edit', 'Web\GroupsController@edit' )->name( 'group-edit' );
    Route::post( '/{id}/update', 'Web\GroupsController@update' )->name( 'group-update' );
    
        Route::prefix( '{id}/groupsuser' )->group( static function () {
        Route::get( '/', 'Web\GroupUserController@index' )->name( 'groupsuser' );
        Route::get( '/create', 'Web\GroupUserController@create' )->name( 'groupuser-create' );
        Route::post( '/store', 'Web\GroupUserController@store' )->name( 'groupuser-store' );
        Route::get( '/{gid}', 'Web\GroupUserController@show' )->name( 'groupuser-show' );
        Route::delete( '/{gid}', 'Web\GroupUserController@destroy' )->name( 'groupuser-delete' );
        Route::get( '/{gid}/edit', 'Web\GroupUserController@edit' )->name( 'groupuser-edit' );
        Route::post( '/{gid}/update', 'Web\GroupUserController@update' )->name( 'groupuser-update' );
    } );
} );


Route::prefix('reported-feed')->group( static function() {
    Route::get('/','Web\ReportedFeedController@index')->name('reported-feed');


    Route::get( '/{id}', 'Web\ReportedFeedController@show' )->name( 'reported-feed-show' );
    Route::delete( '/{id}', 'Web\ReportedFeedController@destroy' )->name( 'reported-feed-delete' );
});

//Route::prefix('admin-feeds')->group(static function () {
//    Route::get('/', 'Web\AdminController@index')->name('admin-feeds');
//    Route::get('/create', 'Web\AdminController@create')->name('admin-feed-create');
//    Route::post('/store', 'Web\AdminController@store')->name('admin-feed-store');
//    Route::get('/{id}', 'Web\AdminController@show')->name('admin-feed');
//    Route::delete('/{id}', 'Web\AdminController@destroy')->name('admin-feed-delete');
//    Route::get('/{id}/edit', 'Web\AdminController@edit')->name('admin-feed-edit');
//    Route::post('/{id}/update', 'Web\AdminController@update')->name('admin-feed-update');
//});



Route::prefix( 'content-management' )->group( static function () {
    Route::get( '/', 'Web\ContentManagementController@index' )->name( 'cms' );
    Route::get( '/{id}', 'Web\ContentManagementController@show' )->name( 'cm' );
    Route::delete( '/{id}', 'Web\ContentManagementController@destroy' )->name( 'cm-delete' );
    Route::get( '/{id}/edit', 'Web\ContentManagementController@edit' )->name( 'cm-edit' );
    Route::post( '/{id}/update', 'Web\ContentManagementController@update' )->name( 'cm-update' );
} );

Route::prefix( 'support' )->group( static function () {
    Route::get( '/', 'Web\SupportController@index' )->name( 'support-requests' );
    Route::get( '/{id}', 'Web\SupportController@show' )->name( 'support-request' );
    Route::post( '/{id}/close', 'Web\SupportController@close' )->name( 'support-close' );
    Route::post( '/{id}/open', 'Web\SupportController@open' )->name( 'support-open' );
});







//
//Route::prefix( 'notifications' )->group( static function () {
//    Route::get('/create', 'Web\NotificationController@create')->name('notification-create');
//    Route::post('/send-to-all', 'Web\NotificationController@sendNotificationToAll')->name('notification-send-to-all');
//} );

//Route::get( '/download/{filename}', 'GeneralController@download')->name('download');

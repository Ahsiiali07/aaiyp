<?php


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
Route::prefix('categories')->group(static function () {

    Route::get('/', 'API\CategoryController@get');

});

Route::prefix('group')->group(static function () {

    Route::post('/store', 'API\GroupController@store');
    
    Route::get('/', 'API\GroupController@getAllGroups');

});

// Route::prefix('feeds')->group(static function () {

//     Route::get('/', 'API\FeedController@get');

// });

Route::post('login', 'API\UserController@login');

Route::get('/getUser', 'API\UserController@getUser');

Route::get('/getLeader', 'API\UserController@getLeader');

Route::post('social-login', 'API\UserController@socialLogin');

Route::post('finger-print', 'API\UserController@fingerPrint');

Route::post('register', 'API\UserController@register');

Route::post('users/{id}/add-questionnaire', 'API\UserController@addQuestionnaire');

//Route::post('add-password/{token}', 'API\UserController@registerPassword');

Route::post('add-details', 'API\UserController@addDetails');

Route::post('forget-password', 'API\UserController@forgetPasswordRequest');

Route::post('match-pin', 'API\UserController@forgetPasswordPin');

Route::post('match-otp', 'API\UserController@checkOtp');

Route::post('generate-new-otp', 'API\UserController@generateNewOtp');

Route::post('change-password', 'API\UserController@changePasswordPin');

Route::post('send-feedback-request', 'API\SupportController@sendSupportRequest');

Route::post('check-email', 'API\UserController@checkEmail');

Route::post('plans', 'API\PaymentController@fetchAllPlans');

Route::post('plans/{plan}', 'API\PaymentController@retrieve');

Route::group(['middleware' => 'auth:api'], static function () {

    /*
     *  User Routes Group
     */
    Route::group(['prefix' => 'user'], static function () {

        Route::post('/update-profile', 'API\UserController@update');

        Route::get('/get-profile', 'API\UserController@details');

        Route::post('/logout', 'API\UserController@logout');
        
       Route::post('/saveUser', 'API\GroupUserController@add');

    });

    Route::post('send-notification/{userId}', 'API\NotificationController@sendNotificationToSpecific');

    Route::post('categories', 'API\CategoryController@getAll');

    Route::post('details', 'API\UserController@details');

    Route::post('update-details', 'API\UserController@updateDetails');

    Route::post('signout', 'API\UserController@signout');

    Route::post('logout', 'API\UserController@logout');

    Route::post('update-rating', 'API\RatingController@storeOrUpdate');

    Route::get('get-rating', 'API\RatingController@getRating');

    Route::prefix('feed')->group(static function () {
        Route::get('/', 'API\FeedController@get');

        Route::post('/store', 'API\FeedController@store');

        Route::post('/my', 'API\FeedController@getAllAgainstUser');

        Route::post('/search', 'API\FeedController@filter');

        Route::get('/{id}/delete', 'API\FeedController@destroy');

        Route::post('/{id}/share', 'API\FeedController@share');

        Route::post('/{id}/share-by-category/{catId}', 'API\FeedController@shareByCategory');

        Route::post('/{id}/like-unlike', 'API\FeedLikeController@favoriteUnFavorite');

        Route::post('/favorites/all', 'API\FeedLikeController@getAllAgainstUser');


        Route::get('get-comments/{id}', 'API\FeedCommentController@getPostComment');

        Route::post('/{id}/give-comment', 'API\FeedCommentController@store');

        Route::post('update-comment/{id}', 'API\FeedCommentController@update');


        Route::post( '/report', 'API\ReportedFeedController@store' );

    });
    
    Route::post('is-subscribed', 'API\UserController@isSubscribed');

    Route::post('fetch-payment-method', 'API\PaymentController@fetchPaymentMethod');

    Route::post('add-payment-method', 'API\PaymentController@addPaymentMethod');

    Route::post('create-subscription', 'API\PaymentController@createSubscription');
    
});

Route::get('about-us', 'API\ContentManagementController@aboutUs');

Route::get('terms-and-conditions', 'API\ContentManagementController@terms');

Route::get('privacy-policy', 'API\ContentManagementController@privacy');

Route::get('banner', 'API\ContentManagementController@banner');

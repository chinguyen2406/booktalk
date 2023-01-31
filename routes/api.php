<?php

use Illuminate\Http\Request;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    // search
//    Route::post('search', 'HomeController@search');

    // Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){

        Route::get('refresh', 'AuthController@refresh');
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');

    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::resource('users', UserController::class);
    Route::get('users', 'UserController@index')->middleware('isSuperAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
    Route::post('editUser', 'UserController@editUser');
    Route::post('likeCategory', 'UserController@likeCategory');
    Route::get('getLikeCategory', 'UserController@getLikeCategory');


    Route::get('/getDownload', 'BooksController@getDownload');

 //like
    Route::get('likes','LikesController@getLike');
    Route::get('checkLike','LikesController@checkLike');
    Route::post('likeBook','LikesController@likeBook');
    Route::post('dislike','LikesController@dislike');

    // category
    Route::resource('categories', CategoryController::class);
    Route::get('/booksInCategory','CategoryController@booksInCategory');


    Route::get('/getListBooksLike','CategoryController@getListBooksLike');

    // book
    Route::resource('books', BooksController::class);
    Route::post('/books/update/{id}', 'BooksController@update');
    Route::get('/booksStore', 'BooksController@booksStore');
    Route::get('/allBook', 'BooksController@allBook');
    Route::post('/sortBooksStore', 'BooksController@sortBooksStore');

    Route::get('/readOnline','BooksController@readOnline');

    //add comments
    Route::resource('comments', CommentsController::class);
    Route::get('comments', 'CommentsController@comments');
    Route::get('allComments', 'CommentsController@allComments');

    Route::post('addComment', 'CommentsController@addComment');
    //delete comments
    Route::post('deleteComment/{id}','CommentsController@deleteComment');
    //update commment
    Route::post('updateComment/{id}','CommentsController@updateComment');
    //save image
    Route::post('saveImg', 'PostsController@saveImg');


    // xem profile user
    Route::get('/profile/{slug}', 'ProfileController@index');
    Route::get('/changePhoto', function() {
        return view('profile.pic');
    });
    Route::get('editProfile', 'ProfileController@editProfileForm');
    Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');
    // update profile
    Route::post('/updateProfile','ProfileController@updateProfile');


});

    Route::get('/categoryHome','CategoryController@categoryHome');
    Route::post('/search', 'BooksController@search');
    Route::get('/booksHot','CategoryController@booksHot');
Route::get('/allCategories','CategoryController@allCategories');

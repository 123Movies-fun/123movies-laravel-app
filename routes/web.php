<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/movie/{title}', ['middleware' => 'cors', 'uses'=>'HomeController@watch']);
Route::get('/tv-series/{title}', ['middleware' => 'cors', 'uses'=>'HomeController@watch']);
Route::get('/player', ['middleware' => 'cors', 'uses'=>'IMDBController@player']);

Route::get('movie/search/{keyword}', 'HomeController@movieSearch');



/*
 * Routes for User / Auth Controller
*/
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

/*
 * Routes for User Controller
*/
Route::post('user/login', 'UserController@ajaxLogin');
Route::get('user/profile', 'UserController@showProfile');
Route::post('user/forgotPassword', 'UserController@ajaxForgotPassword');
Route::post('user/register', 'UserController@ajaxRegister');
Route::post('user/update', 'UserController@ajaxUpdate');


/*
 * Routes for Image Controller
*/
Route::get('upload', ['as' => 'upload-post', 'uses' =>'ImageController@postUpload']);
Route::post('upload', ['as' => 'upload-post', 'uses' =>'ImageController@postUpload']);
Route::post('upload/delete', ['as' => 'upload-remove', 'uses' =>'ImageController@deleteUpload']);


/*
 * Routes for IMDB Controller 
*/
Route::get('imdb', 'IMDBController@insertNew');
Route::get('imdb/info', 'IMDBController@info');
Route::get('imdb/ajaxSearch', 'IMDBController@ajaxSearch');
Route::get('genre/{genre}', 'IMDBController@showGenre');
Route::get('country/{country}', 'IMDBController@showCountry');
Route::get('movies/imdbtop', 'IMDBController@showImdbTop250');
Route::get('tv-series', 'IMDBController@showTVSeries');
Route::get('movies/library', 'IMDBController@showLibrary');
Route::get('movies/library/{letter}', 'IMDBController@showLibrary');

Route::get('articles/news', 'IMDBController@showNews');

Route::get('/filter/movies', 'IMDBController@showMoviesFilter');
Route::get('/filter/tv', 'IMDBController@showTVFilter');
Route::get('/filter/all', 'IMDBController@showMoviesFilter');


Route::get('/movie/filter/all', 'IMDBController@showLibrary');
Route::get('/movie/filter/series', 'IMDBController@showLibrary');
Route::get('/movie/rate', 'IMDBController@userRating');
Route::get('/movie/favorite', 'IMDBController@userFavorite');
Route::get('/movies/favorites', 'UserController@myFavorites');
Route::get('/movies/rated', 'UserController@myRated');
Route::get('/importdb', 'HomeController@dbImport');
Route::get('/imageCdnUpgrade', 'ImageController@serverCDNUpgradeScript');
Route::get('/downloadImageToCDN', 'ServerController@downloadImageToCDN');
Route::get('/cloudbot/image_done', 'ImageController@CloudBotImageDLCompleted');





Route::get('/tag/{tag}', 'IMDBController@showTag');


Route::get('/donate', 'HomeController@donate');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/users', 'AdminController@users');


/*
 * Routes for IMDB Controller 
*/
Route::get('downloadMovie', ['middleware' => 'cors', 'uses'=> 'MovieDownloaderController@downloadNew']);
Route::get('uploadMovie', ['middleware' => 'cors', 'uses'=> 'MovieDownloaderController@uploadGoogleDrive']);


Route::get('getCloudBot', ['middleware' => 'cors', 'uses'=> 'ServerController@getCloudBot']);
Route::get('driveIDKnown', ['middleware' => 'cors', 'uses'=> 'ServerController@driveIDKnown']);


Route::get('testYandex', ['middleware' => 'cors', 'uses'=> 'MovieDownloaderController@YandexBot']);
Route::get('server/heartbeat', ['middleware' => 'cors', 'uses'=> 'ServerController@heartbeatAPI']);
Route::get('server/yandex-done', ['middleware' => 'cors', 'uses'=> 'MovieDownloaderController@yandexDone']);


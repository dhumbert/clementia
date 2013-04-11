<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|       Route::get('hello', function()
|       {
|           return 'Hello World!';
|       });
|
| You can even respond to more than one URI:
|
|       Route::post(array('hello', 'world'), function()
|       {
|           return 'Hello World!';
|       });
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|       Route::put('hello/(:any)', function($name)
|       {
|           return "Welcome, $name.";
|       });
|
*/

/* Public routes */

Route::get('/', array('as' => 'home', 'uses' => 'home@index'));

/* End public routes */

/* Session routes */
Route::get('login', array('as' => 'login', 'uses' => 'session@create'));
Route::delete('logout', array('as' => 'logout', 'uses' => 'session@destroy'));
Route::controller('session');
/* End session routes */

/* Protected routes */
Route::group(array('before' => 'auth'), function(){

    Route::get('user', array('as' => 'user_account', 'uses' => 'user@index'));

    /* Test routes */
    Route::delete('test/delete/(:num)', array('as' => 'test_delete', 'uses' => 'test@destroy'));

    Route::post('test/(:num)', array('as' => 'test_run', 'uses' => 'test@run'));
    Route::get('test/(:num)', array('as' => 'test_detail', 'uses' => 'test@detail'));

    Route::get('test/(:num)/edit', array('as' => 'test_edit', 'uses' => 'test@edit'));
    Route::put('test/(:num)/edit', array('as' => 'test_update', 'uses' => 'test@edit'));

    Route::get('test/(all|passing|failing|never-run)', array('as' => 'test_list_status_filter', 'uses' => 'test@list'));
    Route::get('test', array('as' => 'test_list', 'uses' => 'test@list'));
    Route::controller('test');
    /* End test routes */
  
});

Route::group(array('before' => 'admin'), function(){
    Route::get('user/list', array('as' => 'user_list', 'uses' => 'user@list'));
});

/* User routes */
Route::get('user/reset-password', array('as' => 'user_forgot_password_reset', 'uses' => 'user@reset_password'));
Route::post('user/forgot-password', array('as' => 'user_forgot_password', 'uses' => 'user@forgot_password'));
Route::get('user/forgot-password', array('as' => 'user_forgot_password', 'uses' => 'user@forgot_password'));
Route::controller('user');
/* End user routes */

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
    return Response::error('404');
});

Event::listen('500', function()
{
    return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|       Route::filter('filter', function()
|       {
|           return 'Filtered!';
|       });
|
| Next, attach the filter to a route:
|
|       Router::register('GET /', array('before' => 'filter', function()
|       {
|           return 'Hello World!';
|       }));
|
*/

Route::filter('before', function()
{
    // Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
    // Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
    if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::to('login');
});

Route::filter('admin', function()
{
    if (!Auth::check('Administrator')) return Response::error('403');
});
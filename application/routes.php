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
|       Route::secure('GET', 'hello', function()
|       {
|           return 'Hello World!';
|       });
|
| You can even respond to more than one URI:
|
|       Route::secure('POST', array('hello', 'world'), function()
|       {
|           return 'Hello World!';
|       });
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|       Route::secure('PUT', 'hello/(:any)', function($name)
|       {
|           return "Welcome, $name.";
|       });
|
*/

/* Public routes */

Route::secure('GET', '/welcome', array('as' => 'home', 'uses' => 'home@index', 'before' => 'front_redirect_if_authenticated'));

/* End public routes */

/* Session routes */
Route::secure('GET', 'login', array('as' => 'login', 'uses' => 'session@create'));
Route::secure('DELETE', 'logout', array('as' => 'logout', 'uses' => 'session@destroy'));
Route::controller('session');
/* End session routes */

/* Protected routes */
Route::group(array('before' => 'auth'), function(){

    /* Site routes */
    Route::secure('GET', 'site', array('as' => 'site_list', 'uses' => 'site@index'));
    Route::secure('GET', 'site/check-max-tests', array('as' => 'site_check_max_tests', 'uses' => 'site@check_max_tests'));
    Router::controller('site', 'index', true);

    Route::secure('GET', 'account', array('as' => 'user_account', 'uses' => 'user@index'));
    Route::secure('GET', 'account/subscription', array('as' => 'subscription', 'uses' => 'user@subscription'));

    /* Test routes */
    Route::secure('DELETE', 'test/delete/(:num)', array('as' => 'test_delete', 'uses' => 'test@destroy'));

    Route::secure('POST', 'test/(:num)', array('as' => 'test_run', 'uses' => 'test@run'));
    Route::secure('GET', 'test/(:num)', array('as' => 'test_detail', 'uses' => 'test@detail'));

    Route::secure('GET', 'test/(:num)/edit', array('as' => 'test_edit', 'uses' => 'test@edit'));
    Route::secure('PUT', 'test/(:num)/edit', array('as' => 'test_update', 'uses' => 'test@edit'));

    Route::secure('GET', 'test/(all|passing|failing|never-run)', array('as' => 'test_list_status_filter', 'uses' => 'test@list'));
    Route::secure('GET', 'test/list', array('as' => 'ajax_test_list', 'uses' => 'test@ajax_list'));
    Route::secure('GET', '/', array('as' => 'test_list', 'uses' => 'test@list'));
    Router::controller('test', 'index', true);
    /* End test routes */
  
});

Route::group(array('before' => 'admin'), function(){
    Route::secure('GET', 'admin', array('as' => 'admin', 'uses' => 'admin@index'));
    Route::secure('DELETE', 'user/delete/(:num)', array('as' => 'delete_user', 'uses' => 'user@delete'));

    Route::secure('GET', 'role/edit/(:num)', array('as' => 'edit_role', 'uses' => 'role@edit'));
    Route::secure('POST', 'role/edit/(:num)', array('as' => 'edit_role', 'uses' => 'role@edit'));
    Route::secure('GET', 'role/create', array('as' => 'create_role', 'uses' => 'role@create'));
    Route::secure('POST', 'role/create', array('as' => 'create_role', 'uses' => 'role@create'));
});

/* User routes */
Route::secure('GET', 'signup', array('as' => 'signup', 'uses' => 'user@signup'));
Route::secure('POST', 'signup', array('as' => 'signup', 'uses' => 'user@signup'));
Route::secure('POST', 'user/reset-password/(:any)', array('as' => 'user_forgot_password_reset', 'uses' => 'user@reset_password'));
Route::secure('GET', 'user/reset-password/(:any)', array('as' => 'user_forgot_password_reset', 'uses' => 'user@reset_password'));
Route::secure('POST', 'user/forgot-password', array('as' => 'user_forgot_password', 'uses' => 'user@forgot_password'));
Route::secure('GET', 'user/forgot-password', array('as' => 'user_forgot_password', 'uses' => 'user@forgot_password'));
Router::controller('user', 'index', true);
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
    if (Auth::guest()) return Redirect::to_route('home');
});

Route::filter('admin', function()
{
    if (!Auth::check('Administrator')) return Response::error('403');
});

Route::filter('front_redirect_if_authenticated', function()
{
    if (Auth::check()) return Redirect::to_route('test_list');
});
<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        $statusCode = 204;

        $headers = [
            'Access-Control-Allow-Origin'       => Config::get('app.allowedorigin'),
            'Access-Control-Allow-Methods'      => 'POST,GET,PUT,DELETE,OPTIONS',
            'Access-Control-Allow-Headers'      => 'Authorization,Content-Type,Accept,Origin,X-Requested-With,Access-Control-Allow-Origin,Access-Control-Allow-Credentials',
            'Access-Control-Allow-Credentials'  => 'true'
        ];

        return Response::make(null, $statusCode, $headers);
    }
});


App::after(function($request, $response)
{
	// Note that you cannot use wildcard domains when doing CORS with Authorization!
    $response->header('Access-Control-Allow-Origin'     , Config::get('app.allowedorigin'));
    $response->header('Access-Control-Allow-Methods'    , 'POST,GET,PUT,DELETE,OPTIONS');
    $response->header('Access-Control-Allow-Headers'    , 'Authorization,Content-Type,Accept,Origin,X-Requested-With,Access-Control-Allow-Origin,Access-Control-Allow-Credentials');
    $response->header('Access-Control-Allow-Credentials', 'true');

});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
Route::filter('auth', function()
{
	if ((Request::getMethod() !== 'OPTIONS') && !Sentry::check()) return Response::json(
							array(
								'error' => true,
								'message' => 'Please log in to continue.'
							),
							401
						);
});


Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


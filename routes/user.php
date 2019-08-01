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
/**
 * @var $api \Dingo\Api\Routing\Router
 */
$api       = app('Dingo\Api\Routing\Router');
$namespace = '\App\Http\Controllers\Users';
$api->version('v1', [
    'namespace'  => $namespace,
    'prefix'     => null,
    'middleware' => [],
    'domain'     => []
], function (\Dingo\Api\Routing\Router $api) {
    $api->group(['middleware' => 'auth:api'], function (\Dingo\Api\Routing\Router $api) {
        $api->post('logout', 'Auth\LoginController@logout');

        $api->get('/user', function (Request $request) {
            return $request->user();
        });

        $api->patch('settings/profile', 'Settings\ProfileController@update');
        $api->patch('settings/password', 'Settings\PasswordController@update');
    });

    $api->group(['middleware' => 'guest:api'], function (\Dingo\Api\Routing\Router $api) {
        $api->post('login', 'Auth\LoginController@login');
        $api->post('register', 'Auth\RegisterController@register');
        $api->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        $api->post('password/reset', 'Auth\ResetPasswordController@reset');
        $api->post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
        $api->post('email/resend', 'Auth\VerificationController@resend');
        $api->post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
        $api->get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');



        $api->post('test', 'HomeController@index');
    });

});

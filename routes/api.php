<?php


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
  $api->group(['middleware' => ['api']], function ($api) {
      //$api->resource('auth', 'App\Http\Controllers\Auth\AuthController');
      $api->post('auth/login', 'App\Http\Controllers\Auth\AuthController@postLogin');
      $api->post('auth/register', 'App\Http\Controllers\Auth\AuthController@postRegister');
      //facebook Oauth api call
      //here we are sending to the server provider, id and the accessToken
      $api->get('auth/{provider}/{accessToken}','App\Http\Controllers\Auth\AuthController@findUserByProviderToken');
      // Password Reset Routes...
      $api->post('password/configure', 'App\Http\Controllers\Auth\AuthController@configurePassword');
      $api->post('auth/password/email', 'App\Http\Controllers\Auth\PasswordResetController@sendResetLinkEmail');
      $api->get('auth/password/verify', 'App\Http\Controllers\Auth\PasswordResetController@verify');
      $api->post('auth/password/reset', 'App\Http\Controllers\Auth\PasswordResetController@reset');
      $api->get('notifications/refresh_token/{userId}/{device_notification_token}', 'App\Http\Controllers\Auth\AuthController@refreshDeviceNotificationToken');
  });

  $api->group(['middleware' => ['api', 'api.auth']], function ($api) {
      $api->get('users/me', 'App\Http\Controllers\UserController@getMe');
      $api->put('users/me', 'App\Http\Controllers\UserController@updateMe');

      });

  $api->group(['middleware' => ['api', 'api.auth', 'role:admin.super|admin.user']], function ($api) {
      //$api->post('users', 'App\Http\Controllers\UserController@postUsers');
      //$api->resource('users', 'App\Http\Controllers\UserController');
      $api->resource('roles', 'App\Http\Controllers\UserRoleController');
      $api->resource('permissions', 'App\Http\Controllers\UserPermissionController');
      $api->resource('users','App\Http\Controllers\UserController');
      //$api->get('users', 'App\Http\Controllers\UserController@index');


  });
})


 ?>

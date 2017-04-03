<?php


  Route::get('/', 'AngularController@serveApp');
  Route::get('/unsupported-browser', 'AngularController@unsupported');
  Route::get('user/verify/{verificationCode}', ['uses' => 'Auth\AuthController@verifyUserEmail']);
  Route::get('auth/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider']);
  Route::get('auth/{provider}/callback', ['uses' => 'Auth\AuthController@handleProviderCallback']);
  Route::get('/api/authenticate/user', 'Auth\AuthController@getAuthenticatedUser');
 ?>

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;
use Hash;
use Illuminate\Http\Request;
use Input;
use Validator;
use JWTAuth;
use Mail;

use App\Notifications\FCMNotification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
/**
 * This controller contains all the provided operations to manage users
 * @Resource("Users", uri="/users")
 */
class UserController extends Controller
{
    /**
     * Get user current context.
     *
     * @return JSON
     */
    public function getMe()
    {
        $user = Auth::user();

        return response()->success($user);
    }

    /**
     * Create new user.
     *
     * @return JSON
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'       => 'required|min:3',
            'email'      => 'required|email|unique:users',
            //'password'   => 'required|min:8|confirmed',
            'password'   => 'required|min:8',
        ]);

                  $notification=new FCMNotification();
                  $verificationCode = str_random(40);

                  $user = new User();
                  $user->name = trim( $request->input('name'));
                  $user->email = trim(strtolower(Input::get('email')));
                  $user->password = bcrypt(Input::get('password'));
                  $user->email_verification_code = $verificationCode;
                  $user->email_verified = 1;
                  // $user->email_verified = 0;
                  $user->save();

                  $token = JWTAuth::fromUser($user);

          /*
                  Mail::send('emails.userverification', ['verificationCode' => $verificationCode], function ($m) use ($request) {
                      $m->to($request->email, 'test')->subject('Confirmez votre mail');
                  });
          */
                  $notification->send($this->getUserDeviceTokens(),'APP and GO: Information',$user->name.' rejoint notre platforme');

                  return response()->success(compact('user', 'token'));


                  /*
                  $user = User::create([
                      'name' => Input::get('name'),
                      'email' => Input::get('email'),
                  ]);

                  return response()->success(compact('user'));
                  */

    }




    /**
     * Update user current context.
     *
     * @return JSON success message
     */
    public function updateMe(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'data.name' => 'required|min:3',
            'data.email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $userForm = app('request')
                    ->only(
                        'data.current_password',
                        'data.new_password',
                        'data.new_password_confirmation',
                        'data.name',
                        'data.email'
                    );

        $userForm = $userForm['data'];
        $user->name = $userForm['name'];
        $user->email = $userForm['email'];

        if ($request->has('data.current_password')) {
            Validator::extend('hashmatch', function ($attribute, $value, $parameters) {
                return Hash::check($value, Auth::user()->password);
            });

            $rules = [
                'data.current_password' => 'required|hashmatch:data.current_password',
                'data.new_password' => 'required|min:8|confirmed',
                'data.new_password_confirmation' => 'required|min:8',
            ];

            $payload = app('request')->only('data.current_password', 'data.new_password', 'data.new_password_confirmation');

            $messages = [
                'hashmatch' => 'Invalid Password',
            ];

            $validator = app('validator')->make($payload, $rules, $messages);

            if ($validator->fails()) {
                return response()->error($validator->errors());
            } else {
                $user->password = Hash::make($userForm['new_password']);
            }
        }

        $user->save();

        return response()->success('success');
    }

    /**
     * Get all users.
     *
     * @return JSON
     */
    public function index()
    {
        $users = User::all();

        return response()->success(compact('users'));
    }

    /**
     * Get user details referenced by id.
     *
     * @param int User ID
     *
     * @return JSON
     */
    public function show($id)
    {
        $user = User::find($id);
        $user['role'] = $user
                        ->roles()
                        ->select(['slug', 'roles.id', 'roles.name'])
                        ->get();

        return response()->success($user);
    }

    /**
     * Update user data.
     *
     * @return JSON success message
     */
    public function update(Request $request)
    {
        $userForm = array_dot(
            app('request')->only(
                'data.name',
                'data.email',
                'data.id'
            )
        );

        $userId = intval($userForm['data.id']);

        $user = User::find($userId);

        $this->validate($request, [
            'data.id' => 'required|integer',
            'data.name' => 'required|min:3',
            'data.email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $userData = [
            'name' => $userForm['data.name'],
            'email' => $userForm['data.email'],
        ];

        $affectedRows = User::where('id', '=', $userId)->update($userData);

        $user->detachAllRoles();

        foreach (Input::get('data.role') as $setRole) {
            $user->attachRole($setRole);
        }

        return response()->success('success');
    }

    /**
     * Delete User Data.
     *
     * @return JSON success message
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->success('success');
    }

  


    private function getUserDeviceTokens(){
      $tokens=array();
      $users = User::all();
      foreach ($users as $user) {
        array_push($tokens,$user->device_notification_token);
      }
      return $tokens;

    }
}

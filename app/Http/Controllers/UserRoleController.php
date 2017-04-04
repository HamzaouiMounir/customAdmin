<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;
use Input;
class UserRoleController extends Controller
{
    /**
     * Get all user roles.
     *
     * @return JSON
     */
    public function index()
    {
      $roles = Role::all();

      return response()->success(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Create new user role.
     *
     * @return JSON
     */
    public function store(Request $request)
    {
        $role = Role::create([
          'name' => Input::get('role'),
          'slug' => str_slug(Input::get('slug'), '.'),
          'description' => Input::get('description'),
      ]);

      return response()->success(compact('role'));
    }

    /**
     * Get role details referenced by id.
     *
     * @param int Role ID
     *
     * @return JSON
     */
    public function show($id)
    {
      $role = Role::find($id);

      $role['permissions'] = $role
                      ->permissions()
                      ->select(['permissions.name', 'permissions.id'])
                      ->get();

      return response()->success($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update role data and assign permission.
     *
     * @return JSON success message
     */
    public function update()
    {
      $roleForm = Input::get('data');
      $roleData = [
          'name' => $roleForm['name'],
          'slug' => $roleForm['slug'],
          'description' => $roleForm['description'],
      ];

      $roleForm['slug'] = str_slug($roleForm['slug'], '.');
      $affectedRows = Role::where('id', '=', intval($roleForm['id']))->update($roleData);
      $role = Role::find($roleForm['id']);

      $role->detachAllPermissions();

      foreach (Input::get('data.permissions') as $setPermission) {
          $role->attachPermission($setPermission);
      }

      return response()->success('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Role::destroy($id);
      return response()->success('success');
    }
}

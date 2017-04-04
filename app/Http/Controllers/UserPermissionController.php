<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ultraware\Roles\Models\Permission;
use Input;
class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permissions = Permission::all();
      return response()->success(compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
      $permission = Permission::create([
          'name' => Input::get('name'),
          'slug' => str_slug(Input::get('slug'), '.'),
          'description' => Input::get('description'),
      ]);

      return response()->success(compact('permission'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $permission = Permission::find($id);

      return response()->success($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
      $permissionForm = Input::get('data');
      $permissionForm['slug'] = str_slug($permissionForm['slug'], '.');
      $affectedRows = Permission::where('id', '=', intval($permissionForm['id']))->update($permissionForm);

      return response()->success($permissionForm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Permission::destroy($id);
      return response()->success('success');
    }
}

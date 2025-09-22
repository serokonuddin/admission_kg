<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        Session::put('activemenu', 'users');
        Session::put('activesubmenu', 'ur');
        $roles = Role::orderBy('name', 'ASC')->paginate(5);
        return view('roles.index', [
            'roles' => $roles
        ]);
        // return view('roles.index', compact('roles'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       if(Auth::user()->group_id!=2){
            return 1;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|min:3',
            'permission' => 'required|array',
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
                return redirect()->route('roles.index')->with('success', 'Role added successfully.');
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $role = $role;
        $rolePermissions = DB::table('role_has_permissions')->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->where('role_id', $role->id)->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table('role_has_permissions')->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->where('role_id', $role->id)->get();
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.edit', compact('role', 'hasPermissions', 'permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        

        //if ($validator->passes()) {

            $role->update($request->only('name'));

            if (!empty($request->get('permission'))) {
                $role->syncPermissions($request->get('permission'));
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        // } else {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        try {
            $role = Role::find($id);
            $role->delete();
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

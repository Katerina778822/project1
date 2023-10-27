<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{

    private $validateArray = [

        'name' => 'required|max:255',
        'permissions' => 'required',
        'permissions.*' => 'required|integer|exists:permissions,id',

    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->where('name', '!=', 'super-user')->get();
        
        return view('role.index', [
            'items' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        $permissions = $permissions->groupBy(function ($permission) {
            // Разделяем строку разрешения на префикс и название
            $parts = explode('.', $permission->name);
            // Возвращаем префикс как ключ для группировки
            return $parts[0];
        });
        return view('role.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate($this->validateArray);

        $newRole = Role::create([
            'name' => $request->name
        ]);
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $newRole->syncPermissions($permissions);

        return redirect()->back()->with('status', 'Role added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::where('name', '!=', 'super-user')->findOrFail($id); //выбираем из всех ролей, кроме супер-юзера
        $permissions = Permission::orderBy('name')->get();
        $permissions = $permissions->groupBy(function ($permission) {
            // Разделяем строку разрешения на префикс и название
            $parts = explode('.', $permission->name);
            // Возвращаем префикс как ключ для группировки
            return $parts[0];
        });
        return view('role.edit', [
            'item' => $role,
            'permissions' => $permissions,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate($this->validateArray);
        $role = Role::where('name', '!=', 'super-user')->findOrFail($id); //выбираем из всех ролей, кроме супер-юзера
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->update($request->all());
        $role->syncPermissions($permissions);

        return redirect()->back()->with('status', 'Role updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::where('name', '!=', 'super-user')->findOrFail($id); //выбираем из всех ролей, кроме супер-юзера
        if (!count($role->users)) {
            // $permissions = Permission::where('name')->get();
            $role->delete();
        } else
            return redirect()->back()->with('status', 'Cannot delete, cos user  with current role still exist!');

        return redirect()->route('role.index')->with('status', 'Role deleted!');
    }
}

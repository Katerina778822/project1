<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\B24User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();

        return view('user.index', [
            'items' => $users,

            //   'id_node' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->where('name', '!=', 'super-user')->get();
        $crmUsers = B24User::orderBy('NAME', 'asc')->where("ACTIVE", 1)->get();
        return view('user.create', [
            'roles' => $roles,
            'crmUsers' => $crmUsers,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'roles' => 'required',
            'roles.*' => 'required|integer|exists:roles,id',
        ]);
        $rController = new RegisteredUserController;
        $rController->store($request);

        return redirect()->back()->with('status', 'User added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::orderBy('name', 'asc')->where('name', '!=', 'super-user')->get();
        $user = User::findOrFail($id);
        $crmUsers = B24User::orderBy('NAME', 'asc')->where("ACTIVE", 1)->get();
        $currentRoles = $user->roles()->get()->pluck('id');

        return view('user.edit', [
            'item' => $user,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
            'crmUsers' => $crmUsers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if (!$user->hasRole('super-user')) //валидация роли для супер-юзера не делается
            $validator = $request->validate([
                'roles' => 'required',
                'roles.*' => 'required|integer|exists:roles,id',
            ]);
        $validator = $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:45|unique:App\Models\User,email,' . $id,
            'crmuser_id' => 'integer|min:0|nullable',
            'business_id' => 'integer|min:0|nullable',
        ]);
        $password = null;
        if (!empty($request->password)) {
            $validator = $request->validate([
                'password' => ['required', 'string', 'min:5'],  // geleonn
                'password_confirmation' => ['required', 'same:password', 'string', 'min:5'],  // geleonn
            ]);
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->crmuser_id = $request->crmuser_id;
        $user->business_id = $request->business_id;
        $user->email = $request->email;
        $user->password = $password;
        $user->save();
        //update roles
        if (!$user->hasRole('super-user')) //присваивание роли для супер-юзера не делается
            if (!empty($request->roles)) {
                $user->syncRoles([]);
                foreach ($request->roles as $id) {
                    $role = Role::findOrFail($id);
                    $user->assignRole($role->name);
                }
            } else
                $user->assignRole('user');

        return redirect()->back()->with('status', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('status', 'User deleted!');
    }
}

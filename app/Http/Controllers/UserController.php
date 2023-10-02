<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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

        $user = User::findOrFail($id);

        return view('user.edit', [
            'item' => $user,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validator = $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:45|unique:App\Models\User,email,'. $id,
            'crmuser_id' => 'integer|min:0|nullable',
            //'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],  // Geleon7
            'password' => ['required', 'string', 'min:5'],  // geleonn
            'password_confirmation' => ['required', 'same:password', 'string', 'min:5'],  // geleonn
        ]);
   
        $user->update($request->all());

        return redirect()->back()->with('status', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted!');
    }
}

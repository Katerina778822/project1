<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Role;
use App\Http\Requests\RegisterRequest;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:25',
                'email' => 'required|string|email|max:255',
                'business_id' => 'integer|min:0',
                //'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],  // Geleon7
                'password' => ['required', 'string', 'min:8'],  // geleonn

            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'business_id' => $request->business_id ?? null,
                'password' => Hash::make($request->password),
            ]);

            $users = User::with('roles')->get();
            $hasAdminRole = false;
            foreach ($users as $cur_user) {

                foreach ($cur_user->roles as $role) {

                    if ($role->slug == 'admin') {
                        $hasAdminRole = true;
                        break;
                    }
                }
            }
            if (!$hasAdminRole) {

                $adminRole = Role::where('slug', 'admin')->first();

                $user->roles()->attach($adminRole);
            } else {
                $userRole = Role::where('slug', 'user')->first();

                $user->roles()->attach($userRole);
            }
        } catch (\Exception $e) {
            log($e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}

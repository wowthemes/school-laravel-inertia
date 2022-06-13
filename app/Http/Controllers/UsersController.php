<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        $search = $request->get('search');

        $users = User::orderBy('created_at', 'DESC');
        if ($search) {
            $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');

        }
        $users = $users->paginate($per_page);

        $users = array_merge($users->toArray(), [
            'items_per_page' => (int)$per_page,
            'search' => $search,
        ]);

        return Inertia::render('Users/Index', $users);
    }


    public function create(Request $request)
    {
        return Inertia::render('Users/CreateOrEdit', [
            'head_title'    => __('Create new User'),
            'user'  => []
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', 'unique:users,email'],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->get('avatar')) {
            $user->attachments()->sync( $request->get('avatar') );
        }

        return redirect()->route('users.index');
    }


    public function edit(User $user, Request $request)
    {
        return Inertia::render('Users/CreateOrEdit', [
            'head_title'    => sprintf('Edit %s', $user->name),
            'user'          => $user,
            'new_user'      => false
        ]);
    }

    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
        ]);
        // dd($request->name);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        if ($request->get('avatar')) {
            $user->attachments()->sync( $request->get('avatar') );
        }
        return redirect()->route('users.index');
    }

    public function delete(User $user) {
        $user->delete();

        return redirect()->route('users.index')->with('message', sprintf('User %s has been deleted', $user->name));
    }

    public function changePassword(User $user, Request $request)
    {
        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Invalid current password']);
        }
        $request->validate([
            // 'current_password'  => 'current_password',
            'password'  => [
                'required', 
                'confirmed', 
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            // 'password_confirmation ' => '',
        ]);

        $user->password = Hash::make( $request->password );
        $user->save();
        return redirect()->back()->with('message', 'Password has been updated');
    }
}

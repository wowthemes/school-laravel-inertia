<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

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
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', 'unique:users,email'],
            'password' => ['required', 'max:50', 'min:10', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index');
    }
}

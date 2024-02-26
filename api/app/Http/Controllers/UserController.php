<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index () {
        $user = auth()->user();

        return User::where('id', '<>', $user->id)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store (Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return response()->json([
            'message' => 'User created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show (User $user) {
        return response()->json(compact('user'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request, User $user) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'present', 'string', 'min:8', 'confirmed']
        ]);

        if ($data['password']) {
            $user->password = Hash::make($data['password']);
        }

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->save();

        return response()->json([
            'message' => 'User updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy (User $user) {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully!'
        ], 200);
    }
}
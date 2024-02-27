<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user with given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register (Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'min:3', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = new User;
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $token = auth()->attempt($data);

        return response()->json([
            'access_token' => $token,
            'message' => 'User registered successfully!',
        ], 200);
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login (Request $request) {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'exists:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (!$token = auth()->attempt($data)) {
            return response()->json([
                'errors' => [
                    'password' => ['Wrong password']
                ]
            ], 422);
        }

        return response()->json([
            'access_token' => $token,
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check () {
        $user = auth()->user();

        return response()->json(compact('user'), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout () {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh () {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken ($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }
}
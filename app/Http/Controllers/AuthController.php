<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        return response()->json([
            'message' => 'Registro de usuario con exito',
            'data' => $user,
        ]);
    }
}

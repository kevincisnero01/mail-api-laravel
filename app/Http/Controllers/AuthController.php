<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'message' => 'Registro de usuario con éxito',
            'data' => $user,
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:30'
        ]);

        if(Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Inicio de sesión con éxito',
                'token' => $request->user()->createToken($request->email)->plainTextToken
            ]);

        };

        return response()->json([
            'message' => 'Las credenciales proporcionadas no coinciden con nuestros registros',
        ],401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Cierre de sesión con éxito',
        ]);
    }


}

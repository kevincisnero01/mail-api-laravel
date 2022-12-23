<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function send_email(Request $request) {

        $credentials = $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($credentials);

        if($status === Password::RESET_LINK_SENT){
            $status = ['message' => __($status)];
        }else{
            $status = [
                "message" => "Los datos proporcionados no son válidos",
                'errors' => ['email' => __($status)],
            ];
        }

        return response()->json($status);
    }

    public function get_token($token)
    {
        return response()->json([
            'message' => 'Token necesario para recuperar la contraseña del usuario.',
            'token' => $token
        ]);
    }

    public function reset_update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET){
            $status = ['message' => __($status)];
        }else{
            $status = [
                "message" => "Los datos proporcionados no son válidos",
                'errors' => ['email' => __($status)],
            ];
        }

        return response()->json($status);
    }

}



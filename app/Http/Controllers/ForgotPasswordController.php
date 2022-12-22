<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function send_email(Request $request) {

        $credentials = $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($credentials);

        if($status === Password::RESET_LINK_SENT){
            $status = ['message' => __($status)];
        } else{
            $status = [
                "message" => __("The given data was invalid."),
                'errors' => ['email' => __($status)],
            ];
        }

        return response()->json($status);
    }
}



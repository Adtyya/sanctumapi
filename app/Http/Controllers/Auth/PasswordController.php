<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class PasswordController extends Controller
{
    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                        ?   response()->json([
                            'status' => 'Password reset link sent!'])
                        : response()->json([
                            'error' => 'Email not found, please register instead'
                        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
            'email' => 'required|email'
        ]);
        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function($user,$password){
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                        ? response()->json([
                            'msg' => 'Succes'
                        ])
                        : response()->json([
                            'msg' => 'an error occured'
                        ]);
    }
}

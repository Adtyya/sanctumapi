<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function verify($id)
    {
        $user = User::findOrFail($id);
        if(!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return request()->wantsJson()
            ? new JsonResponse('', 204)
            : redirect(url(env('FRONT_END_APP')));
        }
        return redirect(url(env('FRONT_END_APP')));
    }
    public function send($id)
    {
        $user = User::find($id);
        $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Email verification successfully send! Please check your email inbox or spam.'
        ]);
    }
}

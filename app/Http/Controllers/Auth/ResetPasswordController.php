<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->senha = Hash::make($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Redefinição de senha com sucesso.'])
            : response()->json(['email' => [trans($response)]], 422);
    }
}

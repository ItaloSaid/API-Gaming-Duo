<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        // Verificar se o email existe e a senha está correta
        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!$usuario || !Hash::check($credentials['senha'], $usuario->senha)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Aqui você pode implementar a geração de um token ou sessão conforme sua preferência
        // Exemplo com Sanctum para API Token
        $token = $usuario->createToken('authToken')->plainTextToken;

        return response()->json(['usuario' => $usuario, 'token' => $token]);
    }
}
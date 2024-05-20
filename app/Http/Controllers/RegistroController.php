<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,username',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:6'
        ]);
        

        $usuario = Usuario::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'senha' => Hash::make($validatedData['senha']),
        ]);

        return response()->json(['usuario' => $usuario], 201);
    }
}
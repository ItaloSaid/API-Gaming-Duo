<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        return response()->json(['usuario' => $usuario], 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        

        $validatedData = $request->validate([
            'username' => 'string|max:255|unique:usuarios,username,' . $id,
            'email' => 'email|unique:usuarios,email,' . $id,
            'senha' => 'min:6'
        ]);

        if (isset($validatedData['senha'])) {
            $validatedData['senha'] = Hash::make($validatedData['senha']);
        }

        $usuario->update($validatedData);

        return response()->json(['usuario' => $usuario], 200);
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ValorantController extends Controller
{
    public function updateValorantStats(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'jogador' => 'required|string',
                'rank' => 'required|string',
                'agente_preferido' => 'nullable|string',
                'funcao_preferida' => 'nullable|string',
            ]);

            $user = Auth::user();

            $user->jogador = $validatedData['jogador'];
            $user->rank = $validatedData['rank'];
            $user->agente_preferido = $validatedData['agente_preferido'];
            $user->funcao_preferida = $validatedData['funcao_preferida'];
            $user->save();

            return response()->json(['message' => 'Estatísticas do Valorant atualizadas com sucesso.'], 200);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar as estatísticas do Valorant: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar as estatísticas do Valorant.'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ValorantStat;
use Illuminate\Support\Facades\Auth;

class ValorantController extends Controller
{
    public function storeValorantStats(Request $request)
    {
        $validatedData = $request->validate([
            'jogador' => 'required|string|max:255',
            'rank' => 'nullable|string|max:255',
            'agente_preferido' => 'nullable|string|max:255',
            'funcao_preferida' => 'nullable|string|max:255',
        ]);

        $valorantStat = ValorantStat::create([
            'user_id' => Auth::id(),
            'jogador' => $validatedData['jogador'],
            'rank' => $validatedData['rank'],
            'agente_preferido' => $validatedData['agente_preferido'],
            'funcao_preferida' => $validatedData['funcao_preferida'],
        ]);

        return response()->json(['valorantStat' => $valorantStat], 201);
    }

    public function recommendedByRank(Request $request)
    {
        $validatedData = $request->validate([
            'rank' => 'required|string|max:255',
        ]);

        $rank = $validatedData['rank'];

        $recommendedUsers = ValorantStat::where('rank', $rank)
            ->where('user_id', '!=', Auth::id())
            ->get();

        return response()->json(['recommendedUsers' => $recommendedUsers], 200);
    }

    public function filterByRankAndRole(Request $request)
    {
        $validatedData = $request->validate([
            'rank' => 'required|string|max:255',
            'funcao_preferida' => 'required|string|max:255',
        ]);

        $rank = $validatedData['rank'];
        $funcao_preferida = $validatedData['funcao_preferida'];

        $roles = ['Controlador', 'Sentinela', 'Duelista', 'Iniciador'];
        
        // Remove the user's role from the array
        $filteredRoles = array_filter($roles, function($role) use ($funcao_preferida) {
            return $role !== $funcao_preferida;
        });

        $recommendedUsers = ValorantStat::where('rank', $rank)
            ->whereIn('funcao_preferida', $filteredRoles)
            ->where('user_id', '!=', Auth::id())
            ->get();

        return response()->json(['recommendedUsers' => $recommendedUsers], 200);
    }
}



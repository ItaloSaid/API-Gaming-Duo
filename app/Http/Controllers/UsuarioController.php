<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function show()
    {
        return response()->json(['usuario' => Auth::user()]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/avatars');
            $image->move($destinationPath, $name);

            if ($user->avatar) {
                $oldAvatarPath = public_path('/avatars/' . $user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $user->avatar = $name;
            $user->save();

            return response()->json(['success' => true, 'avatar' => $name, 'avatar_url' => url('/avatars/' . $name)]);
        }

        return response()->json(['success' => false], 400);
    }

    public function update(Request $request, $id)
    {
        $user = Usuario::findOrFail($id);

        $rules = [];
        if ($request->has('email')) {
            $rules['email'] = 'required|email|unique:usuarios,email,' . $user->id;
        }
        if ($request->has('senha')) {
            $rules['senha'] = 'nullable|min:6|confirmed';
        }
        if ($request->has('gamename')) {
            $rules['gamename'] = 'required';
        }
        if ($request->has('rank')) {
            $rules['rank'] = 'required';
        }
        if ($request->has('preferred_agent')) {
            $rules['preferred_agent'] = 'required';
        }
        if ($request->has('preferred_function')) {
            $rules['preferred_function'] = 'required';
        }

        $request->validate($rules);

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('senha')) {
            $user->senha = Hash::make($request->senha);
        }

        if ($request->filled('gamename')) {
            $user->gamename = $request->gamename;
        }

        if ($request->filled('rank')) {
            $user->rank = $request->rank;
        }

        if ($request->filled('preferred_agent')) {
            $user->preferred_agent = $request->preferred_agent;
        }

        if ($request->filled('preferred_function')) {
            $user->preferred_function = $request->preferred_function;
        }

        $user->save();

        return response()->json(['success' => true, 'usuario' => $user]);
    }

    public function recommended(Request $request)
    {
        $user = Auth::user();

        $elos = [
            'Ferro I', 'Ferro II', 'Ferro III',
            'Bronze I', 'Bronze II', 'Bronze III',
            'Prata I', 'Prata II', 'Prata III',
            'Ouro I', 'Ouro II', 'Ouro III',
            'Platina I', 'Platina II', 'Platina III',
            'Diamante I', 'Diamante II', 'Diamante III',
            'Ascendente I', 'Ascendente II', 'Ascendente III',
            'Imortal I', 'Imortal II', 'Imortal III',
            'Radiante'
        ];

        $currentEloIndex = array_search($user->rank, $elos);

        $lowerEloIndex = max(0, $currentEloIndex - 1);
        $upperEloIndex = min(count($elos) - 1, $currentEloIndex + 1);

        $desiredElos = array_slice($elos, $lowerEloIndex, $upperEloIndex - $lowerEloIndex + 1);

        $functionMap = [
            'Duelista' => ['Controlador', 'Iniciador', 'Sentinela'],
            'Controlador' => ['Duelista', 'Iniciador', 'Sentinela'],
            'Iniciador' => ['Duelista', 'Controlador', 'Sentinela'],
            'Sentinela' => ['Duelista', 'Controlador', 'Iniciador']
        ];

        $desiredFunctions = $functionMap[$user->preferred_function] ?? ['Duelista', 'Controlador', 'Iniciador', 'Sentinela'];

        $recommendedPlayers = Usuario::whereIn('rank', $desiredElos)
            ->where('id', '!=', $user->id)
            ->whereIn('preferred_function', $desiredFunctions)
            ->get();

        return response()->json($recommendedPlayers);
    }


    public function filter(Request $request)
    {
        $user = Auth::user();
        $filters = $request->only(['ranking', 'role']);
        $filteredPlayers = Usuario::where(function ($query) use ($filters, $user) {
            if ($filters['ranking'] && $filters['ranking'] !== 'Não Selecionado') {
                $query->where('rank', $filters['ranking']);
            }
            if ($filters['role'] && $filters['role'] !== 'Não Selecionado') {
                $query->where('preferred_function', $filters['role']);
            }
            $query->where('id', '!=', $user->id);
        })->get();

        return response()->json($filteredPlayers);
    }
}


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
        return response()->json([
            'usuario' => Auth::user()
        ]);
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

        $user->save();

        return response()->json(['success' => true, 'usuario' => $user]);
    }
}

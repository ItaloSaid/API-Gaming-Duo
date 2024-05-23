<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function show()
    {
        return response()->json([
            'usuario' => Auth::user()
        ]);
    }
}

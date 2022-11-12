<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Services\UsuarioService;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function mostrar($id)
    {
        $usuarioService = new UsuarioService();

        return $usuarioService->verUsuario($id);
    }
}

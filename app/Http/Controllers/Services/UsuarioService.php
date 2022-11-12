<?php

namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Animal;
use App\Models\Users;

class UsuarioService
{
    public function __construct(){}


    public function editarUsuario($dados)
    {
        $animal = Animal::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($animal->usuario);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $animal->apelido = $dados['apelido'];
        $animal->descricao = $dados['descricao'];
        $animal->tipo = $dados['tipo'];

        if(!empty($dados['foto'])){
            //codigo para colocar foto no s3
        }
        $animal->update();

        return response()->json([
            "animal" => $animal
        ]);
    }

    public function verUsuario($id)
    {
        $usuario = Users::with('endereco')
            ->findOrFail($id);

        return response()->json([
            'usuario' => $usuario
        ]);
    }

    public function listarAnimais()
    {
        $animais = Animal::with('tipo:id,titulo')->where('usuario', auth()->user()->id)->get();

        return response()->json([
            "animais" => $animais
        ]);
    }

    public function deletarAnimal($dados)
    {
        $animal = Animal::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($animal->usuario);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $animal->delete();

        return response()->json([], 200);
    }
}

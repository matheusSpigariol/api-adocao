<?php

namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Animal;

class AnimalService
{
    public function __construct(){}

    public function criarAnimal($dados)
    {
        $animal = Animal::create([
            'apelido' => $dados['apelido'],
            'descricao' => $dados['descricao'],
            'usuario' => auth()->user()->id,
            'tipo' => $dados['tipo'],
            'sexo' => $dados['sexo'],
            'ano' => $dados['ano'],
            'mes' => $dados['mes'],
        ]);

        if(!empty($dados['foto'])){
            //codigo para colocar imagem no s3
        }

        return response()->json([
            "id" => $animal->id
        ], 201);
    }

    public function editarAnimal($dados)
    {
        $animal = Animal::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($animal->usuario);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $animal->apelido = $dados['apelido'];
        $animal->descricao = $dados['descricao'];
        $animal->tipo = $dados['tipo'];
        $animal->sexo = $dados['sexo'];
        $animal->ano = $dados['ano'];
        $animal->mes = $dados['mes'];

        if(!empty($dados['foto'])){
            //codigo para colocar foto no s3
        }
        $animal->update();

        return response()->json([
            "animal" => $animal
        ]);
    }

    public function verAnimal($id)
    {
        $animal = Animal::with('tipo:id,titulo', 'publicacoes')
            ->findOrFail($id);

        return response()->json([
            'animal' => $animal
        ]);
    }
    
    public function listarAnimais()
    {
        $animais = Animal::with('tipo:id,titulo')->where('usuario', auth()->user()->id)->paginate(10);

        return response()->json([
            "animais" => $animais
        ]);
    }

    public function deletarAnimal($id)
    {
        $animal = Animal::findOrFail($id);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($animal->usuario);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $animal->delete();

        return response()->json([], 200);
    }
}

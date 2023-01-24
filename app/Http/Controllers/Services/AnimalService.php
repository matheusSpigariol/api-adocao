<?php

namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Animal;
use App\Models\TipoAnimal;

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
    
    public function listarAnimais($filtros)
    {
        $animais = Animal::select('animal.*')
            ->with('tipo:id,titulo')
            ->orderBy('apelido', 'ASC');

        if(!empty($filtros['apelido'])){
            $animais = $animais->where('apelido', 'like', '%'. $filtros['apelido']. '%');
        }

        if(!empty($filtros['cidade'])){
            $animais = $animais->leftJoin('users', 'animal.usuario', '=', 'users.id')
                ->leftJoin('endereco', 'users.endereco', '=', 'endereco.id')
                ->where('endereco.cidade', 'like', '%'. $filtros['cidade']. '%');
        }

        if(!empty($filtros['tipo'])){
            $animais = $animais->leftJoin('tipo_animal', 'animal.tipo', '=', 'tipo_animal.id')
                ->where('tipo_animal.id', $filtros['tipo']);
        }

        
        $animais = $animais->paginate(10);

        return response()->json([
            "animais" => $animais
        ]);
    }

    public function listarTiposAnimais()
    {
        $tiposAnimais = TipoAnimal::select('id', 'titulo')
            ->get();

        return response()->json([
            "tipos" => $tiposAnimais
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

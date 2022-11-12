<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\AnimalService;
use App\Http\Requests\FormularioAnimalRequest;

class AnimalController extends Controller
{
    public function criar(FormularioAnimalRequest $request)
    {
        $dados = $request->all();
        $animalService = new AnimalService();

        return $animalService->criarAnimal($dados);
    }

    public function editar(FormularioAnimalRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $animalService = new AnimalService();

        return $animalService->editarAnimal($dados);
    }

    public function mostrar($id)
    {
        $animalService = new AnimalService();

        return $animalService->verAnimal($id);
    }

    public function listar()
    {
        $animalService = new AnimalService();

        return $animalService->listarAnimais();
    }

    public function deletar($id)
    {
        $animalService = new AnimalService();

        return $animalService->deletarAnimal($id);
    }
}

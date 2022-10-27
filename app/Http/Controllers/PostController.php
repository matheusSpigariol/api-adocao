<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PostService;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function criar(PostRequest $request)
    {
        $dados = $request->all();
        $objFreteService = new PostService();

        return $objFreteService->cadastrarPost($dados); 
    }

    public function editar(PostRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $objFreteService = new PostService();

        return $objFreteService->editaPost($dados); 
    }

    public function mostar($id)
    {
        $dados['id'] = $id;
        $objFreteService = new PostService();

        return $objFreteService->verPost($dados); 
    }

    public function listar()
    {
        $objFreteService = new PostService();

        return $objFreteService->listarPosts(); 
    }

    public function deletar($id)
    {
        $dados['id'] = $id;
        $objFreteService = new PostService();

        return $objFreteService->deletarPost($dados); 
    }
}

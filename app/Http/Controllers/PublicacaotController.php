<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PublicacaoService;
use App\Http\Requests\PublicacaoRequest;

class PublicacaotController extends Controller
{
    public function criar(PublicacaoRequest $request)
    {
        $dados = $request->all();
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->cadastrarPublicacao($dados); 
    }

    public function editar(PublicacaoRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->editaPublicacao($dados); 
    }

    public function mostar($id)
    {
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->verPublicacao($dados); 
    }

    public function listar()
    {
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->listarPublicacao(); 
    }

    public function deletar($id)
    {
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->deletarPublicacao($dados); 
    }
}

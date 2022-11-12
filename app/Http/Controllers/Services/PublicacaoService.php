<?php
namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Publicacao;

class PublicacaoService
{
    public function __construct(){}

    public function cadastrarPublicacao($dados)
    {
        $publicacao = Publicacao::create([
            'descricao' => $dados["descricao"],
            'usuario' => auth()->user()->id,
            'latitude' => $dados['latitude'],
            'longitude' => $dados['longitude']
        ]);

        return response()->json([
            "id" => $publicacao->id
        ], 201);
    }

    public function editaPublicacao($dados)
    {
        $publicacao = Publicacao::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($publicacao->user);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $publicacao->descricao = $dados["descricao"];
        $publicacao->altitude = $dados["altitude"];
        $publicacao->longitude = $dados["longitude"];

        $publicacao->update();

        return response()->json([
            'publicacao' => $publicacao
        ], 200);
    }

    public function verPublicacao($dados)
    {
        $publicacao = Publicacao::findOrFail($dados['id']);

        return response()->json([
            'publicacao' => $publicacao
        ],200);
    }

    public function listarPublicacao()
    {
        $publicacoes = Publicacao::get();

        return response()->json([
            'publicacoes' => $publicacoes
        ], 200);
    }

    public function deletarPublicacao($dados)
    {
        $publicacao = Publicacao::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($publicacao->user);
        
        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $publicacao->delete();

        return response()->json([], 200);
    }
}
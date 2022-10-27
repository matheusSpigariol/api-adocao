<?php
namespace App\Http\Controllers\Services;

use App\Models\Post;

class PostService
{
    public function __construct(){}

    public function cadastrarPost($dados)
    {
        $post = Post::create([
            'description' => $dados["description"],
            'user' => auth()->user()->id
        ]);

        return response()->json([
            "id" => $post->id
        ], 201);
    }

    public function editaPost($dados)
    {
        $post = Post::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = $this->__verificaAuth($post->user);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $post->description = $dados["description"];
        $post->update();

        return response()->json([
            'post' => $post
        ], 200);
    }

    public function verPost($dados)
    {
        $post = Post::findOrFail($dados['id']);

        return response()->json([
            'post' => $post
        ],200);
    }

    public function listarPosts()
    {
        $posts = Post::get();

        return response()->json([
            'posts' => $posts
        ], 200);
    }

    public function deletarPost($dados)
    {
        $post = Post::findOrFail($dados['id']);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $post->delete();

        return response()->json([], 200);
    }

    private function __verificaAuth($dado)
    {
        if($dado!= auth()->user()->id)
            return response()->json(["error" => "Você não possuí autorização para isso."], 401);

        return [];
    }
}
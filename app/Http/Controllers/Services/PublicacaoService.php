<?php
namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Animal;
use App\Models\Publicacao;
use Illuminate\Support\Facades\Storage;

class PublicacaoService
{
    public function __construct(){}

    public function cadastrarPublicacao($dados)
    {
        $nomeArquivo = null;
        if($dados['foto']){
            $nomeArquivo = date('Ymdhis') . '-' . $dados['foto']->getClientOriginalName();
            $dados['foto']->storeAs('publicacoes/fotos/', $nomeArquivo, 's3');
            $urlnomeArquivo = Storage::disk('s3')->url("publicacoes/fotos/" . $nomeArquivo);
        }

        $publicacao = Publicacao::create([
            'descricao' => $dados["descricao"],
            'usuario' => auth()->user()->id,
            'foto' => $urlnomeArquivo
        ]);

        if($dados['animais']){
            $publicacao->animais()->sync($dados['animais']);
        }

        return response()->json([
            "id" => $publicacao->id
        ], 201);
    }

    public function editaPublicacao($dados)
    {
        $publicacao = Publicacao::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($publicacao->usuario);

        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        if(!empty($dados['foto'])){
            if ($publicacao->foto != null) {
                $deletarArquivo = explode('.com/', $publicacao->foto);
                Storage::disk('s3')->delete(str_replace('%20', ' ', $deletarArquivo[1]));
            }

            $nomeArquivo = date('Ymdhis') . '-' . $dados['foto']->getClientOriginalName();
            $dados['foto']->storeAs('publicacoes/fotos/', $nomeArquivo, 's3');
            $urlnomeArquivo = Storage::disk('s3')->url("publicacoes/fotos/" . $nomeArquivo);
            $publicacao->foto = $urlnomeArquivo;
        }

        $publicacao->descricao = $dados["descricao"];

        $publicacao->update();

        $publicacao->animais()->sync(!empty($dados['animais']) ? $dados['animais'] : []);

        return response()->json([
            'publicacao' => $publicacao
        ], 200);
    }

    public function verPublicacao($dados)
    {
        $publicacao = Publicacao::with('animais:id,apelido,descricao,foto')
            ->findOrFail($dados['id']);

        return response()->json([
            'publicacao' => $publicacao
        ],200);
    }

    public function listarPublicacao($filtros)
    {
        $publicacoes = Publicacao::select()
            ->with('animais:id,apelido,descricao,foto', 'usuario:id,name,endereco', 'usuario.endereco:id,rua,numero,bairro,cidade,estado');

        if(!empty($filtros['descricao'])){
            $publicacoes = $publicacoes->where('descricao', 'like', '%'.$filtros['descricao'].'%');
        }

        if(!empty($filtros['cidade'])){
            $publicacoes = $publicacoes->leftJoin('users', 'publicacao.usuario', '=', 'users.id')
                ->leftJoin('endereco', 'users.endereco', '=', 'endereco.id')
                ->where('endereco.cidade', 'like', '%'. $filtros['cidade']. '%');
        }

        $publicacoes = $publicacoes->paginate(10);

        return response()->json([
            'publicacoes' => $publicacoes
        ], 200);
    }

    public function deletarPublicacao($dados)
    {
        $publicacao = Publicacao::findOrFail($dados['id']);

        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($publicacao->usuario);
        
        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;

        $publicacao->animais()->sync([]);

        $publicacao->delete();

        return response()->json([], 200);
    }
}
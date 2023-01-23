<?php

namespace App\Http\Controllers\Services;

use App\Helpers\AuthHelper;
use App\Models\Endereco;
use App\Models\Users;
use Illuminate\Support\Facades\Storage;

class UsuarioService
{
    public function __construct(){}


    public function editarUsuario($dados)
    {
        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($dados['id']);
        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;
        
        $usuario = Users::findOrFail($dados['id']);

        $usuario->name = $dados['nome'];
        $usuario->email = $dados['email'];

        if(!empty($dados['foto'])){
            if ($usuario->foto != null) {
                $deletarArquivo = explode('.com/', $usuario->foto);
                Storage::disk('s3')->delete(str_replace('%20', ' ', $deletarArquivo[1]));
            }

            $nomeArquivo = date('Ymdhis') . '-' . $dados['foto']->getClientOriginalName();
            $dados['foto']->storeAs('usuarios/fotos/', $nomeArquivo, 's3');
            $urlnomeArquivo = Storage::disk('s3')->url("usuarios/fotos/" . $nomeArquivo);
            $usuario->foto = $urlnomeArquivo;
        }

        $usuario->update();

        return response()->json([
            "usuario" => $usuario
        ]);
    }

    public function editarEndereco($dados)
    {
        $respostaUsuarioAutenticado = AuthHelper::verificaAuth($dados['id']);
        if(!empty($respostaUsuarioAutenticado)) 
            return $respostaUsuarioAutenticado;
        
        $usuario = Users::findOrFail($dados['id']);
        $endereco = Endereco::findOrFail($usuario->endereco);

        $endereco->rua = $dados['rua'];
        $endereco->numero = $dados['numero'];
        $endereco->complemento = $dados['complemento'];
        $endereco->bairro = $dados['bairro'];
        $endereco->cidade = $dados['cidade'];
        $endereco->estado = $dados['estado'];
        $endereco->cep = $dados['cep'];

        $endereco->update();

        return response()->json([
            "endereço" => $endereco
        ]);
    }
    
    public function verUsuario($id)
    {
        $usuario = Users::select(
            'id',
            'name',
            'email',
            'endereco',
            'foto'
        )
            ->with('endereco')
            ->findOrFail($id);

        return response()->json([
            'usuario' => $usuario
        ]);
    }

    public function listarUsuarios()
    {
        $usuarios = Users::select(
            'id',
            'name',
            'email',
            'foto',
            'endereco'
        )
        ->with('endereco')
        ->paginate(10);

        return response()->json([
            "usuarios" => $usuarios
        ]);
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Services\UsuarioService;
use App\Http\Requests\UsuarioEnderecoRequest;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
     
    /**
     * @OA\Get(
     * path="/api/animal/{idUsuario}",
     * summary="Mostrar usuario",
     * description="Consultar informações do usuario",
     * operationId="mostrarUsuario",
     * tags={"Usuarios"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idUsuario",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="usuario",
     *           type="object",
     *            @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Matheus Eduardo",
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="string",
     *              example="contato.matheused@gmail.com",
     *           ),
     *           @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
     *           ),
     *          @OA\Property(
     *              property="endereco",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="rua",
     *                  type="string",
     *                  example="João dos Santos",
     *              ),
     *              @OA\Property(
     *                  property="numero",
     *                  type="integer",
     *                  example="231",
     *              ),
     *              @OA\Property(
     *                  property="complemento",
     *                  type="string",
     *                  example="null",
     *              ),
     *              @OA\Property(
     *                  property="bairro",
     *                  type="string",
     *                  example="Ipê",
     *              ),
     *              @OA\Property(
     *                  property="cidade",
     *                  type="string",
     *                  example="Poços de Caldas",
     *              ),
     *              @OA\Property(
     *                  property="estado",
     *                  type="string",
     *                  example="Minas Gerais",
     *              ),
     *              @OA\Property(
     *                  property="cep",
     *                  type="string",
     *                  example="37704205",
     *              ),
     *          ),
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não autorizado"),
     *    )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Animal não encontrado",
     * ),
     * )
     */
    
    public function mostrar($id)
    {
        $usuarioService = new UsuarioService();

        return $usuarioService->verUsuario($id);
    }


    /**
     * @OA\Get(
     * path="/api/usuario",
     * summary="Listagem de usuarios",
     * description="Lista com paginação de todos os usuarios.",
     * operationId="listarUsuarios",
     * tags={"Usuarios"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     * @OA\Parameter(
     *   name="page",
     *   in="query",
     *   description="Buscar por numero de paginação",
     * ),
     * @OA\Parameter(
     *   name="nome",
     *   in="query",
     *   description="Buscar pelo nome do usuário",
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successo!",
     *    @OA\JsonContent(
     *      @OA\Property(property="current_page", type="integer", example="1"),
     *            @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Matheus Eduardo",
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="string",
     *              example="contato.matheused@gmail.com",
     *           ),
     *           @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
     *           ),
     *          @OA\Property(
     *              property="endereco",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="rua",
     *                  type="string",
     *                  example="João dos Santos",
     *              ),
     *              @OA\Property(
     *                  property="numero",
     *                  type="integer",
     *                  example="231",
     *              ),
     *              @OA\Property(
     *                  property="complemento",
     *                  type="string",
     *                  example="null",
     *              ),
     *              @OA\Property(
     *                  property="bairro",
     *                  type="string",
     *                  example="Ipê",
     *              ),
     *              @OA\Property(
     *                  property="cidade",
     *                  type="string",
     *                  example="Poços de Caldas",
     *              ),
     *              @OA\Property(
     *                  property="estado",
     *                  type="string",
     *                  example="Minas Gerais",
     *              ),
     *              @OA\Property(
     *                  property="cep",
     *                  type="string",
     *                  example="37704205",
     *              ),
     *          ),
     *      )
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não autorizado"),
     *    )
     * ),
     * )
     */

    public function listar(Request $request)
    {
        $dados = $request->all();
        $usuarioService = new UsuarioService();

        return $usuarioService->listarUsuarios($dados);
    }

    /**
     * @OA\Post(
     * path="/api/usuario/{id}",
     * summary="Editar usuário",
     * description="Editar informações do usuário",
     * operationId="editarUsuario",
     * tags={"Usuarios"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="id",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do usuario",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *          required={
     *              "nome", "email"
     *          },
     *          @OA\Property(property="nome", type="string"),
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="foto", type="file"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="usuario",
     *           type="object",
     *            @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Matheus Eduardo",
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="string",
     *              example="contato.matheused@gmail.com",
     *           ),
     *           @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
     *           ),
     *          @OA\Property(
     *              property="endereco",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="rua",
     *                  type="string",
     *                  example="João dos Santos",
     *              ),
     *              @OA\Property(
     *                  property="numero",
     *                  type="integer",
     *                  example="231",
     *              ),
     *              @OA\Property(
     *                  property="complemento",
     *                  type="string",
     *                  example="null",
     *              ),
     *              @OA\Property(
     *                  property="bairro",
     *                  type="string",
     *                  example="Ipê",
     *              ),
     *              @OA\Property(
     *                  property="cidade",
     *                  type="string",
     *                  example="Poços de Caldas",
     *              ),
     *              @OA\Property(
     *                  property="estado",
     *                  type="string",
     *                  example="Minas Gerais",
     *              ),
     *              @OA\Property(
     *                  property="cep",
     *                  type="string",
     *                  example="37704205",
     *              ),
     *          ),
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não autorizado"),
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Conteúdo não processável",
     *    @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="Os dados fornecidos não são válidos."),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *              property="Nome",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo nome é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo email é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */

    public function editar(UsuarioRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $usuarioService = new UsuarioService();

        return $usuarioService->editarUsuario($dados);
    }

    /**
     * @OA\Put(
     * path="/api/usuario/endereco/{id}",
     * summary="Editar endereco",
     * description="Editar endereco do usuário",
     * operationId="editarEnderecoUsuario",
     * tags={"Usuarios"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="id",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do endereço do usuário",
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *          required={
     *              "rua", "numero", "bairro", "cidade", "estado", "cep"
     *          },
     *          @OA\Property(property="rua", type="string"),
     *          @OA\Property(property="numero", type="integer"),
     *          @OA\Property(property="complemento", type="string"),
     *          @OA\Property(property="bairro", type="string"),
     *          @OA\Property(property="cidade", type="string"),
     *          @OA\Property(property="estado", type="string"),
     *          @OA\Property(property="cep", type="string"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="usuario",
     *           type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="rua",
     *                  type="string",
     *                  example="João dos Santos",
     *              ),
     *              @OA\Property(
     *                  property="numero",
     *                  type="integer",
     *                  example="231",
     *              ),
     *              @OA\Property(
     *                  property="complemento",
     *                  type="string",
     *                  example="null",
     *              ),
     *              @OA\Property(
     *                  property="bairro",
     *                  type="string",
     *                  example="Ipê",
     *              ),
     *              @OA\Property(
     *                  property="cidade",
     *                  type="string",
     *                  example="Poços de Caldas",
     *              ),
     *              @OA\Property(
     *                  property="estado",
     *                  type="string",
     *                  example="Minas Gerais",
     *              ),
     *              @OA\Property(
     *                  property="cep",
     *                  type="string",
     *                  example="37704205",
     *              ),
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Não autorizado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não autorizado"),
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Conteúdo não processável",
     *    @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="Os dados fornecidos não são válidos."),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *              property="Rua",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo rua é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Numero",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo numero é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Bairro",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo bairro é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Cidade",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo cidade é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Estado",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo estado é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="CEP",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo CEP é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */
    
    public function editarEndereco(UsuarioEnderecoRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $usuarioService = new UsuarioService();

        return $usuarioService->editarEndereco($dados);
    }
}

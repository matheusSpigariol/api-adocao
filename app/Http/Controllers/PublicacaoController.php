<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PublicacaoService;
use App\Http\Requests\PublicacaoRequest;

class PublicacaoController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/post",
     * summary="Cadastrar publicacao",
     * description="Cadastrar publicacao",
     * operationId="cadastrarPublicacao",
     * tags={"Publicacao"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do post",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *      required={
     *          "description",
     *      },
     * 
     *      @OA\Property(property="description", type="string"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successo!",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1")
     *        )
     *     ),
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
     *              property="Descrição",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo descrição é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */

    public function criar(PublicacaoRequest $request)
    {
        $dados = $request->all();
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->cadastrarPublicacao($dados); 
    }

    /**
     * @OA\Post(
     * path="/api/post/{idPost}",
     * summary="Editar publicacao",
     * description="Editar uma publicacao",
     * operationId="editarPublicacao",
     * tags={"Publicacao"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idPost",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do post",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *          required={
     *              "description",
     *          },
     * 
     *          @OA\Property(property="description", type="string"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="publicacao",
     *           type="object",
     *           @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="2",
     *           ),
     *            @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="Descricao do post",
     *           ),
     *            @OA\Property(
     *              property="user",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="created_at",
     *              type="string",
     *              example="2023-01-23T00:21:08.000000Z",
     *           ),
     *            @OA\Property(
     *              property="updated_at",
     *              type="string",
     *              example="2023-01-23T00:21:08.000000Z",
     *           ),
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
     *              property="Descrição",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo descrição é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */

    public function editar(PublicacaoRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->editaPublicacao($dados); 
    }

    
    /**
     * @OA\Get(
     * path="/api/post/{idPost}",
     * summary="Mostrar Publicacao",
     * description="Consultar informações da publicacao",
     * operationId="mostrarPublicacao",
     * tags={"Publicacao"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idPost",
     *    required=true,
     *    example="2",
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
     *           property="publicacao",
     *           type="object",
     *           @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="2",
     *           ),
     *            @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="Descricao do post",
     *           ),
     *            @OA\Property(
     *              property="user",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="created_at",
     *              type="string",
     *              example="2023-01-23T00:21:08.000000Z",
     *           ),
     *            @OA\Property(
     *              property="updated_at",
     *              type="string",
     *              example="2023-01-23T00:21:08.000000Z",
     *           ),
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
     *    description="Post não encontrado",
     * ),
     * )
     */
    
    public function mostar($id)
    {
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->verPublicacao($dados); 
    }

    /**
     * @OA\Get(
     * path="/api/post",
     * summary="Listagem de publicações",
     * description="Lista com paginação de todas as publicações.",
     * operationId="listarPublicacao",
     * tags={"Publicacao"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     * @OA\Parameter(
     *   name="page",
     *   in="query",
     *   description="Buscar por numero de paginação",
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successo!",
     *    @OA\JsonContent(
     *      @OA\Property(property="current_page", type="integer", example="1"),
     *      @OA\Property(
     *           property="data",
     *           type="object",
     *           @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="5",
     *           ),
     *          @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="Descrição da publicação",
     *           ),
     *          @OA\Property(
     *              property="usuario",
     *              type="integer",
     *              example="1",
     *           ),
     *          @OA\Property(
     *              property="created_at",
     *              type="string",
     *              example="Data de criação",
     *           ),
     *          @OA\Property(
     *              property="updated_at",
     *              type="string",
     *              example="Data de atualização",
     *           ),
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

    public function listar()
    {
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->listarPublicacao(); 
    }

    
    /**
     * @OA\Delete(
     * path="/api/post/{idPost}",
     * summary="Deletar publicacao",
     * description="Deletar publicacao",
     * operationId="deletarPublicacao",
     * tags={"Publicacao"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idPost",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="",
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
     *    description="Post não encontrado",
     * ),
     * )
     */

    public function deletar($id)
    {
        $dados['id'] = $id;
        $publicacaoService = new PublicacaoService();

        return $publicacaoService->deletarPublicacao($dados); 
    }
}

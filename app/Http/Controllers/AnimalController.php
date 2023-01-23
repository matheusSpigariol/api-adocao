<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\AnimalService;
use App\Http\Requests\FormularioAnimalRequest;

class AnimalController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/animal",
     * summary="Cadastrar animal",
     * description="Cadastrar informações de animal",
     * operationId="cadastrarAnimal",
     * tags={"Animal"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do animal",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *      required={
     *          "apelido", "descricao", "tipo", "sexo"
     *      },
     * 
     *      @OA\Property(property="apelido", type="string"),
     *      @OA\Property(property="descricao", type="string"),
     *      @OA\Property(property="tipo", type="integer", example="1"),
     *      @OA\Property(property="sexo", type="integer", example="1"),
     *      @OA\Property(property="ano", type="integer"),
     *      @OA\Property(property="mes", type="integer"),
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
     *              property="Apelido",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo apelido é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Descrição",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo descrição é obrigatório."},
     *              )
     *           ),
      *           @OA\Property(
     *              property="Tipo",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo tipo é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */
    public function criar(FormularioAnimalRequest $request)
    {
        $dados = $request->all();
        $animalService = new AnimalService();

        return $animalService->criarAnimal($dados);
    }

    /**
     * @OA\Post(
     * path="/api/animal/{idAnimal}",
     * summary="Editar animal",
     * description="Editar informações de um animal",
     * operationId="editarAnimal",
     * tags={"Animal"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idAnimal",
     *    required=true,
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do animal",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *      required={
     *          "apelido", "descricao", "tipo", "sexo"
     *      },
     * 
     *      @OA\Property(property="apelido", type="string"),
     *      @OA\Property(property="descricao", type="string"),
     *      @OA\Property(property="tipo", type="integer", example="1"),
     *      @OA\Property(property="sexo", type="integer", example="1"),
     *      @OA\Property(property="ano", type="integer"),
     *      @OA\Property(property="mes", type="integer"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="animal",
     *           type="object",
     *            @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="apelido",
     *              type="string",
     *              example="Belinha",
     *           ),
     *           @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="docil",
     *           ),
     *           @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
     *           ),
     *           @OA\Property(
     *              property="usuario",
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
     *            @OA\Property(
     *              property="sexo",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="ano",
     *              type="string",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="mes",
     *              type="string",
     *              example="0",
     *           ),
     *          @OA\Property(
     *              property="tipo",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="titulo",
     *                  type="string",
     *                  example="cão",
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
     *              property="Apelido",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo apelido é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="Descrição",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo descrição é obrigatório."},
     *              )
     *           ),
      *           @OA\Property(
     *              property="Tipo",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo tipo é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * )
     */

    public function editar(FormularioAnimalRequest $request, $id)
    {
        $dados = $request->all();
        $dados['id'] = $id;
        $animalService = new AnimalService();

        return $animalService->editarAnimal($dados);
    }


     /**
     * @OA\Get(
     * path="/api/animal/{idAnimal}",
     * summary="Mostrar animal",
     * description="Consultar informações do animal",
     * operationId="mostrarAnimal",
     * tags={"Animal"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idAnimal",
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
     *           property="animal",
     *           type="object",
     *            @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="apelido",
     *              type="string",
     *              example="Belinha",
     *           ),
     *           @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="docil",
     *           ),
     *           @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
     *           ),
     *           @OA\Property(
     *              property="usuario",
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
     *            @OA\Property(
     *              property="sexo",
     *              type="integer",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="ano",
     *              type="string",
     *              example="1",
     *           ),
     *            @OA\Property(
     *              property="mes",
     *              type="string",
     *              example="0",
     *           ),
     *          @OA\Property(
     *              property="tipo",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="titulo",
     *                  type="string",
     *                  example="cão",
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
        $dados['id'] = $id;
        $animalService = new AnimalService();

        return $animalService->verAnimal($dados);
    }

    /**
     * @OA\Get(
     * path="/api/animal",
     * summary="Listagem de animais",
     * description="Lista com paginação de todas os animais.",
     * operationId="listarAnimais",
     * tags={"Animal"},
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
     *              example="1",
     *           ),
     *          @OA\Property(
     *              property="apelido",
     *              type="string",
     *              example="Belinha",
     *           ),
     *          @OA\Property(
     *              property="descricao",
     *              type="string",
     *              example="docil",
     *           ),
     *          @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="null",
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
     *          @OA\Property(
     *              property="sexo",
     *              type="integer",
     *              example="1",
     *           ),
     *          @OA\Property(
     *              property="ano",
     *              type="integer",
     *              example="1",
     *           ),
     *          @OA\Property(
     *              property="mes",
     *              type="integer",
     *              example="9",
     *           ),
     *          @OA\Property(
     *              property="tipo",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="1",
     *              ),
     *              @OA\Property(
     *                  property="titulo",
     *                  type="string",
     *                  example="cão",
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

    public function listar()
    {
        $animalService = new AnimalService();

        return $animalService->listarAnimais();
    }

    /**
     * @OA\Delete(
     * path="/api/animal/{idAnimal}",
     * summary="Deletar animal",
     * description="Deletar informações de um animal",
     * operationId="deletarAnimal",
     * tags={"Animal"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     *  @OA\Parameter(
     *    in="path",
     *    name="idAnimal",
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
     *    description="Animal não encontrado",
     * ),
     * )
     */

    public function deletar($id)
    {
        $dados['id'] = $id;
        $animalService = new AnimalService();

        return $animalService->deletarAnimal($dados);
    }
}

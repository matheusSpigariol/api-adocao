<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Endereco;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Efetuar login",
     * description="Efetuar login para obter token de autenticação",
     * operationId="login",
     * tags={"Autenticação"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do post",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *          required={
     *              "email", "password"
     *          },
     * 
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="password", type="string"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successo!",
      *    @OA\JsonContent(
     *        @OA\Property(
     *           property="user",
     *           type="object",
     *           @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="2",
     *           ),
     *            @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Matheus",
     *           ),
     *           @OA\Property(
     *              property="password",
     *              type="string",
     *              example="$2y$12$Cf4\/B7LcWD.a3s0JDrOmr.Bx7FhNjQ3VFv7LnqwhMvY5ZdHzL3aTS",
     *           ),
     *          @OA\Property(
     *              property="foto",
     *              type="string",
     *              example="https://adocao-file-upload.s3.us-west-2.amazonaws.com/usuarios/fotos/20230123073245-teste.png",
     *          ),
     *           @OA\Property(
     *              property="endereco",
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="2",
     *              ),
     *              @OA\Property(
     *                  property="rua",
     *                  type="string",
     *                  example="João da nica",
     *              ),
     *              @OA\Property(
     *                  property="numero",
     *                  type="integer",
     *                  example="300",
     *              ),
     *              @OA\Property(
     *                  property="complemento",
     *                  type="string",
     *                  example="null",
     *              ),
     *              @OA\Property(
     *                  property="bairro",
     *                  type="string",
     *                  example="Ipe",
     *              ),
     *              @OA\Property(
     *                  property="cidade",
     *                  type="string",
     *                  example="Poços de Caldas",
     *              ),
     *              @OA\Property(
     *                  property="estado",
     *                  type="string",
     *                  example="MG",
     *              ),
     *              @OA\Property(
     *                  property="cep",
     *                  type="string",
     *                  example="00000-000",
     *              ),
     *           ),
     *        ),
     *        @OA\Property(
     *          property="token",
     *          type="string",
     *          example="9|9YrqKtucfcQ4sPQ8Z7Ny8ntccvcCJQ8bL9senDck",
     *       ),
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
     *              property="email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo email é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="password",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo password é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="login ou senha inválido",
     * ),
     * )
     */
    
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials))
            return response()->json("Credenciais invalidas", 401);
        
        $token = auth()->user()->createToken('auth_token');

        $usuario = Users::with('endereco')
            ->find(auth()->user()->id);


        return response()->json([
            'user' => $usuario,
            'token' => $token->plainTextToken
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Criar usuario",
     * description="Criar registro do usuário",
     * operationId="registrarusuario",
     * tags={"Autenticação"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Coloque as informações do usuário",
     *    @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      encoding={},
     *      @OA\Schema(
     *         type="object", 
     *      required={
     *          "name", "email", "password", "rua", "numero", "bairro", "cidade",
     *          "estado", "cep"
     *      },
     *      @OA\Property(property="name", type="string"),
     *      @OA\Property(property="email", type="string"),
     *      @OA\Property(property="password", type="string"),
     *      @OA\Property(property="foto", type="file"),
     *      @OA\Property(property="rua", type="string"),
     *      @OA\Property(property="numero", type="integer"),
     *      @OA\Property(property="complemento", type="integer"),
     *      @OA\Property(property="bairro", type="string"),
     *      @OA\Property(property="cidade", type="string"),
     *      @OA\Property(property="estado", type="string"),
     *      @OA\Property(property="cep", type="string"),
     *      ),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successo!",
      *    @OA\JsonContent(
     *        @OA\Property(
     *           property="user",
     *           type="object",
     *           @OA\Property(
     *              property="id",
     *              type="integer",
     *              example="2",
     *           ),
     *            @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Matheus",
     *           ),
     *            @OA\Property(
     *              property="password",
     *              type="string",
     *              example="$2y$12$Cf4\/B7LcWD.a3s0JDrOmr.Bx7FhNjQ3VFv7LnqwhMvY5ZdHzL3aTS",
     *           ),
     *        ),
     *        @OA\Property(
     *          property="token",
     *          type="string",
     *          example="9|9YrqKtucfcQ4sPQ8Z7Ny8ntccvcCJQ8bL9senDck",
     *       ),
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
     *              property="name",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo name é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo email é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="password",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo password é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="rua",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo rua é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="numero",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo numero é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="bairro",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo bairro é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="cidade",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo cidade é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="estado",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo estado é obrigatório."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="cep",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"O campo cep é obrigatório."},
     *              )
     *           ),
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Erro interno",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não foi possível cadastrar o endereço"),
     *    )
     * ),
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $endereco = Endereco::create(
                [
                    "rua" => $request->rua,
                    "numero" => $request->numero,
                    "complemento" => $request->complemento,
                    "bairro" => $request->bairro,
                    "cidade" => $request->cidade,
                    "estado" => $request->estado,
                    "cep" => $request->cep,
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([
                "erro" => "Não foi possível cadastrar o endereço"
            ], 500);
        }

        $urlnomeArquivo = null;
        if($request->foto){
            $nomeArquivo = date('Ymdhis') . '-' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('usuarios/fotos/', $nomeArquivo, 's3');
            $urlnomeArquivo = Storage::disk('s3')->url("usuarios/fotos/" . $nomeArquivo);
        }

        $user = Users::create(
            [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password, ['rounds' => 12]),
                "endereco " => $endereco->id,
                "foto" => $urlnomeArquivo,
                "data_aniversairo" => $request->data_aniversairo,
            ]
        );

        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials))
            return response()->json("Credenciais invalidas", 401);
        
        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

    /**
     * @OA\Get(
     * path="/api/auth/logout",
     * summary="Efetuar logout",
     * description="Efetuar logout da API",
     * operationId="logout",
     * tags={"Autenticação"},
     *  security={
     *     {"bearerAuth": {}}
     *  },
     * @OA\Response(
     *    response=204,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(
     *           property="publicacao",
     *           type="string",
     *           example="[]"
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
     * )
     */
    
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([], 204);
    }
}

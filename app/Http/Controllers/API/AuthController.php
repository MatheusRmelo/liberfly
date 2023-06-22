<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Requests\Auth\SignInRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    /**
    * @OA\Post(
    *     path="/api/auth/signin",
    *     summary="Autenticação do usuário",
    *     tags={"Autenticação"},
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="email",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="password",
    *                     type="string"
    *                 ),
    *                 example={"email": "teste@gmail.com", "password": "123456789"}
    *             )
    *         )
    *     ),
    * @OA\Response(
    *     response=200,
    *     description="Usuário autenticado com sucesso"
    *   ),
    * @OA\Response(
    *     response=401,
    *     description="Não Autorizado"
    *   )
    *    )
    */
    public function signIn(SignInRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => 'E-mail or password is incorrect',
                'password' => 'E-mail or password is incorrect',
            ]);
        }

        return $this->success(JWT::encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ], env('JWT_SECRET_KEY'), 'HS256'), 'Make Login Successful');
    }

    /**
    * @OA\Post(
    *     path="/api/auth/signup",
    *     summary="Criação do usuário",
    *     tags={"Autenticação"},
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="password",
    *                     type="string"
    *                 ),
    *                 example={"name":"Teste","email": "teste@gmail.com", "password": "123456789"}
    *             )
    *         )
    *     ),
    * @OA\Response(
    *     response=201,
    *     description="Usuário criado com sucesso"
    *   ),
    * @OA\Response(
    *     response=401,
    *     description="Não Autorizado"
    *   )
    *    )
    */
    public function signUp(SignUpRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            throw ValidationException::withMessages([
                'email' => 'This e-mail is not available',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->create(JWT::encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ], env('JWT_SECRET_KEY'), 'HS256'), 'Create user successfully');
    }

    /**
    * @OA\Get(
    *     path="/api/auth/logout",
    *     summary="Logout do usuário",
    *     tags={"Autenticação"},
    *     security={{"bearerAuth":{}}},
    * @OA\Response(
    *     response=204,
    *     description="Usuário deslogado"
    *   ),
    * )
    */
    public function logout(Request $request)
    {
        return response()->noContent();
    }
}

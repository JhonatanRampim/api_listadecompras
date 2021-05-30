<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (!$token = JWTAuth::attempt(array('email' =>  $credentials['email'], 'password' => $credentials['password']))) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json(['success' => true, 'token' => $token, 'message' => 'CREATED'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th, 'message' => 'ERROR'], 200);
        }
    }
    /**
     * Signup usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup()
    {
        try {
            $credentials = request(['name', 'email', 'password']);
            $usuario = new User();
            $usuario->name = $credentials['name'];
            $usuario->email = $credentials['email'];
            $usuario->password = app('hash')->make($credentials['password']);
            $usuario->save();
            return response()->json(["success" => true, "data" => $usuario, "message" => "CREATED"], 200);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "data" => $th, "message" => "CREATED"], 200);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::getPayload($token)->toArray();
            $usuario = User::find($user['id']);
            return response()->json(["success" => true, "data" => $usuario, "message" => "COMPLETED"], 200);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "data" => $th, "message" => "ERROR"], 200);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

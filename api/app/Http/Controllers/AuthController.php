<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'message' => 'Email e/ou Password não conferem',
                    'success' => false
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'success' => true,
                'message' => 'Usuário loggado com sucesso',
                'data' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}

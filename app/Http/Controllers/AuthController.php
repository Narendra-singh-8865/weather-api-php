<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRequest $request)
    {
        
        
        $user = $this->authService->register($request->all());

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 200);
    }

    public function login(AuthRequest $request)
    {
       

        $response = $this->authService->login($request->all());

        if (isset($response['error'])) {
            return response()->json(['message' => $response['error']], 401);
        }

        return response()->json(['token' => $response['token'], 'user' => $response['user']]);
    }

    public function forgotPassword(AuthRequest $request)
    {
        
      $response = $this->authService->forgotPassword($request->all());

        if (isset($response['error'])) {
            return response()->json(['message' => $response['error']], 404);
        }

        return response()->json(['message' => 'Password reset token sent', 'token' => $response['token']]);
    }

   
 
}
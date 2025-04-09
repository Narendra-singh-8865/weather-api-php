<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['first_name'] = ucfirst($data['first_name']);
        $data['last_name'] = ucfirst($data['last_name']);
        $userObject =  User::create($data);
        unset($userObject->id);
        return $userObject;
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            
            return ['error' => 'Invalid credentials'];
        }

        if ($user->status !== 1) {

            return ['error' => 'Your account is not active please contact to support.'];
        }

        if (!Hash::check($credentials['password'], $user->password)) {

            return ['error' => 'Invalid credentials'];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Update last login
        $user->update(['last_login_at' => now()]);

        unset($user->id);
        
        
        
        return ['token' => $token, 'user' => $user];
    }

    public function forgotPassword(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return ['error' => 'User not found'];
        }

        $token = str_random(40); // Generate a unique token
        // You can store and send the token to the user via email
        // For now, just return it for testing purposes
        return ['token' => $token];
    }
}

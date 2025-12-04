<?php

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Maneja el flujo del login de asana
     */
    public function authenticateWithAsana(): array
    {

        $asanaUser = $this->getSocialiteUser();
        $user = $this->findOrCreateUser($asanaUser);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * Interactuar con socialite
     */
    private function getSocialiteUser()
    {
        $frontendUrl = 'http://localhost:5173/auth/callback';
        return Socialite::driver('asana')
            ->stateless()
            ->redirectUrl($frontendUrl)
            ->user();
    }

    /**
     * Interactuar con eloquent
     */
    private function findOrCreateUser($asanaUser): User
    {
        return User::updateOrCreate(
            ['asana_id' => $asanaUser->id],
            [
                'username'             => $asanaUser->name,
                'email'                => $asanaUser->email,
                'asana_access_token'   => $asanaUser->token,
                'asana_refresh_token'  => $asanaUser->refreshToken ?? null,
                'password'             => bcrypt(Str::random(24)),
            ]
        );
    }
}

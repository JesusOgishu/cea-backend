<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Http\Controllers\ApiController;


class AuthController extends ApiController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getAuthUrl()
    {
        try {
            $url = Socialite::driver('asana')->stateless()->redirect()->getTargetUrl();
            return $this->successResponse(['url' => $url], 'URL generada');
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo generar la URL de Asana', 500);
        }
    }

    /**
     * delegamos la logica al service
     */
    public function handleCallback(Request $request)
    {
        try {
            $authData = $this->authService->authenticateWithAsana();
            return $this->successResponse($authData, 'Login exitoso');
        } catch (Exception $e) {
            return $this->errorResponse('Error al autenticar: ' . $e->getMessage(), 401);
        }
    }
}

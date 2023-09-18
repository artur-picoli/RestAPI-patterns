<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->descriptiveResponseMethods();
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        response()->macro('ok', function ($data) {
            return response()->json(['data' => $data], 200);
        });

        response()->macro('created', function ($data, $message = 'Registro criado com sucesso!') {
            return response()->json([
                'message' => $message,
                'data' => $data ?? ''
            ], 201);
        });

        response()->macro('updated', function ($data, $message = 'Registro editado com sucesso!') {
            return response()->json([
                'message' => $message,
                'data' => $data ?? ''
            ], 200);
        });

        response()->macro('deleted', function ($message = 'Registro removido com sucesso!') {
            return response()->json([
                'message' => $message,
            ], 200);
        });

        response()->macro('badRequest', function ($message = 'Falha de validação.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 400);
        });

        response()->macro('unauthorized', function ($message = 'Usuário ou senha inválidos.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 401);
        });

        response()->macro('forbidden', function ($message = 'Acesso negado.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 403);
        });

        response()->macro('notFound', function ($message = 'Registro não encontrado.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 404);
        });

        response()->macro('internalServerError', function ($message = 'Erro interno.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 500);
        });
    }

    public function handleErrorResponse($message, $errors, $status)
    {
        $response = [
            'message' => $message,
        ];

        if (count($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}

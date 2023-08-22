<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('ok', function ($data) {
            return Response::json(['data' => $data], 200);
        });

        Response::macro('created', function ($data, $message = 'Registro criado com sucesso!') {

            if (is_array($data) && !empty($data)) {
                return Response::json([
                    'message' => $message,
                    'data' => $data
                ], 201);
            }

            if (count($data->getAttributes())) {
                return Response::json([
                    'message' => $message,
                    'data' => $data
                ], 201);
            }

            return Response::json([], 201);
        });

        Response::macro('updated', function ($data, $message = 'Registro editado com sucesso!') {
            if (count($data->getAttributes())) {
                return Response::json([
                    'message' => $message,
                    'data' => $data
                ], 200);
            }

            return Response::json([], 201);
        });

        Response::macro('deleted', function ($message = 'Registro removido com sucesso!') {
            return Response::json([
                'message' => $message,
            ], 200);
        });

        Response::macro('badRequest', function ($message = 'Falha de validação', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 400);
        });

        Response::macro('unauthorized', function ($message = 'Usuário ou senha inválidos', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 401);
        });

        Response::macro('forbidden', function ($message = 'Acesso negado', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 403);
        });

        Response::macro('notFound', function ($message = 'Registro não encontrado', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 404);
        });

        Response::macro('internalServerError', function ($message = 'Erro interno.', $errors = []) use ($instance) {
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

        return Response::json($response, $status);
    }
}

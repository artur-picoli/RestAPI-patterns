<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TypeError;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') && $e instanceof NotFoundHttpException) {
                return response()->notFound();
            }
        });

        $this->renderable(function (InvalidArgumentException $e, Request $request) {

            if ($request->is('api/*') && $e instanceof InvalidArgumentException) {
                return response()->json([
                    'message' => 'Erro interno'
                ], 500);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {

            if ($request->is('api/*') && $e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'Método não suportado, ou rota não encontrada'
                ], 405);
            }
        });

        $this->renderable(function (TypeError $e, Request $request) {

            if ($request->is('api/*') && $e instanceof TypeError) {
                return response()->json([
                    'message' => 'O argumento deve ser um ID do tipo inteiro'
                ], 405);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*') && $e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }
        });
    }
}

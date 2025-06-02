<?php

namespace App\Interface\Http\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Psr7\Response;
use Throwable;
use PDOException;
use Illuminate\Database\QueryException;
use App\Interface\Http\Helpers\ApiResponse;
use App\Interface\Http\Helpers\JsonResponse;

/**
 * Middleware to handle errors in the application.
 * It catches exceptions thrown by the request handler and returns a standardized error response.
 */
class ErrorHandlerMiddleware implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			return $handler->handle($request);
		} catch (Throwable $e) {
			if ($e instanceof PDOException || $e instanceof QueryException) {
				// — Logue o erro completo em arquivo de log ou Sentry, etc.
				error_log('[Database Error] ' . $e->getMessage());

				return ApiResponse::error(new Response(), 500 ,'Erro interno no servidor (base de dados).');
			}

			if ($e instanceof \ArgumentCountError || $e instanceof \TypeError) {
				return ApiResponse::genericError(new Response(), 400, 'Parâmetros inválidos', ['exception' => $e->getMessage()]);
			}

			error_log('[Unhandled Error] ' . $e->getMessage());
			return ApiResponse::genericError(new Response(), 500, 'Erro interno no servidor', null);
		}
	}
}

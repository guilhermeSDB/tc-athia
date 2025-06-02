<?php

namespace App\Interface\Http\Helpers;

use App\Interface\Http\Helpers\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class ApiResponse
{
	public static function success(ResponseInterface $res, mixed $data = null, int $status = 200): ResponseInterface
	{
		return JsonResponse::create($res, [
			'status' => 'SUCCESS',
			'statusCode' => $status,
			'data' => $data
		], $status);
	}

	public static function created(ResponseInterface $res, mixed $data = null): ResponseInterface
	{
		return self::success($res, $data, 201);
	}

	public static function noContent(ResponseInterface $res): ResponseInterface
	{
		return JsonResponse::create($res, [
			'status' => 'NO_CONTENT',
			'statusCode' => 204,
			'data' => null
		], 204);
	}

	public static function error(ResponseInterface $res, int $statusCode, string $message): ResponseInterface
	{
		$response = $res->withStatus($statusCode);
		$reasonPhrase = $response->getReasonPhrase();

		return JsonResponse::create($res, [
			'status' => $reasonPhrase,
			'statusCode' => $statusCode,
			'message' => $message
		], $statusCode);
	}

	public static function notFound(ResponseInterface $res, string $message = 'Recurso não encontrado'): ResponseInterface
	{
		return self::error($res, 404, $message);
	}

	public static function badRequest(ResponseInterface $res, string $message = 'Requisição inválida'): ResponseInterface
	{
		return self::error($res, 400, $message);
	}

	public static function unauthorized(ResponseInterface $res, string $message = 'Não autorizado'): ResponseInterface
	{
		return self::error($res, 401, $message);
	}

	public static function internalError(ResponseInterface $res, string $message = 'Erro interno do servidor'): ResponseInterface
	{
		return self::error($res, 500, $message);
	}

	public static function jsonError(ResponseInterface $res, string $errorDetail): ResponseInterface
	{
		return JsonResponse::create(
			$res,
			[
				'status' => 'ERROR',
				'statusCode' => 400,
				'message' => 'JSON inválido',
				'errors' => ['json' => $errorDetail]
			],
			400
		);
	}

	public static function genericError(ResponseInterface $res, int $statusCode, string $message, ?array $errors = null): ResponseInterface
	{
		return JsonResponse::create(
			$res,
			[
				'status' => 'ERROR',
				'statusCode' => $statusCode,
				'message' => $message,
				'errors' => $errors
			],
			$statusCode
		);
	}
}

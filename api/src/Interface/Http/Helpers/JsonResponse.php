<?php

namespace App\Interface\Http\Helpers;

use Psr\Http\Message\ResponseInterface;

/* 
The `JsonResponse` class in PHP provides a method to create a JSON response with specified data and
status code. 
*/
class JsonResponse
{
	public static function create(ResponseInterface $res, mixed $data, int $status = 200): ResponseInterface
	{
		$json = json_encode($data, JSON_UNESCAPED_UNICODE);

		if ($json === false) {
			throw new \RuntimeException('Erro ao serializar JSON: ' . json_last_error_msg());
		}

		$res->getBody()->write($json);

		return $res
			->withHeader('Content-Type', 'application/json; charset=utf-8')
			->withStatus($status);
	}
}

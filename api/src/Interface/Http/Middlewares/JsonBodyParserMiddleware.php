<?php

namespace App\Interface\Http\Middlewares;

use App\Interface\Http\Helpers\ApiResponse;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Middleware to parse JSON request bodies and handle errors.
 * If the request body is JSON, it decodes it and adds it to the request.
 * If the JSON is invalid, it returns a 400 Bad Request response with an error message.
 */
class JsonBodyParserMiddleware implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$contentType = $request->getHeaderLine('Content-Type');

		if (str_contains($contentType, 'application/json')) {
			$bodyStream = $request->getBody();

			if ($bodyStream->isSeekable()) {
				$bodyStream->rewind();
			}

			$body = (string) $bodyStream;
			$data = json_decode($body, true);

			if (json_last_error() !== JSON_ERROR_NONE) {
				$error = json_last_error_msg();
				return ApiResponse::jsonError(new Response(), $error);
			}

			$request = $request->withParsedBody($data);
		}

		return $handler->handle($request);
	}
}

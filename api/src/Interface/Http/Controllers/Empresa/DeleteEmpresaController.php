<?php

namespace App\Interface\Http\Controllers\Empresa;

use OpenApi\Attributes as OAT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Empresas')]
class DeleteEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to delete an empresa by ID.
	 *
	 * @param Request $req
	 * @param Response $res
	 * @param ?array $args
	 * @return Response
	 */
	#[OAT\Delete(
		path: '/empresas/{id}',
		tags: ['Empresas'],
		operationId: 'deleteEmpresa',
		description: 'Deleta uma empresa pelo ID',
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID da Empresa a ser deletada',
				schema: new OAT\Schema(type: 'string', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 204,
				description: 'Empresa deletada com sucesso'
			),
			new OAT\Response(
				response: 400,
				description: 'Erro ao tentar excluir a empresa, empresa não encontrada ou não pode ser excluída',
				content: new OAT\JsonContent(
					example: '{"error": "Empresa não encontrada ou não pode ser excluída"}'
				)
			),
			new OAT\Response(response: 404, description: 'Empresa não encontrada'),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$this->useCase->execute($args['id']);
			return ApiResponse::noContent($response);
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}

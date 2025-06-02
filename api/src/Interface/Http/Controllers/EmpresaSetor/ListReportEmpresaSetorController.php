<?php

namespace App\Interface\Http\Controllers\EmpresaSetor;

use App\Application\DTO\EmpresaSetor\EmpresaSetorFilterDto;
use App\Application\DTO\EmpresaSetor\EmpresaSetorReportDTO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Relatórios')]
class ListReportEmpresaSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to find all empresas.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param ?array $args
	 * @return Response
	 */
	#[OAT\Get(
		path: '/relatorios/empresas-setores',
		tags: ['Relatórios'],
		operationId: 'relatorioEmpresasSetores',
		summary: 'Relatório de empresas com seus setores',
		parameters: [
			new OAT\Parameter(
				name: 'empresa_id',
				in: 'query',
				required: false,
				description: 'Filtrar por ID da empresa',
				schema: new OAT\Schema(type: 'integer')
			),
			new OAT\Parameter(
				name: 'setor_id',
				in: 'query',
				required: false,
				description: 'Filtrar por ID do setor',
				schema: new OAT\Schema(type: 'integer')
			)
		],
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Relatório de empresas com setores',
				content: new OAT\JsonContent(
					type: 'array',
					items: new OAT\Items(ref: EmpresaSetorReportDTO::class)
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		$params = (array)$request->getQueryParams();

		try {
			$filter = new EmpresaSetorFilterDTO();
			$filter->empresa_id = isset($params['empresa_id']) ? (int) $params['empresa_id'] : null;
			$filter->setor_id = isset($params['setor_id']) ? (int) $params['setor_id'] : null;
			$empresas = $this->useCase->execute($filter);
			return ApiResponse::success($response, $empresas);
		} catch (\Exception $e) {
			return ApiResponse::error($response, 500, $e->getMessage());
		}
	}
}

<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Faker\Factory as FakerFactory;

final class EmpresasSeeder extends AbstractSeed
{
	public function run(): void
	{
		$faker = FakerFactory::create('pt_BR');

		$empresaTable = $this->table('empresa');
		$empresaSetorTable = $this->table('empresa_setor');

		$empresasData = [];
		$relacionamentos = [];

		for ($i = 0; $i < 10; $i++) {
			$empresasData[] = [
				'razao_social'  => $faker->company,
				'nome_fantasia' => $faker->companySuffix,
				'cnpj'          => $faker->cnpj(false),
				'created_at'    => date('Y-m-d H:i:s'),
				'updated_at'    => date('Y-m-d H:i:s'),
				'deleted_at'    => null,
			];
		}

		$empresaTable->insert($empresasData)->saveData();
		$pdo = $this->getAdapter()->getConnection();
		$stmt = $pdo->query("SELECT id FROM empresa ORDER BY id DESC LIMIT 10");
		$empresaIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id');

		foreach ($empresaIds as $empresaId) {
			$setorIds = range(1, 10); // IDs possíveis de setores
			shuffle($setorIds);
			$qtdSetores = rand(1, 10);
			$setoresSelecionados = array_slice($setorIds, 0, $qtdSetores);

			foreach ($setoresSelecionados as $setorId) {
				$relacionamentos[] = [
					'empresa_id' => $empresaId,
					'setor_id'   => $setorId,
				];
			}
		}

		$empresaSetorTable->insert($relacionamentos)->saveData();
	}
}

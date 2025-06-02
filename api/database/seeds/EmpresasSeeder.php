<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Faker\Factory as FakerFactory;

final class EmpresasSeeder extends AbstractSeed
{
	public function run(): void
	{
		$faker = FakerFactory::create('pt_BR');

		$data = [];
		for ($i = 0; $i < 10; $i++) {
			$data[] = [
				'razao_social'   => $faker->company,
				'nome_fantasia'  => $faker->companySuffix,
				'cnpj'           => $faker->cnpj(false), // false: sem máscara
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => null,
				'deleted_at'     => null,
			];
		}

		$this->table('empresas')->insert($data)->saveData();
	}
}

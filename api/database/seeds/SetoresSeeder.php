<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Faker\Factory as FakerFactory;

final class SetoresSeeder extends AbstractSeed
{
	public function run(): void
	{
		$faker = FakerFactory::create('pt_BR');

		$listaDeSetores = [
			'Agricultura',
			'Alimentos e Bebidas',
			'Comércio Atacadista',
			'Comércio Varejista',
			'Construção Civil',
			'Educação',
			'Energia',
			'Financeiro',
			'Indústria Automobilística',
			'Indústria Farmacêutica',
			'Logística',
			'Saúde',
			'Tecnologia da Informação',
			'Telecomunicações',
			'Turismo e Hotelaria',
		];

		shuffle($listaDeSetores);
		$setoresSelecionados = array_slice($listaDeSetores, 0, 10);

		$data = [];
		foreach ($setoresSelecionados as $descricao) {
			$data[] = [
				'descricao'   => $descricao,
				'created_at'  => date('Y-m-d H:i:s'),
				'updated_at'  => date('Y-m-d H:i:s'),
				'deleted_at'  => null,
			];
		}

		$this->table('setor')->insert($data)->saveData();
	}
}

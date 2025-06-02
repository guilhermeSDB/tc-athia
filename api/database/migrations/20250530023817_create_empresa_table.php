<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmpresaTable extends AbstractMigration
{
	public function change(): void
	{
		$this->table('empresa')
			->addColumn('razao_social', 'string', [
				'limit' => 60,    // VARCHAR(60)
				'null'  => false
			])
			->addColumn('nome_fantasia', 'string', [
				'limit' => 55,    // VARCHAR(55)
				'null'  => true
			])
			->addColumn('cnpj', 'char', [
				'limit' => 14,
				'null'  => false
			])
			->addColumn('deleted_at', 'timestamp', ['null' => true])
			->addTimestamps()
			->addIndex(['cnpj'], ['unique' => true])
			->create();
	}
}

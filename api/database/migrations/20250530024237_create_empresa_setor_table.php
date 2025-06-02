<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmpresaSetorTable extends AbstractMigration
{
	public function change(): void
	{
		$this->table('empresa_setor')
			->addColumn('empresa_id', 'integer', ['null' => false])
			->addColumn('setor_id',   'integer', ['null' => false])
			->addForeignKey('empresa_id', 'empresa', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
			->addForeignKey('setor_id',   'setor',   'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
			->create();
	}
}

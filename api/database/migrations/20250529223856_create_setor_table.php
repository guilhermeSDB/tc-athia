<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSetorTable extends AbstractMigration
{
	public function change(): void
	{
		$this->table('setor')
			->addColumn('descricao', 'string', ['null' => false])
			->addColumn('deleted_at', 'timestamp', ['null' => true])
			->addTimestamps()
			->create();
	}
}

<?php

use Dotenv\Dotenv;

if ($_ENV['DOCKER'] === 'true') {
	$dotenv = Dotenv::createImmutable(__DIR__, '.env.docker');
} else {
	$dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
}
$dotenv->load();

return
	[
		'paths' => [
			'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
			'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
		],
		'environments' => [
			'default_migration_table' => 'phinxlog',
			'default_environment' => 'development',
			'production' => [
				'adapter' => 'pgsql',
				'host' => $_ENV['POSTGRES_HOST'],
				'name' => $_ENV['POSTGRES_DB'],
				'user' => $_ENV['POSTGRES_USER'],
				'pass' => $_ENV['POSTGRES_PASSWORD'],
				'port' => $_ENV['POSTGRES_PORT'] ?: 5432,
				'charset' => 'utf8',
			],
			'development' => [
				'adapter' => 'pgsql',
				'host' => $_ENV['POSTGRES_HOST'],
				'name' => $_ENV['POSTGRES_DB'],
				'user' => $_ENV['POSTGRES_USER'],
				'pass' => $_ENV['POSTGRES_PASSWORD'],
				'port' => $_ENV['POSTGRES_PORT'] ?: 5432,
				'charset' => 'utf8',
			],
			'testing' => [
				'adapter' => 'pgsql',
				'host' => $_ENV['POSTGRES_HOST'],
				'name' => $_ENV['POSTGRES_DB'],
				'user' => $_ENV['POSTGRES_USER'],
				'pass' => $_ENV['POSTGRES_PASSWORD'],
				'port' => $_ENV['POSTGRES_PORT'] ?: 5432,
				'charset' => 'utf8',
			]
		],
		'version_order' => 'creation'
	];

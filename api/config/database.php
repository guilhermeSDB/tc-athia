<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

$capsule = new Capsule;
$basePath = __DIR__ . '/../'; // pasta raiz do projeto

if (isset($_ENV['DOCKER']) && $_ENV['DOCKER'] === 'true') {
	$dotenv = Dotenv::createImmutable($basePath, '.env.docker');
} else {
	$dotenv = Dotenv::createImmutable($basePath, '.env.local');
}
$dotenv->load();

$capsule->addConnection([
	'driver'    => $_ENV['POSTGRES_CONNECTION'],
	'host'      => $_ENV['POSTGRES_HOST'],
	'database'  => $_ENV['POSTGRES_DB'],
	'username'  => $_ENV['POSTGRES_USER'],
	'password'  => $_ENV['POSTGRES_PASSWORD'],
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
	'timezone'  => '-03:00'
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

<?php

declare(strict_types=1);

namespace App\Infrastructure\Docs\Swagger;

use OpenApi\Attributes as OAT;

#[OAT\Info(title: 'TC-Athia API', version: '1.0.0', description: 'Documentação automática gerada pelo swagger-php')]
#[OAT\Server(url: 'http://localhost:8000', description: 'Ambiente de desenvolvimento')]
#[OAT\License(name: 'MIT', identifier: 'MIT')]
#[OAT\Tag(name: 'Empresas', description: 'Empresas API')]
#[OAT\Tag(name: 'Setores', description: 'Setores API')]
class OpenApiSpec {}

<?php

use Slim\App;

return function (App $app) {
	(require __DIR__ . '/../src/Interface/Http/Routes/RegisterSetorRoutes.php')($app);
	(require __DIR__ . '/../src/Interface/Http/Routes/RegisterEmpresaRoutes.php')($app);
	(require __DIR__ . '/../src/Interface/Http/Routes/RegisterEmpresaSetorRoutes.php')($app);
};

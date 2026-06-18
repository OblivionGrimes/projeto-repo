<?php

require_once __DIR__ . '/../../Config/Config.php';
use Config\Config;
$config = new Config();

require_once __DIR__ . '/../../src/Core/Router.php';
use src\Core\Router;
$router = new Router();

require_once __DIR__ . '/../../Config/Forms.php';
use Config\Forms;
$forms = new Forms();

require_once __DIR__ . '/../../Config/Mask.php';
use Config\Mask;
$mask = new Mask();

/* -- REPOSITORIOS -- */

require_once __DIR__ . '/../../src/Repositories/LoginRepository.php';
use src\Repositories\LoginRepository;
$LoginRepository = new LoginRepository();

require_once __DIR__ . '/../../src/Repositories/PermissionRepository.php';
use src\Repositories\PermissionRepository;
$PermissionRepository = new PermissionRepository();

require_once __DIR__ . '/../../src/Repositories/UserRepository.php';
use src\Repositories\UserRepository;
$UserRepository = new UserRepository();

require_once __DIR__ . '/../../src/Repositories/EnterpriseRepository.php';
use src\Repositories\EnterpriseRepository;
$EnterpriseRepository = new EnterpriseRepository();


/* -- MODELOS -- */
require_once __DIR__ . '/../../src/Models/User.php';

require_once __DIR__ . '/../../src/Models/Enterprise.php';



session_start();
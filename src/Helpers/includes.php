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


/* -- MODELOS -- */
require_once __DIR__ . '/../../src/Models/User.php';

require_once __DIR__ . '/../../src/Models/Enterprise.php';



session_start();
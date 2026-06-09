<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once 'src/Helpers/includes.php';

$urlParam = $_GET['url'] ?? ''; 

$viewToLoad = $router->getFileFromUrl($urlParam);

$isPublicPage = (strpos($viewToLoad, 'routes/public') !== false);


if ($isPublicPage) {
    // =========================
    // LAYOUT PÚBLICO (Login)
    // =========================
    require_once 'src/Views/head.php'; 
    
    if (file_exists($viewToLoad)) {
        require_once $viewToLoad;
    } else {
        echo "<h1>Erro: Arquivo público não encontrado</h1>";
    }

    require_once 'src/Views/body.php';

} else {
    // =========================
    // LAYOUT DASHBOARD
    // =========================
    $LoginRepository->redirectIfNotLogged();

    require_once 'src/Views/head.php';

    //require_once 'src/Views/header.php';

    if (file_exists($viewToLoad)) {
        require_once $viewToLoad;
    } else {
        require_once 'routes/dashboard/404.php';
    }

    //require_once 'src/Views/footer.php';

    require_once 'src/Views/body.php';
}
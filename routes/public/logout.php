<?php


    $LoginRepository->logUsuario($_SESSION['logged_user']->getIdUser(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], "logout");

    session_destroy();
    header("Location: ".BASE_URL."login");
    exit;

?>
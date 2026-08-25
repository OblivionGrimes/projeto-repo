<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro_conferente'])) {
        $nome_conferente = $_POST['nome_conferente'];
        $turno_conferente = $_POST['turno_conferente'];
        $tipo_conferente = $_POST['tipo_conferente'];

        $result = $UserRepository->createMarker($nome_conferente, $turno_conferente, $tipo_conferente);

        if ($result === true) {
            $config->alerta_toast("Conferente/Marcador cadastrado com sucesso!", 1);
            echo $config->reloading(); // recarrega a pagina
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao cadastrar o Conferente/Marcador.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao cadastrar o Conferente/Marcador.", 2);
        }
    }

    
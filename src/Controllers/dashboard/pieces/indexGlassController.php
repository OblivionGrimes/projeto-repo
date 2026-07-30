<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro_glass'])) {
        $nomeGlass = $_POST['nome_glass'];

        $result = $piecesRepository->createGlass($nomeGlass);

        if ($result === true) {
            $config->alerta_toast("Tipo de vidro cadastrado com sucesso!", 1);
            echo $config->reloading(); // recarrega a pagina
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao cadastrar o tipo de vidro.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao cadastrar o tipo de vidro.", 2);
        }
    }
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro_motive'])) {
        $nomeMotive = $_POST['nome_motive'];

        $result = $piecesRepository->createMotive($nomeMotive);

        if ($result === true) {
            $config->alerta_toast("Motivo cadastrado com sucesso!", 1);
            //echo $config->reloading(); // recarrega a pagina
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao cadastrar o motivo.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao cadastrar o motivo.", 2);
        }
    }

?>
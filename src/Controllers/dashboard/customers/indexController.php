<?php

    $isIframe  = isset($_GET['iframe']) && $_GET['iframe'] == 'customers';

    ############################## Codigos da pagina ##############################
    if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['registro_cliente'])) {

        $numero_cliente = $_POST['numero_cliente'] ?? '';
        $contato_cliente = $_POST['contato_cliente'] ?? '';
        $nome_cliente = $_POST['nome_cliente'] ?? '';
        $cnpj = $_POST['cnpj'] ?? '';

        $result = $CustomerRepository->createCliente([
            'numero_cliente' => $numero_cliente,
            'contato_cliente' => $contato_cliente,
            'nome_cliente' => $nome_cliente,
            'cnpj' => $cnpj
        ]);

        if ($result === true) {
            $config->alerta_toast("Cliente cadastrado com sucesso!", 1);
        } elseif ($result === null) {
            $config->alerta_toast("O número do cliente informado já está cadastrado.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro ao cadastrar o cliente.", 2);
        }

    }
    ###############################################################################
?>
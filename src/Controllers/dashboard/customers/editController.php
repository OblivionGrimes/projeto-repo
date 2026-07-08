<?php 
    //$isIframe  = isset($_GET['iframe']) && $_GET['iframe'] == 'customerEdit';
    //$unique_customer  = base64_decode($_GET['customer_unique']) ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_cliente'])){

        $numero_cliente = $config->sanitize($_POST['numero_cliente']);
        $contato_cliente = $config->sanitize($_POST['contato_cliente']);
        $nome_cliente = $config->sanitize($_POST['nome_cliente']);
        $cnpj = $config->sanitize($_POST['cnpj']);
        $unique_id = base64_decode($_POST['unique_id']);
        $status = $_POST['BT_STATUS'];
        $gm_status = $_POST['BT_GM_STATUS'];

        $result = $CustomerRepository->editCustomer([
            'numero_cliente' => $numero_cliente,
            'contato_cliente' => $contato_cliente,
            'nome_cliente' => $nome_cliente,
            'cnpj_cliente' => $cnpj,
            'status_cliente' => $status,
            'gm_cliente' => $gm_status,
            'unique_id' => $unique_id
        ]);

        if ($result === true) {
            $config->alerta_toast("Cliente editado com sucesso!", 1);
            echo $config->reloading(); // recarrega a pagina
        } elseif ($result === null) {
            $config->alerta_toast("O número do cliente informado já está cadastrado.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro ao editar o cliente.", 2);
        }

    }

    //$customer = $CustomerRepository->getIdCustomer($unique_customer);

?>
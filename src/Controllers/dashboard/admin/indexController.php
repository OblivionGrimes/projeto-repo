<?php

    ############## sections customers ##############
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_status']) && !isset($_POST['delete_bi']) ) {

        $unique_id = base64_decode($_POST['unique_id']);
        $status = ($_POST['switch_status'] === 'bt_active') ? 'inativo' : 'ativo';
    
        $result = $CustomerRepository->changeStatus($unique_id, $status);

        if ($result === true) {
            $config->alerta_toast("Cliente desativado com sucesso!", 1);
            //echo $config->reloading(); // recarrega a pagina
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao atualizar o status do cliente.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao atualizar o status do cliente.", 2);
        }

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_bi']) ) {

        $unique_id = base64_decode($_POST['unique_id']);
    
        $result = $CustomerRepository->deleteCustomer($unique_id);

        if ($result === true) {
            $config->alerta_toast("Cliente excluído com sucesso!", 1);
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao excluir o cliente.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao excluir o cliente.", 2);
        }

    }
    ############## fim sections customers ##############
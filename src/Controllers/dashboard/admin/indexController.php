<?php

    ############## sections customers ##############
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_status']) && !isset($_POST['delete_customer']) ) {

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

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer']) ) {

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

    ############## sections motive ##############
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_motivo']) ) {

        $unique_id = base64_decode($_POST['unique_id']);

        $id_motivo = $piecesRepository->getMotiveByUniqueId($unique_id);
        var_dump($id_motivo);

        if (!empty($piecesRepository->getAllPiecesByMotiveId($id_motivo->getIdMotivo()))) {
            
            $config->alerta_toast("Não é possível excluir este motivo, pois existem peças associadas a ele.", 2);

        }else{

            $result = $piecesRepository->deleteMotive($unique_id);

            if ($result === true) {
                $config->alerta_toast("Motivo excluído com sucesso!", 1);
            } elseif ($result === false) {
                $config->alerta_toast("Ocorreu um erro ao excluir o motivo.", 2);
            } else {
                $config->alerta_toast("Ocorreu um erro interno ao excluir o motivo.", 2);
            }

        }
    
    }
    ############## fim sections motive ##############
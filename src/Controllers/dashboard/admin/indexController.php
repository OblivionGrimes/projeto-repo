<?php

    ############## sections customers ##############
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_status']) && !isset($_POST['delete_customer']) ) {

        $unique_id = base64_decode($_POST['unique_id']);
        $status = ($_POST['switch_status'] === 'bt_active') ? 'inativo' : 'ativo';
    
        $result = $CustomerRepository->changeStatus($unique_id, $status);

        if ($result === true) {
            $config->alerta_toast("Status atualizado com sucesso!", 1);
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

    ############## sections marker ##############
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_status_marker']) && !isset($_POST['delete_marker']) ) {

        $unique_id = base64_decode($_POST['unique_id']);
        $status = ($_POST['switch_status_marker'] === 'bt_active') ? 'inativo' : 'ativo';

        $result = $UserRepository->changeStatusMarker($unique_id, $status);

        if ($result === true) {
            $config->alerta_toast("Status atualizado com sucesso!", 1);
            //echo $config->reloading(); // recarrega a pagina
        } elseif ($result === false) {
            $config->alerta_toast("Ocorreu um erro ao atualizar o status do conferente/marcador.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro interno ao atualizar o status do conferente/marcador.", 2);
        }

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_marker']) ) {

        $unique_id = base64_decode($_POST['unique_id']);

        $id_marker = $UserRepository->getMarkerByUniqueId($unique_id);

        if (!empty($UserRepository->getAllPiecesByMarkerId($id_marker['id_conferente']))) {
            
            $config->alerta_toast("Não é possível excluir este conferente/marcador, pois existem peças associadas a ele.", 2);

        }else{

            $result = $UserRepository->deleteMarker($unique_id);

            if ($result === true) {
                $config->alerta_toast("Conferente/Marcador excluído com sucesso!", 1);
            } elseif ($result === false) {
                $config->alerta_toast("Ocorreu um erro ao excluir o conferente/marcador.", 2);
            } else {
                $config->alerta_toast("Ocorreu um erro interno ao excluir o conferente/marcador.", 2);
            }

        }
    
    }
    ############## fim sections marker ##############

    ############## sections glass ##############

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_glass']) ) {

        $unique_id = base64_decode($_POST['unique_id']);

        $id_glass = $piecesRepository->getGlassByUniqueId($unique_id);

        if (!empty($piecesRepository->getAllPiecesByGlassId($id_glass['id_vidro']))) {
            
            $config->alerta_toast("Não é possível excluir este tipo de vidro, pois existem peças associadas a ele.", 2);

        }else{

            $result = $piecesRepository->deleteGlass($unique_id);

            if ($result === true) {
                $config->alerta_toast("Tipo de vidro excluído com sucesso!", 1);
            } elseif ($result === false) {
                $config->alerta_toast("Ocorreu um erro ao excluir o tipo de vidro.", 2);
            } else {
                $config->alerta_toast("Ocorreu um erro interno ao excluir o tipo de vidro.", 2);
            }

        }
    
    }

    ############## fim sections glass ##############
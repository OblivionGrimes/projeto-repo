<?php

    $etapa = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recuperar_senha'])) {

        $email = $config->sanitize($_POST['email']);

        $user = $UserRepository->buscaUserPorEmail($email);

        $unique_id = $user->getUnique();

        if ($user) {
            $codigo = $config->recoveryCode();

            $LoginRepository->saveRecoveryCode($email, $codigo);

            // trocar depois para o email do usuario mesmo
            $envio = $config->sendEmail($email, 'Código de recuperação de senha', 'Seu codigo de recuperação de senha é: '.$codigo);

            if($envio === true) {
                $config->alerta_toast("Código enviado com sucesso.", 1);
                $etapa = 1;
            } else {
                $config->alerta_toast("Erro interno ao enviar e-mail.", 2);
            }

        }else {
            $config->alerta_toast("Email não encontrado no banco de dados.", 2);
        }

    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reenviar_codigo']) ) {

        $unique_id = $config->sanitize($_POST['unique_id']);
        $email = $config->sanitize($_POST['email']);

        $codigo = $config->recoveryCode();

        $LoginRepository->saveRecoveryCode($email, $codigo);

        $envio = $config->sendEmail('matheussantos.00@outlook.com', 'Código de recuperação de senha', 'Seu codigo de recuperação de senha é: '.$codigo);

        if($envio === true) {
            $config->alerta_toast("Código reenviado com sucesso.", 1);
            $etapa = 1;
        } else {
            $config->alerta_toast("Erro interno ao reenviar e-mail.", 2);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_codigo']) ) {

        $codigo_verificacao = $config->sanitize($_POST['codigo_verificacao']);
        $email = $config->sanitize($_POST['email']);

        $unique_id = $config->sanitize($_POST['unique_id']);

        $isValid = $LoginRepository->verifyRecoveryCode($codigo_verificacao);

        if ($isValid > 0) {
            $config->alerta_toast("Código verificado com sucesso.", 1);
            $etapa = 2;
        } else {
            $config->alerta_toast("Código de verificação inválido.", 2);
            $etapa = 1;
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {

        $nova_senha = $config->sanitize($_POST['nova_senha']);
        $unique_id = $config->sanitize($_POST['unique_id']);

        $UserRepository->updatePassword($unique_id, $nova_senha);

        $config->alerta_toast("Senha atualizada com sucesso.", 1);
        echo $config->reloading(BASE_URL . 'login');

    }


?>

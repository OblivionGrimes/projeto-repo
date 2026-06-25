
<?php

    if (isset($_POST['logar'])) {

        $email = $config->sanitize($_POST['email']);
        $password = $config->sanitize($_POST['password']);

        $user = $LoginRepository->autenticarUsuario($email, $password);

        //var_dump($user);

        if (!empty($user)) {

            $_SESSION['logged_user'] = $user; 
         
            if($user->getStatus() === 'ativo'){

                header("Location: d/manage/home/index");
                $LoginRepository->logUsuario($_SESSION['logged_user']->getIdUser(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], "login");
                exit();
                
            }else{
                $config->alerta_toast("Sua conta foi desativada, solicite a reativação para acessar sua conta!",2);
                $LoginRepository->logUsuario($_SESSION['logged_user']->getIdUser(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], "Tentativa de login por user desativado");
            }

        }else{
            $config->alerta_toast("Email ou Senha incorretos!",2);
        }
    }

?>
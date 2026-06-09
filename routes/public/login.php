
<?php


    if (isset($_POST['logar'])) {

        $email = $config->sanitize($_POST['email']);
        $password = $config->sanitize($_POST['password']);

        $user = $LoginRepository->autenticarUsuario($email, $password);

        if (!empty($user)) {

            $_SESSION['logged_user'] = $user; 
         
            if($user->getStatus() === 'ativo'){

                header("Location: d/manage/home/index");
                $LoginRepository->logUsuario($_SESSION['logged_user']->getIdUser(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], "login");
                exit();
                
            }else{
                echo $config->alerta_toast("Sua conta foi desativada, solicite a reativação para acessar sua conta!",2);
                $LoginRepository->logUsuario($_SESSION['logged_user']->getIdUser(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], "Tentativa de login por user desativado");
            }

        }else{
            echo $config->alerta_toast("Email ou Senha incorretos!",2);
        }
    }

?>


<div class="flex h-full items-center justify-center relative overflow-hidden bg-dark-overlay">


    <div class="relative z-10 w-full max-w-[380px] rounded-xl border border-border p-7.5 shadow-md bg-clound-1">

        <div class="mb-7.5 text-center">
            <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full shadow-lg bg-major-2">
                <img
                    src="<?= BASE_URL ?>static/img/barbearia.png"
                    alt="Logo"
                    class="size-8"
                >
            </div>

            <h1 class="mb-2 text-2xl font-semibold text-mono text-shadow">Barber Shop</h1>
            <p class="text-sm text-muted-foreground text-shadow">Insira suas credenciais para acessar</p>
        </div>

        <?php echo $forms->formI("POST"); ?>

        <!-- Usuário -->
        <div class="mb-5">
            <label class="mb-2.5 flex items-center gap-2 text-sm font-medium text-foreground">
                <svg class="size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
                Email
            </label>
            <div class="relative">
                <?php echo $forms->input(
                    "text",
                    "email",
                    "email",
                    "",
                    "Digite seu email",
                    "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                ); ?>
            </div>
        </div>

        <!-- Senha -->
        <div class="mb-7.5">
            <div class="mb-2.5 flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm font-medium text-foreground">
                    <svg class="size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Senha
                </label>
                <a href="<?= BASE_URL ?>recovery" class="forgot-link text-xs text-primary hover:underline">Esqueceu a senha?</a>
            </div>
            <div class="relative">
                <?php echo $forms->input(
                    "password",
                    "password",
                    "password",
                    "",
                    "Digite sua senha",
                    "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                ); ?>
            </div>
        </div>

        <!-- Botão de Entrar -->
        <?php echo $forms->button(
            "submit",
            "logar",
            "logar",
            "w-full h-10 shadow-md kt-btn kt-btn-sm rounded-full",
            "",
            "Entrar no Sistema"
        ); ?>

        <?php echo $forms->formF(); ?>

        <div class="separator my-7.5 flex items-center">
            <div class="flex-grow border-t border-border"></div>
            <span class="mx-4 text-xs text-muted-foreground">Ajuda & Suporte</span>
            <div class="flex-grow border-t border-border"></div>
        </div>

        <div class="text-center">
            <span class="text-xs text-muted-foreground">© <?= date('Y') ?> THE · Gestão Inteligente</span>
        </div>
    </div>
</div>




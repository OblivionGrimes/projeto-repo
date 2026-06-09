<?php

    $etapa = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recuperar_senha'])) {

        $email = $Config->sanitize($_POST['email']);

        $user = $UserRepository->buscaUserPorEmail($email);

        $unique_id = $user->getUnique();

        if ($user) {
            $codigo = $Config->recoveryCode();

            $LoginRepository->saveRecoveryCode($email, $codigo);

            // trocar depois para o email do usuario mesmo
            $envio = $Config->sendEmail($email, 'Código de recuperação de senha', 'Seu codigo de recuperação de senha é: '.$codigo);

            if($envio === true) {
                $Config->alerta_toast("Código enviado com sucesso.", 1);
                $etapa = 1;
            } else {
                $Config->alerta_toast("Erro interno ao enviar e-mail.", 2);
            }

        }else {
            $Config->alerta_toast("Email não encontrado no banco de dados.", 2);
        }

    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reenviar_codigo']) ) {

        $unique_id = $Config->sanitize($_POST['unique_id']);
        $email = $Config->sanitize($_POST['email']);

        $codigo = $Config->recoveryCode();

        $LoginRepository->saveRecoveryCode($email, $codigo);

        $envio = $Config->sendEmail('matheussantos.00@outlook.com', 'Código de recuperação de senha', 'Seu codigo de recuperação de senha é: '.$codigo);

        if($envio === true) {
            $Config->alerta_toast("Código reenviado com sucesso.", 1);
            $etapa = 1;
        } else {
            $Config->alerta_toast("Erro interno ao reenviar e-mail.", 2);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_codigo']) ) {

        $codigo_verificacao = $Config->sanitize($_POST['codigo_verificacao']);
        $email = $Config->sanitize($_POST['email']);

        $unique_id = $Config->sanitize($_POST['unique_id']);

        $isValid = $LoginRepository->verifyRecoveryCode($codigo_verificacao);

        if ($isValid > 0) {
            $Config->alerta_toast("Código verificado com sucesso.", 1);
            $etapa = 2;
        } else {
            $Config->alerta_toast("Código de verificação inválido.", 2);
            $etapa = 1;
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {

        $nova_senha = $Config->sanitize($_POST['nova_senha']);
        $unique_id = $Config->sanitize($_POST['unique_id']);

        $UserRepository->updatePassword($unique_id, $nova_senha);

        $Config->alerta_toast("Senha atualizada com sucesso.", 1);
        echo $Config->reloading(BASE_URL . 'login');

    }


?>


<div class="flex h-full items-center justify-center relative overflow-hidden bg-dark-overlay">

    <div class="relative z-10 w-full max-w-[380px] rounded-xl border border-border p-7.5 shadow-md bg-clound-1">

        <div class="mb-7.5 text-center">
            <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full shadow-lg bg-major-2">
                <img
                    src="<?= BASE_URL ?>static/img/iconotipo.svg"
                    alt="Logo"
                    class="size-8"
                >
            </div>

            <h1 class="mb-2 text-2xl font-semibold text-mono text-shadow">High Panel</h1>
            <p class="text-sm text-muted-foreground text-shadow">Recupere sua senha de acesso ao painel</p>
        </div>

        <?php if(empty($etapa)): ?>
            <?php echo $forms->formI("POST"); ?>

                <!-- Email -->
                <div class="mb-7.5">
                    <label for="email" class="mb-2.5 flex items-center gap-2 text-sm font-medium text-foreground">
                        <svg class="size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        Email
                    </label>
                    <div class="relative">
                        <?php echo $forms->input(
                            "email",
                            "email",
                            "email",
                            "",
                            "Digite seu email cadastrado",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', true
                        ); ?>
                    </div>
                </div>

                <?php echo $forms->button(
                    "submit",
                    "recuperar_senha",
                    "recuperar_senha",
                    "w-full h-10 shadow-md button menu-button permissions kt-btn kt-btn-sm rounded-full",
                    "",
                    "Recuperar Senha"
                ); ?>

                <div class="flex justify-end mt-4">
                    <a href="<?= BASE_URL ?>login" class="forgot-link text-xs text-primary hover:underline">Retornar a tela de login</a>
                </div>

            <?php echo $forms->formF(); ?>  
        <?php elseif($etapa === 1): ?>

            <?php echo $forms->formI("POST"); ?>

                <!-- Email -->
                <div class="mb-7.5">
                    <label for="email" class="flex items-center gap-2 text-sm font-medium text-foreground">
                        <svg class="size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        Codígo de Verificação
                    </label>
                    <div class="relative">

                        <?php echo $forms->input(
                            "hidden",
                            "unique_id",
                            "unique_id",
                            $unique_id,
                            "",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', false
                        ); ?>

                        <?php echo $forms->input(
                            "hidden",
                            "email",
                            "email",
                            $email,
                            "",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', false
                        ); ?>

                        <div class="flex justify-end"> 
                            <?php echo $forms->button(
                                "submit",
                                "reenviar_codigo",
                                "reenviar_codigo",
                                "kt-bnt text-xs text-primary cursor-pointer hover:underline z-10 relative p-2",
                                "",
                                "Reenviar Código"
                            ); ?>
                        </div>

                        <?php echo $forms->input(
                            "number",
                            "codigo_verificacao",
                            "codigo_verificacao",
                            "",
                            "Digite o código de verificação",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', false
                        ); ?>
                    </div>
                </div>

                <?php echo $forms->button(
                    "submit",
                    "salvar_codigo",
                    "codigo",
                    "w-full h-10 shadow-md button menu-button permissions kt-btn kt-btn-sm rounded-full",
                    "",
                    "Salvar"
                ); ?>

            <?php echo $forms->formF(); ?>  

        <?php elseif($etapa === 2): ?>

            <?php echo $forms->formI("POST"); ?>

                <!-- Email -->
                <div class="mb-7.5">
                    <label for="email" class="mb-2.5 flex items-center gap-2 text-sm font-medium text-foreground">
                        <svg class="size-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Nova Senha
                    </label>
                    <div class="relative">
                        <?php echo $forms->input(
                            "text",
                            "nova_senha",
                            "nova_senha",
                            "",
                            "Digite a nova senha",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', true
                        ); ?>

                        <?php echo $forms->input(
                            "hidden",
                            "unique_id",
                            "unique_id",
                            $unique_id,
                            "",
                            "h-10 w-full rounded-md shadow-md border border-input bg-background px-3 py-2 text-sm", '', true
                        ); ?>
                    </div>
                </div>

                <?php echo $forms->button(
                    "submit",
                    "senha",
                    "senha",
                    "w-full h-10 shadow-md button menu-button permissions kt-btn kt-btn-sm rounded-full",
                    "",
                    "Salvar"
                ); ?>

            <?php echo $forms->formF(); ?> 

        <?php endif; ?>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('reenviar_codigo');
        const STORAGE_KEY = 'tempo_reenvio_restante';
        const TEMPO_ESPERA = 60;

        function iniciarContagem(segundosRestantes) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            const textoOriginal = "Reenviar Código";

            const intervalo = setInterval(function() {
                segundosRestantes--;
                btn.innerText = `Aguarde ${segundosRestantes}s`;

                const tempoFinal = Math.floor(Date.now() / 1000) + segundosRestantes;
                
                if (segundosRestantes <= 0) {
                    clearInterval(intervalo);
                    btn.disabled = false;
                    btn.innerText = textoOriginal;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    localStorage.removeItem(STORAGE_KEY);
                }
            }, 1000);
        }

        const tempoFinalSalvo = localStorage.getItem(STORAGE_KEY);
        if (tempoFinalSalvo) {
            const agora = Math.floor(Date.now() / 1000);
            const restante = tempoFinalSalvo - agora;

            if (restante > 0) {
                iniciarContagem(restante);
            } else {
                localStorage.removeItem(STORAGE_KEY);
            }
        }

        if (btn) {
            const form = btn.closest('form');
            form.addEventListener('submit', function() {
                if (btn.disabled) return;

                const tempoFinal = Math.floor(Date.now() / 1000) + TEMPO_ESPERA;
                localStorage.setItem(STORAGE_KEY, tempoFinal);

                setTimeout(() => {
                    iniciarContagem(TEMPO_ESPERA);
                }, 10);
            });
        }
    });
</script>
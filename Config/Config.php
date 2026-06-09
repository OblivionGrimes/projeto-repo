<?php

namespace Config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


define('BASE_URL', 'http://localhost/barber_shop/');

class Config {

    public function sanitize($input): string {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    public function alerta_toast($TEXTO_ALERTA, $tipo = 1)
    {
        $tipo = ($tipo == 1) ? 'sucesso' : 'erro';
        $alerta_escapado = addslashes($TEXTO_ALERTA);

        $cor = ($tipo == 'sucesso') ? '#17c653' : '#f8285a';
        $duracao = 4500; 

        ?>
        <script>
            function exibirToast() {
                const toast = document.createElement('div');
                const timerBar = document.createElement('div');
                const closeBtn = document.createElement('button');

                let timeoutRemover;

                // CONTEÚDO
                toast.innerHTML = `
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px;">
                        <span><?php echo $alerta_escapado; ?></span>
                    </div>
                `;

                // BOTÃO FECHAR
                closeBtn.innerHTML = '&times;';
                closeBtn.style.background = 'transparent';
                closeBtn.style.border = 'none';
                closeBtn.style.color = '#fff';
                closeBtn.style.fontSize = '20px';
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.lineHeight = '1';

                closeBtn.onclick = function () {
                    clearTimeout(timeoutRemover);
                    fecharToast();
                };

                toast.querySelector('div').appendChild(closeBtn);

                // TIMER BAR
                timerBar.style.position = 'absolute';
                timerBar.style.bottom = '0';
                timerBar.style.left = '0';
                timerBar.style.height = '4px';
                timerBar.style.width = '100%';
                timerBar.style.background = 'rgba(255,255,255,0.8)';
                timerBar.style.transition = `width <?php echo $duracao; ?>ms linear`;

                // ESTILO TOAST
                toast.style.position = 'fixed';
                toast.style.top = '0';
                toast.style.left = '50%';
                toast.style.zIndex = '9999';
                toast.style.transform = 'translate(-50%, -150%)';
                toast.style.opacity = '0';
                toast.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                toast.style.backgroundColor = '<?php echo $cor; ?>';
                toast.style.color = '#fff';
                toast.style.padding = '16px 24px 20px';
                toast.style.borderRadius = '12px';
                toast.style.boxShadow = '0px 10px 30px rgba(0,0,0,.2)';
                toast.style.fontFamily = 'Inter, Helvetica, sans-serif';
                toast.style.fontWeight = '600';
                toast.style.minWidth = '320px';
                toast.style.textAlign = 'left';
                toast.style.position = 'fixed';
                toast.style.overflow = 'hidden';

                toast.appendChild(timerBar);
                document.body.appendChild(toast);

                // ENTRADA
                setTimeout(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translate(-50%, 50px)';
                    timerBar.style.width = '0%';
                }, 100);

                // FECHAR
                function fecharToast() {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translate(-50%, -150%)';
                    setTimeout(() => {
                        if (toast.parentNode) toast.remove();
                    }, 600);
                }

                timeoutRemover = setTimeout(fecharToast, <?php echo $duracao; ?>);
            }

            exibirToast();
        </script>
        <?php
    }


    // Função para recarregar a pagina
    public function reloading(string $url = '') {
        $url = $url ?: BASE_URL . 'd/manage/admin/index';

        return <<<HTML
    <script>
        setTimeout(() => {
            if (window.parent) {
                window.parent.location.href = "{$url}";
            }
        }, 800);
    </script>
    HTML;
    }

    // Função para gerar o codigo de verificação
    public function recoveryCode() {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Função para envio de email (via composer phpmailer)
    public function sendEmail($para, $assunto, $mensagem)
    {

        $mail = new PHPMailer(true);

        try {
            // SMTP
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];

            // Remetente
            $mail->setFrom(
                $_ENV['MAIL_FROM'],
                $_ENV['MAIL_FROM_NAME']
            );

            // Destinatário
            $mail->addAddress($para);

            // Conteúdo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;

            $mail->send();
            return true;

        } catch (Exception $e) {
            // opcional: logar $mail->ErrorInfo
            return false;
        }
    }


}
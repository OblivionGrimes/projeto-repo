<?php

    $isIframe  = isset($_GET['iframe']) && $_GET['iframe'] == 'customers';

    ############################## Codigos da pagina ##############################
    if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['registro_cliente'])) {

        $numero_cliente = $_POST['numero_cliente'] ?? '';
        $contato_cliente = $_POST['contato_cliente'] ?? '';
        $nome_cliente = $_POST['nome_cliente'] ?? '';
        $cnpj = $_POST['cnpj'] ?? '';

        $result = $EnterpriseRepository->createCliente([
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


<div class="flex flex-col grow kt-scrollable-y-auto lg:[--kt-scrollbar-width:auto] bg-white ">

    <div class="kt-container kt-container-fluid">

        <div class="flex justify-center">

            <!-- largura controlada -->
            <div class="w-full max-w-3xl">

                <div class="kt-card h-100">

                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-outline ki-bank fs-2 text-primary me-2"></i>
                            Cadastrar Novo Cliente
                        </h3>
                    </div>

                    <div class="kt-card-content">
                        <?php echo $forms->formI("POST"); ?>

                        <div class="grid gap-5">
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("numero_cliente", "Número do Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "numero_cliente", "numero_cliente", "", "Digite o número que consta no sistema", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("nome_cliente", "Nome do Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "nome_cliente", "nome_cliente", "", "Digite o nome do cliente", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("contato_cliente", "Contato do Cliente", "kt-form-label pb-2"); ?>
                                <?php echo $forms->inputTel("tel", "contato_cliente", "contato_cliente", "", "Digite o telefone (somente números)", "[0-9]{10,11}", "11", "kt-input w-full", false) ?>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("cnpj", "CNPJ", "kt-form-label pb-2"); ?>
                                <?php echo $forms->input("text", "cnpj", "cnpj", "", "00.000.000/0000-00", "kt-input w-full", "18", false); ?>
                            </div>

                            <div class="flex justify-end pt-2">
                                <?php echo $forms->button(
                                    "submit", 
                                    "registro_cliente", 
                                    "registro_cliente", 
                                    "button menu-button permissions kt-btn kt-btn-sm rounded-full", 
                                    "ki-outline ki-cloud-add", 
                                    "CADASTRAR"
                                ); ?>
                            </div>

                        </div>
                        <?php echo $forms->formF(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
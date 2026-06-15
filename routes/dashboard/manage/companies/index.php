<?php

    $isIframe  = isset($_GET['iframe']) && $_GET['iframe'] == 'companies';

    ############################## Codigos da pagina ##############################

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro_empresa']) && $PermissionRepository->isMaster()) {
        // Captura os dados do formulário
        $nome_empresa = trim($_POST['nome_empresa']);
        $cnpj_limpo = preg_replace('/[^0-9]/', '', $_POST['cnpj']);

        // Validação básica
        if(empty($nome_empresa) || empty($cnpj_limpo)) {
            $config->alerta_toast("Por favor, preencha todos os campos.",2);
        } elseif(!preg_match('/^\d{14}$/', $cnpj_limpo)) {
            $config->alerta_toast("CNPJ inválido. Insira 14 dígitos numéricos.",2);
        } else {
            // Inserção no banco de dados
            $return = $EnterpriseRepository->createEnterprise([
                'nome' => $nome_empresa,
                'cnpj' => $cnpj_limpo
            ]);

            if ($return === true) {
                if ($isIframe) {
                    echo $config->reloading();
                }
                
                $config->alerta_toast('Empresa criada com sucesso!', 1);
            } elseif ($return === null) {
                $config->alerta_toast('CNPJ já cadastrado.', 2);
            } else {
                $config->alerta_toast('Erro ao criar empresa.', 3);
            }

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
                            Cadastrar Nova Empresa
                        </h3>
                    </div>

                    <div class="kt-card-content">
                        <?php echo $forms->formI("POST"); ?>

                        <div class="grid gap-5">
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("nome_empresa", "Nome da Empresa", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "nome_empresa", "nome_empresa", "", "Digite o nome da empresa", "kt-input w-full", "", true); ?>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("cnpj", "CNPJ", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "cnpj", "cnpj", "", "00.000.000/0000-00", "kt-input w-full", "18", true); ?>
                            </div>

                            <div class="flex justify-end pt-2">
                                <?php echo $forms->button(
                                    "submit", 
                                    "registro_empresa", 
                                    "registro_empresa", 
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
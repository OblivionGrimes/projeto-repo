<!-- Drawer Edit -->
<?php 
    //$isIframe  = isset($_GET['iframe']) && $_GET['iframe'] == 'customerEdit';
    $unique_customer  = $_GET['customer_unique'] ?? null;

    $customer = $CustomerRepository->getIdCustomer($unique_customer);

    //echo $customer->getStatus();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_cliente'])){

        $numero_cliente = $config->sanitize($_POST['numero_cliente']);
        $contato_cliente = $config->sanitize($_POST['contato_cliente']);
        $nome_cliente = $config->sanitize($_POST['nome_cliente']);
        $cnpj = $config->sanitize($_POST['cnpj']);
        $status = $_POST['BT_STATUS'];
        $gm_status = $_POST['BT_GM_STATUS'];

        $result = $CustomerRepository->editCustomer([
            'numero_cliente' => $numero_cliente,
            'contato_cliente' => $contato_cliente,
            'nome_cliente' => $nome_cliente,
            'cnpj_cliente' => $cnpj,
            'status_cliente' => $status,
            'gm_cliente' => $gm_status,
            'unique_id' => $customer->getUniqueId()
        ]);

        var_dump($result);

        if ($result === true) {
            $config->alerta_toast("Cliente editado com sucesso!", 1);
        } elseif ($result === null) {
            $config->alerta_toast("O número do cliente informado já está cadastrado.", 2);
        } else {
            $config->alerta_toast("Ocorreu um erro ao editar o cliente.", 2);
        }

    }


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
                            <?= $customer->getNameCliente() ?>
                        </h3>
                    </div>

                    <div class="kt-card-content">
                        <?php echo $forms->formI("POST"); ?>

                        <div class="grid gap-5">
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("numero_cliente", "Número do Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("number", "numero_cliente", "numero_cliente", $customer->getNumeroCliente(), "Digite o número que consta no sistema", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("nome_cliente", "Nome do Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "nome_cliente", "nome_cliente", $customer->getNameCliente(), "Digite o nome do cliente", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("contato_cliente", "Contato do Cliente", "kt-form-label pb-2"); ?>
                                <?php echo $forms->inputTel("tel", "contato_cliente", "contato_cliente", $customer->getContatoCliente(), "Digite o telefone (somente números)", "[0-9]{10,11}", "11", "kt-input w-full", false) ?>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("cnpj", "CNPJ", "kt-form-label pb-2"); ?>
                                <?php echo $forms->input("text", "cnpj", "cnpj", $customer->getCnpj(), "00.000.000/0000-00", "kt-input w-full", "18", false); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("BT_STATUS", "Status cliente", "kt-form-label pb-2"); ?>
                                <?php echo $forms->input_switch("BT_STATUS" ,$customer->getStatus(), "ativo"); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("BT_GM_STATUS", "Faz parte do grupo GM?", "kt-form-label pb-2"); ?>
                                <?php echo $forms->input_switch("BT_GM_STATUS" ,$customer->getGmCliente(), "sim"); ?>
                            </div>

                            <div class="flex justify-end pt-2">
                                <?php echo $forms->button(
                                    "submit", 
                                    "edit_cliente", 
                                    "edit_cliente", 
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
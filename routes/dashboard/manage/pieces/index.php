<!-- create peça do home/em aberto -->

<?php

$tipo_vidro = $piecesRepository->getAllGlass();
$optionsVidro = array_column($tipo_vidro, 'tipo_vidro', 'unique_id');

$motivos = $piecesRepository->getAllMotives();
$optionsMotivo = array_column($motivos, 'motivo', 'unique_id');

    $espessuras = $piecesRepository->getAllEspessuras();
    $optionsEspessuras = array_column($espessuras, 'tam_espessura', 'id_espessura');

$clientes = $CustomerRepository->getAllCustomers();
$optionsClientes = [];
foreach ($clientes as $cliente) {
    $optionsClientes[$cliente->getUniqueId()] = $cliente->getNameCliente();
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastro_reposicao'])) {
        $numero_peca = $_POST['numero_peca'];
        $pedido_cliente = $_POST['pedido_cliente'];
        $cliente_id = $_POST['cliente_id']; // uuid
        $numero_pedido = $_POST['numero_pedido'];
        $motivo_id = $_POST['motivo_id']; // uuid
        $vidro_id = $_POST['vidro_id']; // uuid
        $espessura_id = $_POST['espessura_id']; // id
        $altura_largura = $_POST['altura_largura'];

        // Chamar a função para criar a peça
        $teste = $piecesRepository->createPiece([
            'numero_peca' => $numero_peca,
            'pedido_cliente' => $pedido_cliente,
            'cliente_id' => $cliente_id,
            'numero_pedido' => $numero_pedido,
            'motivo_id' => $motivo_id,
            'vidro_id' => $vidro_id,
            'espessura_id' => $espessura_id,
            'altura_largura' => $altura_largura
        ]);

        var_dump($teste);
        //$config->alerta_toast("Peça cadastrada com sucesso!", 1);
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
                            Cadastrar peça
                        </h3>
                    </div>

                    <div class="kt-card-content">
                        <?php echo $forms->formI("POST"); ?>

                        <div class="grid gap-5">

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("numero_peca", "Nº da peça", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "numero_peca", "numero_peca", "", "Digite o número da peça", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <!-- adicionar no banco de dados o numero do pedido cliente -->
                                <?php echo $forms->label("pedido_cliente", "Nº pedido Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "pedido_cliente", "pedido_cliente", "", "Digite o número do pedido cliente", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("cliente_id", "Cliente", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->inputSelect("cliente_id", "cliente_id", $optionsClientes, "", true) ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("numero_pedido", "Nº do pedido", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "numero_pedido", "numero_pedido", "", "Digite o número do pedido", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("motivo_id", "Motivo da reposição", "kt-form-label pb-2"); ?>
                                <?php echo $forms->inputSelect("motivo_id", "motivo_id", $optionsMotivo, "", true) ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("vidro_id", "Tipo do vidro", "kt-form-label pb-2"); ?>
                                <?php echo $forms->inputSelect("vidro_id", "vidro_id", $optionsVidro, "", true) ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("espessura_id", "Espessura", "kt-form-label pb-2"); ?>
                                <?php echo $forms->inputSelect("espessura_id", "espessura_id", $optionsEspessuras, "", true) ?>
                            </div>

                            <!-- Usar o explode no x, fazer uma maskara para verificar se esta conforme -->
                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("altura_largura", "Dimensões", "kt-form-label pb-2"); ?>
                                <?php echo $forms->input("text", "altura_largura", "altura_largura", "", "Digite com o 'X'   '****X****' ", "kt-input w-full", "", true) ?>
                            </div>

                            <!-- adicionar campo de observações -->

                            <div class="flex justify-end pt-2">
                                <!-- input hidden devido a máscara em js -->
                                <?php echo $forms->input("hidden", "cadastro_reposicao", "cadastro_reposicao", "1") ?>
                                <?php echo $forms->button(
                                    "submit",
                                    "cadastro_reposicao",
                                    "cadastro_reposicao",
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

<script>
    // Adicionando máscara para o campo de número da peça 

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");

        const inputMask = form.querySelector("#numero_peca");

        inputMask.addEventListener("input", function(evento) {

            let valor = evento.target.value;

            valor = valor.replace(/\D/g, "");

            if (valor.length > 6) {
                valor = valor.slice(0, 6) + "-" + valor.slice(6);
            }

            evento.target.value = valor;
        });
    });


    // Adicionando máscara para o campo de dimensões

    document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const alturaLarguraInput = document.getElementById("altura_largura");
        const alturaLarguraValue = alturaLarguraInput.value.trim();

        const regex = /^\d+X\d+$/;
        if (!regex.test(alturaLarguraValue)) {
            alert("Por favor, insira a Altura X Largura no formato correto (ex: 1234X5678).");
            return;
        }

        form.submit();
    });
});
</script>
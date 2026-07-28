<!-- Drawer create conferente/marcador -->

<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro_conferente'])) {
        $nome_conferente = $_POST['nome_conferente'];
        $turno_conferente = $_POST['turno_conferente'];
        $tipo_conferente = $_POST['tipo_conferente'];

        // Call the repository method to create a new marker
        $success = $piecesRepository->createMarker($nome_conferente, $turno_conferente, $tipo_conferente);

        if ($success) {
            echo '<div class="alert alert-success">Conferente/Marcador cadastrado com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger">Erro ao cadastrar Conferente/Marcador. Tente novamente.</div>';
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
                            Cadastrar Conferente/Marcador
                        </h3>
                    </div>

                    <div class="kt-card-content">
                        <?php echo $forms->formI("POST"); ?>

                        <div class="grid gap-5">

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("nome_conferente", "Conferente/Marcador", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->input("text", "nome_conferente", "nome_conferente", "", "Digite o nome do conferente/marcador", "kt-input w-full", "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("turno_conferente", "Turno", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->inputSelect("turno_conferente", "turno_conferente", ['manha' => 'Manhã', 'noite' => 'Noite'], "", true); ?>
                            </div>

                            <div class="flex flex-col gap-2">
                                <?php echo $forms->label("tipo_conferente", "Tipo", "kt-form-label pb-2 required"); ?>
                                <?php echo $forms->inputSelect("tipo_conferente", "tipo_conferente", ['marcador' => 'Marcador', 'conferente' => 'Conferente'], "", true); ?>
                            </div>

                            <div class="flex justify-end pt-2">
                                <?php echo $forms->button(
                                    "submit", 
                                    "registro_conferente", 
                                    "registro_conferente", 
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
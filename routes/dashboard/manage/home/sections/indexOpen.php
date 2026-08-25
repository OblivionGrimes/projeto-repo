<?php

    $customers = $CustomerRepository->getAllCustomers();

?>

<section id="section-aberto" class="admin-section">
    <div class="col-xl-6 padding-5">
        <div class="kt-card h-100 shadow-md">

            <!-- header da lista -->
            <div class="kt-card-header">
                <div class="kt-card-title">
                    <h3 class="fw-bold">
                        <i class="ki-outline ki-tablet fs-2 text-primary me-2"></i>
                        Peças em aberto
                    </h3>
                </div>

                <!-- iframe de criação da reposição -->
                <?= $forms->drawerI('kt_aberto_drawer', 'kt-drawer kt-drawer-end flex-col w-[520px] top-5 bottom-5 end-5 rounded-xl flex hidden', 
                    'companies-drawer', 'kt_aberto_drawer_close') ?>

                    <div class="flex items-right justify-end bg-white rounded-xl p-2">
                        <button type="button" class="btn btn-sm btn-icon btn-light flex items-center justify-center cursor-pointer" data-kt-drawer-dismiss="true">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </button>
                    </div>

                    <div class="w-full flex justify-center py-8">
                        <iframe
                            class="drawer-iframe w-full bg-transparent border-0 rounded-xl"
                            style="height: calc(92vh - 5vh);">
                        </iframe>
                    </div>

                <?= $forms->drawerF() ?>

                <div class="flex items-center gap-2">

                    <!-- button do modal de criação da reposição-->
                    <?= $forms->buttonDrawer("kt_aberto_drawer", BASE_URL."d/manage/pieces/index?iframe=pieces", "Adicionar peça", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-plus-circle fs-4", "Adicionar peça") ?>

                    <button
                        type="button"
                        class="button menu-button permissions kt-btn kt-btn-sm rounded-full hidden"
                        data-refresh-table
                    >
                        <i class="ki-outline ki-eraser fs-4"></i>
                        <span class="texto-permissao">
                            Limpar filtros
                        </span>
                    </button>

                </div>
            </div>

            
            <!-- body da lista -->
            <div class="kt-card-body p-0 table-normal-size">
                <div class="table-responsive">
                    <table class="kt-table table-auto kt-table-border align-middle">
                        <thead>
                            <tr class="text-gray-500 fw-semibold fs-7 text-uppercase">
                                <th>Nº Peça</th>
                                <th>Nº Pedido</th>
                                <th>Motivo</th>
                                <th>Tipo</th>
                                <th>Comprimento</th>
                                <th>Setor</th>
                                <th>Data</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-700" id="frames-table" data-filter-scope>

                                <?php
                                    foreach ($customers as $resC):
                                    #$empresa = $EnterpriseRepository->getEnterpriseById($frame->getEmpresaId())[0];
                                    #$empresaId   = $frame->getEmpresaId();
                                    #$empresaNome = $empresa->getNameEmpresa();
                                ?>

                                <tr class="odd:bg-gray-50 even:bg-white hover:bg-gray-100 transition-colors duration-200" data-filter-row>

                                    <!-- Nº Peça -->
                                    <td>
                                        <span>
                                            <?= $resC->getNumeroCliente() ?>
                                        </span>
                                    </td>

                                    <!-- Nº Pedido -->
                                    <td>
                                        <a class="text-muted fs-8 text-truncate mw-300px d-inline-block">
                                            <i class="ki-outline ki-exit-right-corner fs-4"></i>
                                            <span class="texto-permissao">
                                                <?= ucfirst($resC->getNameCliente()); ?>
                                            </span>
                                        </a>
                                    </td>

                                    <!-- Motivo -->
                                    <td>
                                        <span class="text-muted fs-8 text-truncate mw-300px">
                                            <?= $mask->maskTelefone($resC->getContatoCliente()) ?>
                                        </span>
                                    </td>

                                    <!-- Tipo -->
                                    <td>
                                        <i class="ki-outline ki-switch fs-4"></i>
                                        <?= $mask->formatarCnpj($resC->getCnpj()) ?>
                                    </td>

                                    <!-- Comprimento -->
                                    <td>
                                        <span class="text-muted fs-8 text-truncate mw-300px">
                                            <?= $mask->maskTelefone($resC->getContatoCliente()) ?>
                                        </span>
                                    </td>

                                    <!-- Setor -->
                                    <td>
                                        <i class="ki-outline ki-switch fs-4"></i>
                                        <?= $mask->formatarCnpj($resC->getCnpj()) ?>
                                    </td>

                                    <!-- Data erro -->
                                    <td>
                                        <i class="ki-outline ki-switch fs-4"></i>
                                        <?= $mask->formatarCnpj($resC->getCnpj()) ?>
                                    </td>

                                    <!-- Ações -->
                                    <td class="text-end">
                                        <form method="POST" class="d-inline">
                                            <div class="flex justify-end items-center gap-2">
                                                <input type="hidden" name="current_section" class="current-section-input">
                                                <input type="hidden" name="unique_id" value="<?= base64_encode($resC->getUniqueId()) ?>">

                                                <!-- button do modal de edição da reposição -->
                                                <?= $forms->buttonDrawer("kt_aberto_drawer", BASE_URL."d/manage/customers/edit?iframe=customerEdit&customer_unique=".base64_encode($resC->getUniqueId()), "Editar cliente", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-pencil fs-4", "", "Editar painel") ?>

                                                <!-- button do modal de mais informações -->   
                                                <?= $forms->buttonDrawer("kt_aberto_drawer", BASE_URL."d/manage/customers/edit?iframe=customerEdit&customer_unique=".base64_encode($resC->getUniqueId()), "Editar cliente", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-pencil fs-4", "", "Editar painel") ?>                                                

                                            </div>
                                            
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
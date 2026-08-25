<!-- section de motivos -->

<?php

    $motives = $piecesRepository->getAllMotives();

?>


<section id="section-motive" class="admin-section">
    <div class="col-xl-6 padding-5">
        <div class="kt-card h-100 shadow-md">

            <!-- header da lista -->
            <div class="kt-card-header">
                <div class="kt-card-title">
                    <h3 class="fw-bold">
                        <i class="ki-outline ki-tablet fs-2 text-primary me-2"></i>
                        Motivos 
                    </h3>
                </div>

                <!-- iframe de criação do frame -->
                <?= $forms->drawerI('kt_motive_drawer', 'kt-drawer kt-drawer-end flex-col w-[520px] top-5 bottom-5 end-5 rounded-xl flex hidden', 
                    'companies-drawer', 'kt_motive_drawer_close') ?>

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

                    <!-- button do modal de criação do companies-->
                    <?= $forms->buttonDrawer("kt_motive_drawer", BASE_URL."d/manage/pieces/indexMotive?iframe=motive", "Adicionar motivo", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-plus-circle fs-4", "Adicionar motivo") ?>

                </div>
            </div>

            
            <!-- body da lista -->
            <div class="kt-card-body p-0 table-normal-size">
                <div class="table-responsive">
                    <table class="kt-table table-auto kt-table-border align-middle">
                        <thead>
                            <tr class="text-gray-500 fw-semibold fs-7 text-uppercase">
                                <th>Nº</th>
                                <th>Motivo</th>
                                <th>Data</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-700">

                            <?php
                                $i = 1;
                                foreach ($motives as $resM):
                            ?>

                                <tr>

                                    <!-- Numero -->
                                    <td>
                                        <span>
                                            <?= $i++; ?>
                                        </span>
                                    </td>

                                    <!-- motivo -->
                                    <td>
                                        <a class="text-muted fs-8 text-truncate mw-300px d-inline-block">
                                            <i class="ki-outline ki-exit-right-corner fs-4"></i>
                                            <span class="texto-permissao">
                                                <?= ucfirst($resM['motivo']); ?>
                                            </span>
                                        </a>
                                    </td>

                                    <!-- Data -->
                                    <td>
                                        <span class="text-muted fs-8 text-truncate mw-300px">
                                            <?= $mask->Data($resM['CREATE_AT']) ?>
                                        </span>
                                    </td>

                                    <!-- Ações -->
                                    <td class="text-end">
                                        <form method="POST" class="d-inline">
                                            <div class="flex justify-end items-center gap-2">
                                                <input type="hidden" name="current_section" class="current-section-input">
                                                <input type="hidden" name="unique_id" value="<?= base64_encode($resM['unique_id']) ?>">

                                                <!-- verificar se tem alguma ligação, se não houver, poderar excluir -->
                                                <button
                                                    type="submit"
                                                    name="delete_motivo"
                                                    onclick="return confirm('Tem certeza que deseja excluir este motivo?')"
                                                    class="kt-btn kt-btn-icon kt-btn-destructive kt-btn-sm"
                                                    title="Excluir"
                                                >
                                                    <i class="ki-outline ki-trash fs-4"></i>
                                                </button> 

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
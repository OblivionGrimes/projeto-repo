<section id="section-companies" class="admin-section">
    <div class="col-xl-6 padding-5">
        <div class="kt-card h-100 shadow-md">

            <!-- header da lista -->
            <div class="kt-card-header">
                <div class="kt-card-title">
                    <h3 class="fw-bold">
                        <i class="ki-outline ki-tablet fs-2 text-primary me-2"></i>
                        Painéis 
                    </h3>
                </div>

                <!-- iframe de criação do frame -->
                <?= $forms->drawerI('kt_companies_drawer', 'kt-drawer kt-drawer-end flex-col w-[520px] top-5 bottom-5 end-5 rounded-xl flex hidden', 
                    'companies-drawer', 'kt_companies_drawer_close') ?>

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

                    <!-- button do modal de criação do frame -->
                    <?= $forms->buttonDrawer("kt_companies_drawer", BASE_URL."d/manage/companies/index?iframe=companies", "Criar Frame", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-plus-circle fs-4", "Criar painel") ?>

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
                                <th>Nome</th>
                                <th>URL</th>
                                <th>Descrição</th>
                                <th>Empresa</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-700" id="frames-table" data-filter-scope>
                            <!-- Foreach -->
                                <?php
                                    #$empresa = $EnterpriseRepository->getEnterpriseById($frame->getEmpresaId())[0];
                                    #$empresaId   = $frame->getEmpresaId();
                                    #$empresaNome = $empresa->getNameEmpresa();
                                ?>

                                <tr data-empresa-nome="<?= htmlspecialchars('teste') ?>"
                                    data-status="<?= 'Ativo' ?>">

                                    <!-- Nome -->
                                    <td>
                                        <span>
                                            <?= htmlspecialchars('teste') ?>
                                        </span>
                                    </td>

                                    <!-- URL -->
                                    <td>
                                        <a href="<?= htmlspecialchars('teste') ?>"
                                        target="_blank"
                                        class="text-muted fs-8 text-truncate mw-300px d-inline-block">
                                            <i class="ki-outline ki-exit-right-corner fs-4"></i>
                                            <span class="texto-permissao">
                                                <?= strlen('teste') > 55
                                                    ? htmlspecialchars(substr('teste', 0, 55)) . '...'
                                                    : htmlspecialchars('teste') ?>
                                            </span>
                                        </a>
                                    </td>

                                    <!-- Descrição -->
                                    <td>
                                        <span class="text-muted fs-8 text-truncate mw-300px">
                                            <?= htmlspecialchars('teste') ?>
                                        </span>
                                    </td>

                                    <!-- Empresa (CLICÁVEL) -->
                                    <td>
                                        <button
                                            type="button"
                                            class="empresa-filter
                                                kt-link
                                                alvorecer-2
                                                cursor-pointer
                                                position-relative"
                                            data-filter-key="empresaNome"
                                            data-filter-value="<?= htmlspecialchars('teste') ?>"
                                        >
                                            <i class="ki-outline ki-switch fs-4"></i>
                                            <?= ucfirst('teste') ?>
                                        </button>
                                    </td>

                                    <!-- Status -->
                                    <?php $badgeColor = ('ativo' === 'ativo') ? 'status-active' : 'status-inactive'; ?>

                                    <td>
                                        <button 
                                            type="button"
                                            class="status-filter status-badge kt-badge-sm uppercase cursor-pointer <?= $badgeColor ?>"
                                            data-filter-key="status"
                                            data-filter-value="<?= 'ativo' ?>"
                                        >
                                            <?= 'ativo' ?>
                                        </button>
                                    </td>


                                    <!-- Ações -->
                                    <td class="text-end">
                                        <form method="POST" class="d-inline">
                                            <div class="flex justify-end items-center gap-2">
                                                <input type="hidden" name="current_section" class="current-section-input">
                                                <input type="hidden" name="unique_id" value="<?= 'teste' ?>">

                                                <!-- button do modal de edição do frame -->
                                                <?= $forms->buttonDrawer("kt_companies_drawer", BASE_URL."d/manage/frames/edit?iframe=frameEdit&frame_unique=".'ativo', "Editar frame", "button menu-button permissions kt-btn kt-btn-sm rounded-full", "ki-outline ki-pencil fs-4", "", "Editar painel") ?>


                                                <!-- SWITCH, precisa de dois inputs aqui ja que um é para executar a ação e o outro para o envio do 'name' -->
                                                <input
                                                    type="hidden"
                                                    name="<?= 'ativo' === 'ativo' ? 'desativa_bi' : 'active_bi' ?>"
                                                >
                                                <input
                                                    type="checkbox"
                                                    class="kt-switch kt-switch-sm menu-button switch"
                                                    <?= 'ativo' === 'ativo' ? 'checked' : '' ?>
                                                    onclick="this.form.submit();"
                                                >


                                                <?php if($PermissionRepository->isMaster()): ?>
                                                    <button
                                                        type="submit"
                                                        name="delete_bi"
                                                        onclick="return confirm('Tem certeza que deseja excluir este painel?')"
                                                        class="kt-btn kt-btn-icon kt-btn-destructive kt-btn-sm"
                                                        title="Excluir"
                                                    >
                                                        <i class="ki-outline ki-trash fs-4"></i>
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                            
                                        </form>
                                    </td>

                                </tr>
                            <!-- endforeach; -->
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
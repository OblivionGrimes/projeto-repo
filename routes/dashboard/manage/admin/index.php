<!-- Container principal -->
<div class="flex flex-col lg:flex-row flex-1 w-full min-w-0">

    <!-- Aside aqui -->
    <?= $forms->asideI('sidebar', 'hidden lg:flex flex-col fixed top-0 bottom-0 left-0 border-r border-gray-200 bg-white shadow-lg rounded-sm w-72 h-screen transition-all duration-300 z-50 overflow-hidden relative') ?>

        <!-- trabalhar aqui com sections mesmo -->

        <div class="px-3 py-4 flex-1">

            <div class="px-3 py-2 transition-opacity duration-200" id="sidebar-title-bi">
                <h3 class="text-xs font-semibold text-gray-500 uppercase whitespace-nowrap">Menu do ASIDE</h3>
            </div>

            <ul class="flex flex-col gap-1">
                <li>
                    <a href="#" data-target="section-companies" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-tablet fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Cadastro de Clientes</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-target="section-empresas" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-bank fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Cadastro de Funcionários</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-target="section-usuarios" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-users fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Relatórios</span>
                    </a>
                </li>

                <li>
                    <div class="kt-menu kt-menu-default " data-kt-menu="true">
                        <div class="kt-menu-item kt-menu-item-dropdown w-full"
                            data-kt-menu-item-offset="0, 0"
                            data-kt-menu-item-placement="bottom-start"
                            data-kt-menu-item-toggle="dropdown"
                            data-kt-menu-item-trigger="click">

                            <button class="kt-menu-toggle flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 w-full">
                                <i class="ki-filled ki-additem fs-5 text-gray-500"></i>
                                <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Cadastros</span>
                                <i class="ki-filled ki-down text-xs ms-auto"></i>
                            </button>

                            <div class="kt-menu-dropdown py-2 kt-scrollable-y " style="sidebar-dropdown-width;">

                                <div class="kt-menu-item ">
                                    <a href="#" data-target="section-usuarios" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                                        <!-- <i class="ki-outline ki-users fs-5 text-gray-500"></i> -->
                                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Relatórios</span>
                                    </a>
                                </div>

                                <div class="kt-menu-item active">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-title text-sm">Fevereiro, 2024</span>
                                    </a>
                                </div>

                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-title text-sm">Março, 2024</span>
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                </li>

            </ul>
        </div>

    <?= $forms->asideF() ?>
    
    <main class="flex-1 flex-col pb-10">
        <div class="kt-container kt-container-fluid pt-5">

        <!-- Incluir as sections aqui depois -->

        <?php include __DIR__ . '/sections/customers.php' ?>
        

        </div>
    </main>
    
</div>


<script src="<?= BASE_URL ?>static/js/section.js"></script>

<script src="<?= BASE_URL ?>static/js/aside.js"></script>
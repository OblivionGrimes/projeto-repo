<!-- Container principal -->
<div class="flex flex-col lg:flex-row flex-1 w-full min-w-0">

    <!-- Aside aqui -->
    <?= $forms->asideI('sidebar', 'hidden lg:flex flex-col fixed top-0 bottom-0 left-0 border-r border-gray-200 bg-white shadow-lg rounded-sm w-72 h-screen transition-all duration-300 z-50 overflow-hidden relative') ?>


        <div class="px-3 py-4 flex-1">

            <div class="px-3 py-2 transition-opacity duration-200" id="sidebar-title-bi">
                <h3 class="text-xs font-semibold text-gray-500 uppercase whitespace-nowrap">Menu do ASIDE</h3>
            </div>

            <ul class="flex flex-col gap-1">
                <li>
                    <a href="#" data-target="section-frames" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-tablet fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Em Aberto</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-target="section-empresas" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-bank fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Peças finalizadas</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-target="section-usuarios" class="sidebar-link flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 group">
                        <i class="ki-outline ki-users fs-5 text-gray-500"></i>
                        <span class="text-sm sidebar-text whitespace-nowrap transition-opacity duration-200">Aguardando Peças</span>
                    </a>
                </li>
            </ul>
        </div>

    <?= $forms->asideF() ?>
    
    <main class="flex-1 flex-col pb-10">
        <div class="kt-container kt-container-fluid pt-5">

        <!-- Aqui vai ser a parte principal do conteúdo, contendo as tables de reposições em aberto e etc. -->

        

        </div>
    </main>
    
</div>

<script src="<?= BASE_URL ?>/static/js/section.js"></script>

<script src="<?= BASE_URL ?>/static/js/aside.js"></script>
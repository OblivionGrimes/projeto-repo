<?php

    $Nada = "nada";

?>


<header id="header" class="fixed w-full border-b border-gray-200 shadow-md bg-major-2">
    
    <nav class="h-full w-full max-w-[1320px] min-w-0 mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            <div class="flex items-center gap-4 sm:gap-6 max-w-full">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    
                    <img
                        src="<?= BASE_URL ?>static/img/#.svg"
                        class="h-8 sm:h-10 w-auto object-contain shrink-0"
                        alt="Logo"
                    />

                    <span class="text-gray-400 mx-1 shrink-0 text-sm sm:text-base">
                        |
                    </span>

                    <span
                        class="font-bold text-gray-400 tracking-tight
                            text-xs sm:text-sm
                            truncate max-w-[120px] sm:max-w-none">
                        <?= strtoupper($Nada); ?>
                    </span>

                </div>
            </div>


            <div class="flex items-center gap-3 lg:gap-6"> 

                <a href="<?= BASE_URL ?>d/manage/home/index" 
                   class="menu-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold">
                
                    <svg class="menu-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    
                    <span class="menu-text hidden lg:inline">
                        Home
                    </span>
                </a>
                

                <a href="<?= BASE_URL ?>d/manage/customers/index" 
                    class="menu-item flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold">
                    
                    <svg class="menu-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75V21m-10.5 0V10.5m10.5 10.5H21"/>
                    </svg>

                    <span class="menu-text hidden lg:inline">
                        Clientes
                    </span>
                </a>


                <div class="relative">

                    <button id="user-dropdown-button"
                        class="menu-item w-full flex items-center gap-3
                            px-3 py-2 rounded-lg text-sm font-semibold duration-200 focus:outline-none">

                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5 text-blue-600"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>

                        <div class="flex-1 text-left hidden lg:block leading-tight">
                            <div class="menu-text text-sm font-medium ">
                                <?= substr($Nada,0,15) ?>
                            </div>
                            <div class="text-xs menu-text alvorecer-3">
                                <?= ucfirst($Nada) ?>
                            </div>
                        </div>

                    </button>


                    <!-- Dropdown Menu -->
                    <div id="user-dropdown-menu" 
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1 border border-gray-200 ">
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900"><?= $Nada ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?= ucfirst($Nada) ?></p>
                            <!-- muda a empresa no dropdown -->
                            <div class="flex items-center">
                                <!-- aqui ficava um select de seleção de empresa, creio que não é mais necessário -->
                            </div>
                        </div>
                        
                        <!-- Master Options -->
                        <?php if ($PermissionRepository->isAdmin()) : ?>
                            <a href="<?= BASE_URL ?>d/manage/admin/index" 
                                class="flex items-center px-4 py-2 gap-2 text-sm text-gray-200 hover:bg-gray-100">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066
                                            c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572
                                            c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573
                                            c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065
                                            c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066
                                            c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572
                                            c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573
                                            c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>

                                <span class="">
                                    Administração
                                </span>
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>logout" 
                                class="flex items-center px-4 py-2 gap-2 text-sm menu-item logout">
                            <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="">
                                Sair
                            </span>
                        </a>

                    </div>
                    
                </div>

            </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 px-4 py-3">
        </div>
    </nav>

    <script>
        const userButton = document.getElementById('user-dropdown-button');
        const userMenu = document.getElementById('user-dropdown-menu');
        
        if (userButton && userMenu) {
            userButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', () => { userMenu.classList.add('hidden'); });
            userMenu.addEventListener('click', (e) => { e.stopPropagation(); });
        }
    </script>
</header>


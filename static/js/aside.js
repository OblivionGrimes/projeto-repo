
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('sidebar-toggle-icon');
    const layoutContainer = document.querySelector('.layout-has-sidebar');
    
    // Elementos que precisam sumir
    const companyDiv = document.getElementById('sidebar-company');
    const titleBi = document.getElementById('sidebar-title-bi');
    const texts = document.querySelectorAll('.sidebar-text');

    const isMinimized = sidebar.style.width === '80px';

    if (!isMinimized) {
        // --- MINIMIZAR ---
        sidebar.style.minWidth = '80px';
        sidebar.style.maxWidth = '80px';
        sidebar.style.width = '80px';

        if(layoutContainer) layoutContainer.style.setProperty('--sidebar-width', '80px');
        
        icon.classList.add('rotate-180');
        
        // Esconder conteúdo interno
        if(companyDiv) companyDiv.style.display = 'none';
        if(titleBi) titleBi.style.display = 'none';
        texts.forEach(el => el.style.display = 'none');

    } else {
        // --- EXPANDIR ---
        sidebar.style.minWidth = '180px';
        sidebar.style.maxWidth = '288px';
        sidebar.style.width = '288px';

        if(layoutContainer) layoutContainer.style.setProperty('--sidebar-width', '288px');
        
        icon.classList.remove('rotate-180');
        
        // Mostrar conteúdo interno novamente
        if(companyDiv) companyDiv.style.display = 'block';
        if(titleBi) titleBi.style.display = 'block';
        texts.forEach(el => el.style.display = 'block');
    }
}

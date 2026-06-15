document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', e => {
        const btn = e.target.closest('.open-drawer');
        if (!btn) return;

        const drawerSelector = btn.dataset.drawer;
        const url            = btn.dataset.url;
        const title          = btn.dataset.title || '';

        const drawerEl = document.querySelector(drawerSelector);
        if (!drawerEl) return;

        const iframe  = drawerEl.querySelector('.drawer-iframe');
        const titleEl = drawerEl.querySelector('.drawer-title');

        if (iframe && url) {
            iframe.src = url;
        }

        if (titleEl) {
            titleEl.textContent = title;
        }

        const drawer =
            KTDrawer.getInstance(drawerEl) || new KTDrawer(drawerEl);

        drawer.show();

        // limpa iframe ao fechar
        drawerEl.addEventListener(
            'kt.drawer.hide',
            () => {
                if (iframe) iframe.src = '';
            },
            { once: true }
        );
    });

});
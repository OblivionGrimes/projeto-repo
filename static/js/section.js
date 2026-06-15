document.addEventListener('DOMContentLoaded', () => {

    const sections = document.querySelectorAll('.admin-section');
    const links    = document.querySelectorAll('.sidebar-link');

    function showSection(id) {
        sections.forEach(s => s.classList.add('hidden'));
        links.forEach(l => l.classList.remove('bg-gray-100', 'font-semibold'));

        document.getElementById(id)?.classList.remove('hidden');

        document
            .querySelector(`.sidebar-link[data-target="${id}"]`)
            ?.classList.add('bg-gray-100', 'font-semibold');

        localStorage.setItem('admin_section', id);

        document.querySelectorAll('.current-section-input')
            .forEach(input => input.value = id);
    }

    links.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            showSection(link.dataset.target);
        });
    });


    const saved = localStorage.getItem('admin_section') || 'section-frames';
    showSection(saved);
});

/* mostra em qual opção do aside o usuário está */
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.sidebar-link');

    const activeClasses = [
        'bg-primary/10',
        'text-primary'
    ];

    links.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();

            links.forEach(l => {
                l.classList.remove(...activeClasses);
                const icon = l.querySelector('i');
                if (icon) icon.classList.remove('text-primary');
            });

            link.classList.add(...activeClasses);
            const icon = link.querySelector('i');
            if (icon) icon.classList.add('text-primary');

            const target = document.getElementById(link.dataset.target);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
/**
 * Club Selector v2 — show/hide pre-mounted Commerce7 join buttons.
 */
const initClubSelectorV2 = () => {
    const wrappers = document.querySelectorAll('.club-selector-v2-wrapper');

    if (!wrappers.length) {
        return;
    }

    wrappers.forEach((wrapper) => {
        const showClub = (slug) => {
            wrapper.querySelectorAll('.club-join-button-wrap').forEach((panel) => {
                const isActive = panel.dataset.clubSlug === slug;
                panel.classList.toggle('is-active', isActive);
                panel.hidden = !isActive;
                panel.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });
        };

        const radios = wrapper.querySelectorAll('.choice-v2');
        radios.forEach((radio) => {
            radio.addEventListener('change', (event) => {
                if (event.target.checked) {
                    showClub(event.target.value);
                }
            });
        });

        const select = wrapper.querySelector('.club-select-v2');
        if (select) {
            select.addEventListener('change', (event) => {
                showClub(event.target.value);
            });
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initClubSelectorV2);
} else {
    initClubSelectorV2();
}

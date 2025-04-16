/**
 * Club Selector Frontend Functionality
 *
 * Handles the dynamic updating of the club selector button based on user selection.
 */

const initClubSelector = () => {
    // Check if there is any club selector element on the page
    const clubSelectors = document.querySelectorAll('.club-selector-wrapper');
    
    if (clubSelectors.length === 0) {
        return;
    }

    // Get the club route from plugin settings
    const clubRoute = window.c7wp_settings?.c7wp_frontend_routes?.club || 'club';

    // Iterate through each club selector element
    clubSelectors.forEach((selector) => {
        // Get the button element
        const button = selector.querySelector('.wp-block-button__link');
        
        // Handle radio button selection
        const radios = selector.querySelectorAll('.choice');
        if (radios.length > 0) {
            radios.forEach((radio) => {
                radio.addEventListener('change', (event) => {
                    const slug = event.target.value;
                    const buttonText = event.target.dataset.buttonText;
                    
                    if (button) {
                        button.href = `/${clubRoute}/${slug}/`;
                        button.textContent = buttonText;
                    }
                });
            });
        }

        // Handle select dropdown selection
        const select = selector.querySelector('.club-select');
        if (select) {
            select.addEventListener('change', (event) => {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const slug = selectedOption.value;
                const buttonText = selectedOption.dataset.buttonText;
                
                if (button) {
                    button.href = `/${clubRoute}/${slug}/`;
                    button.textContent = buttonText;
                }
            });
        }
    });
};

// Initialize when DOM is loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initClubSelector);
} else {
    initClubSelector();
} 
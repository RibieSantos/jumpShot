import Alpine from 'alpinejs';
import { darkModeHandler } from './darkmode';
import { setupMobileMenu } from './mobilemenu';
import Swal from 'sweetalert2';

window.Swal = Swal;
window.Alpine = Alpine;
window.darkModeHandler = darkModeHandler;

Alpine.start();

// Initialize mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    setupMobileMenu();
});

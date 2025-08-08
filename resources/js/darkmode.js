export function darkModeHandler() {
    return {
        isDark: false,
        init() {
            // Load from localStorage immediately
            this.isDark = JSON.parse(localStorage.getItem('darkMode')) || false;

            // Apply dark class immediately to prevent flicker
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        toggleDarkMode() {
            this.isDark = !this.isDark;
            localStorage.setItem('darkMode', this.isDark);
        }
    }
}

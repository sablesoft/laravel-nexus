/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';

function setPrismTheme() {
    const themeLink = document.getElementById('prism-theme');
    if (!themeLink) return;

    const isDark = document.documentElement.classList.contains('dark');

    themeLink.href = isDark
        ? 'https://cdn.jsdelivr.net/npm/prismjs/themes/prism-tomorrow.min.css'
        : 'https://cdn.jsdelivr.net/npm/prismjs/themes/prism.min.css';
}

document.addEventListener('DOMContentLoaded', setPrismTheme);
document.addEventListener('livewire:navigated', setPrismTheme);

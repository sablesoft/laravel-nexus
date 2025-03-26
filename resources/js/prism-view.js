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

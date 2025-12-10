import { ref, watch, onMounted } from 'vue';

const isDark = ref(false);

export function useDarkMode() {
    onMounted(() => {
        // Check localStorage or system preference
        const stored = localStorage.getItem('darkMode');
        if (stored !== null) {
            isDark.value = stored === 'true';
        } else {
            isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        applyDarkMode();
    });

    function applyDarkMode() {
        if (isDark.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    function toggleDarkMode() {
        isDark.value = !isDark.value;
        localStorage.setItem('darkMode', String(isDark.value));
        applyDarkMode();
    }

    watch(isDark, applyDarkMode);

    return {
        isDark,
        toggleDarkMode,
    };
}
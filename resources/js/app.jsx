import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

import '@fontsource/inter/300.css';
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/700.css';

import { ThemeProvider, CssBaseline } from '@mui/material';
import theme from './theme';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Tangani otomatis jika sesi kedaluwarsa karena tidak ada aktivitas (inaktivitas lama)
router.on('invalid', (event) => {
    if (event.detail.response && event.detail.response.status === 419) {
        event.preventDefault();
        alert('Sesi Anda telah berakhir demi keamanan karena tidak ada aktivitas. Halaman akan dimuat ulang secara otomatis.');
        window.location.reload();
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <ThemeProvider theme={theme}>
                <CssBaseline />
                <App {...props} />
            </ThemeProvider>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

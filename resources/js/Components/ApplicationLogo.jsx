import ElaptriLogo from '@/Components/ElaptriLogo';

export default function ApplicationLogo({ className = 'h-9 w-auto', variant = 'mark', theme = 'light', ...props }) {
    return (
        <ElaptriLogo
            variant={variant}
            theme={theme}
            className={className}
            {...props}
        />
    );
}

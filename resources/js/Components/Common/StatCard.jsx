import { Card, CardContent, Typography, Box, Stack } from '@mui/material';
import { motion } from 'framer-motion';

const defaultItemVariants = {
    hidden: { opacity: 0, y: 15 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.4 } }
};

export default function StatCard({
    title,
    value,
    valueSuffix,
    subtitle,
    icon: IconComponent,
    iconBg = '#eff6ff',
    iconColor = '#2563eb',
    valueColor = '#0f172a',
    children,
    variants = defaultItemVariants
}) {
    return (
        <Card
            component={motion.div}
            variants={variants}
            sx={{
                borderRadius: 3,
                border: '1px solid #e2e8f0',
                boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                transition: 'transform 0.2s, box-shadow 0.2s',
                '&:hover': {
                    transform: 'translateY(-3px)',
                    boxShadow: '0 10px 25px -5px rgba(15, 23, 42, 0.1)'
                }
            }}
        >
            <CardContent sx={{ p: 2.5 }}>
                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                    <Typography
                        variant="caption"
                        sx={{
                            color: '#64748b',
                            fontWeight: 700,
                            textTransform: 'uppercase',
                            letterSpacing: 0.5
                        }}
                    >
                        {title}
                    </Typography>
                    {IconComponent && (
                        <Box
                            sx={{
                                width: 36,
                                height: 36,
                                borderRadius: 2,
                                bgcolor: iconBg,
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                color: iconColor
                            }}
                        >
                            {typeof IconComponent === 'function' ? <IconComponent fontSize="small" /> : IconComponent}
                        </Box>
                    )}
                </Stack>

                <Typography variant="h3" fontWeight={800} sx={{ color: valueColor, lineHeight: 1.1 }}>
                    {value}
                    {valueSuffix && (
                        <Typography component="span" variant="h6" sx={{ color: '#94a3b8', fontWeight: 600, ml: 0.5 }}>
                            {valueSuffix}
                        </Typography>
                    )}
                </Typography>

                {children}

                {subtitle && (
                    <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                        {subtitle}
                    </Typography>
                )}
            </CardContent>
        </Card>
    );
}

import { Grid, Box, LinearProgress, Typography } from '@mui/material';
import {
    Storage as StorageIcon,
    DataUsage as DataUsageIcon,
    AssignmentTurnedIn as AssignmentTurnedInIcon,
    Speed as SpeedIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';
import StatCard from '@/Components/Common/StatCard';

const containerVariants = {
    hidden: { opacity: 0 },
    visible: {
        opacity: 1,
        transition: { staggerChildren: 0.08 }
    }
};

const itemVariants = {
    hidden: { opacity: 0, y: 15 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.4 } }
};

export default function DashboardStats({
    totalSp = 0,
    actualStats = {},
    progress = 0,
    rataCapaian = 0
}) {
    return (
        <Grid 
            container 
            spacing={2.5} 
            component={motion.div} 
            variants={containerVariants} 
            initial="hidden" 
            animate="visible" 
            sx={{ mb: 4 }}
        >
            {/* SP Card */}
            <Grid item xs={12} sm={6} md={3}>
                <StatCard
                    title="Sasaran Program"
                    value={totalSp}
                    subtitle="Total Sasaran Terkait Renstra"
                    icon={<StorageIcon fontSize="small" />}
                    iconBg="#eff6ff"
                    iconColor="#2563eb"
                    variants={itemVariants}
                />
            </Grid>

            {/* IKK Total Card */}
            <Grid item xs={12} sm={6} md={3}>
                <StatCard
                    title="Total Indikator (IKK)"
                    value={actualStats.total || 0}
                    subtitle="Indikator Unit Pengampu"
                    icon={<DataUsageIcon fontSize="small" />}
                    iconBg="#f0fdfa"
                    iconColor="#0d9488"
                    variants={itemVariants}
                />
            </Grid>

            {/* Progress Terisi Card */}
            <Grid item xs={12} sm={6} md={3}>
                <StatCard
                    title="IKK Terisi"
                    value={actualStats.terisi || 0}
                    valueSuffix={`/ ${actualStats.total || 0}`}
                    valueColor="#059669"
                    icon={<AssignmentTurnedInIcon fontSize="small" />}
                    iconBg="#f0fdf4"
                    iconColor="#16a34a"
                    variants={itemVariants}
                >
                    <Box sx={{ mt: 1.5 }}>
                        <LinearProgress 
                            variant="determinate" 
                            value={progress} 
                            sx={{ 
                                height: 6, 
                                borderRadius: 3, 
                                bgcolor: '#e2e8f0', 
                                '& .MuiLinearProgress-bar': { bgcolor: '#059669', borderRadius: 3 } 
                            }} 
                        />
                    </Box>
                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600, mt: 0.5, display: 'block' }}>
                        {progress.toFixed(0)}% telah terisi
                    </Typography>
                </StatCard>
            </Grid>

            {/* Rata-rata Capaian */}
            <Grid item xs={12} sm={6} md={3}>
                <StatCard
                    title="Rata-Rata Capaian"
                    value={`${rataCapaian}%`}
                    valueColor={Number(rataCapaian) >= 100 ? '#059669' : '#d97706'}
                    subtitle="Rata-rata capaian terhadap target"
                    icon={<SpeedIcon fontSize="small" />}
                    iconBg="#fffbeb"
                    iconColor="#d97706"
                    variants={itemVariants}
                />
            </Grid>
        </Grid>
    );
}

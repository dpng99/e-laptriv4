import { Paper, Tabs, Tab } from '@mui/material';
import {
    AssignmentOutlined as AssignmentIcon,
    CalculateOutlined as CalculateIcon
} from '@mui/icons-material';

export default function LevelTabs({
    activeTab,
    onTabChange,
    ikkCount = 0,
    ikpCount = 0
}) {
    return (
        <Paper sx={{ mb: 3, borderRadius: 2.5, border: '1px solid #e2e8f0', boxShadow: 'none' }}>
            <Tabs 
                value={activeTab} 
                onChange={(e, val) => onTabChange(val)}
                sx={{
                    px: 2,
                    '& .MuiTab-root': { fontWeight: 700, textTransform: 'none', fontSize: '0.95rem', py: 2 }
                }}
            >
                <Tab 
                    value="IKK" 
                    label={`Indikator Kinerja Kegiatan (${ikkCount} IKK)`} 
                    icon={<AssignmentIcon />} 
                    iconPosition="start" 
                />
                <Tab 
                    value="IKP" 
                    label={`Indikator Sasaran Program (${ikpCount} IKP)`} 
                    icon={<CalculateIcon />} 
                    iconPosition="start" 
                />
            </Tabs>
        </Paper>
    );
}

<script setup>
import { ref, onMounted, watch, defineProps } from 'vue';
import axios from 'axios';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';

// Define props for the component
const props = defineProps({
    logtype: {
        type: String,
        required: true,
    },
});

const columns = [
    { name: 'id', label: 'Nama Kategori' },
    { name: 'message', label: 'Keterangan' },
    { name: 'user_id', label: 'User' },
    { name: 'ip_address', label: 'IP' },
    { name: 'context', label: 'Data' },
    { name: 'created_at', label: 'Tanggal' },
];

const logs = ref([]);
const loading = ref(true);

const fetchLogs = async (logType) => {
    try {
        loading.value = true; // Show loading while fetching
        const response = await axios.get(route('logs.log'), {
            params: {
                log_type: logType, // Pass the logtype prop as a parameter
            },
        });
        logs.value = response.data; // Set the fetched data
    } catch (error) {
        console.error('Error fetching logs:', error);
    } finally {
        loading.value = false; // Hide loading after fetching
    }
};

// Fetch logs when the component is mounted or the logtype changes
onMounted(() => fetchLogs(props.logtype));
watch(() => props.logtype, (newLogType) => fetchLogs(newLogType));
</script>

<template>
    <div class="mt-20"></div>
    <h1 class="text-xl font-bold mb-4">Riwayat Perubahan</h1>
    <div v-if="loading" class="text-center py-4">Loading...</div>
    <DataTable v-else :data="logs" :columns="columns" />
</template>

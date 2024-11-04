<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';
import SuccessButton from '@/Components/SuccessButton.vue';

const props = defineProps({
    formType: String,
    rfqStatus: Object,
    rfqs: Array,
});

// Accessing page properties using usePage
const page = usePage();
const userDivision = page.props.auth.user.division; // Access user division from page props

const title = 'Pengajuan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];

const columns = [
    { name: 'rfq_number', label: 'Nomor Pengajuan' },
    { name: 'request_date', label: 'Tanggal Pengajuan' },
    { name: 'allocation_date', label: 'Tanggal Digunakan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'title', label: 'Perihal' },
    { name: 'verified', label: 'Status Verifikasi' },
    userDivision === 'Keuangan' ? { name: 'payment_status', label: 'Status Pembayaran' } : null,
    { name: 'status', label: 'Status' },
].filter(Boolean);

const data = props.rfqs.map(item => ({
    ...item,
    user_name: item.user.name,
    comment: (item.comment?.length || 0) > 30 ? item.comment.substring(0, 30) + '...' : item.comment,
    verified: `Pimpinan Gudang: ${item.verified_1 === 1 ? '✔️' : item.verified_1 === 0 ? '❌' : '-'}<br/>` +
        `Admin Gudang: ${item.verified_2 === 1 ? '✔️' : item.verified_2 === 0 ? '❌' : '-'}<br/>` +
        `Purchasing: ${item.verified_3 === 1 ? '✔️' : item.verified_3 === 0 ? '❌' : '-'}<br/>` +
        `Pimpinan STP: ${item.verified_4 === 1 ? '✔️' : item.verified_4 === 0 ? '❌' : '-'}`,
    payment_status: item.payment_status ? 'Lunas' : 'Belum Lunas',
}));
</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
            v-if="['Divisi Lain'].includes($page.props.auth.user.division)">
            <SuccessButton :href="route('rfqs.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button
                        v-if="['Divisi Lain'].includes($page.props.auth.user.division) && [rfqStatus['PENDING']].includes(item.status)"
                        color="yellow" class="p-0 py-1" :href="route('rfqs.edit', { id: item.id })">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1" :href="route('rfqs.show', { id: item.id })">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>

    </AppLayout>
</template>

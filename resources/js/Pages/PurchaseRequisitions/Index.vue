<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';
import SuccessButton from '@/Components/SuccessButton.vue';

const props = defineProps({
    formType: String,
    prs: Array,
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
    { name: 'name', label: 'Nomor Pengajuan' },
    { name: 'date_created', label: 'Tanggal Pengajuan' },
    { name: 'date_deadline', label: 'Tanggal Digunakan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'subject', label: 'Perihal' },
    { name: 'verified', label: 'Status Verifikasi' },
    { name: 'state', label: 'Status' },
].filter(Boolean);

const data = props.prs.map(item => ({
    ...item,
    user_name: item.user.name,
    comment: (item.comment?.length || 0) > 30 ? item.comment.substring(0, 30) + '...' : item.comment,
    verified: `kepala-divisi-logistik: ${item.verified_1 === 1 ? '✔️' : item.verified_1 === 0 ? '❌' : '-'}<br/>` +
        `admin-gudang: ${item.verified_2 === 1 ? '✔️' : item.verified_2 === 0 ? '❌' : '-'}<br/>` +
        `purchasing: ${item.verified_3 === 1 ? '✔️' : item.verified_3 === 0 ? '❌' : '-'}<br/>` +
        `pimpinan: ${item.verified_4 === 1 ? '✔️' : item.verified_4 === 0 ? '❌' : '-'}`,
}));
</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <SuccessButton :href="route('purchase-requisitions.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button
                        v-if="['pengaju'].includes($page.props.auth.user.division) && ['pending'].includes(item.state)"
                        color="yellow" class="p-0 py-1" :href="route('purchase-requisitions.edit', { id: item.id })">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1" :href="route('purchase-requisitions.show', { id: item.id })">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>{{ route('purchase-requisitions.edit', { id: item.id }) }}
            </template>
        </DataTable>

    </AppLayout>
</template>

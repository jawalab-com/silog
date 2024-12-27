<script setup>
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    transactions: Array,
});

const form = useForm({});

const title = 'Riwayat Transaksi';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'reference_id', label: 'Nomor Referensi' },
    { name: 'note', label: 'Catatan' },
    { name: 'quantity_change', label: 'Jumlah', align: 'right' },
    { name: 'user_name', label: 'Oleh' },
    { name: 'created_at', label: 'Waktu' },
];
const data = props.transactions.map(item => ({
    ...item,
    reference_id: `<a class="text-blue-700 dark:text-blue-300" href="${route('rfqs.torfq', { po_number: encodeURIComponent(item.reference_id) })}">` + item.reference_id + `</a>`,
    quantity_change: `<span class="text-${item.quantity_change >= 0 ? 'green' : 'red'}-500">` + (item.quantity_change > 0 ? `+${item.quantity_change}` : item.quantity_change) + `<span>`,
    user_name: item.user.name,
    created_at: utils.formatDateTime(item.created_at),

}));

const deleteAction = async (id) => {
    const result = await utils.confirm({
        title: "Hapus Data",
        text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!",
    });

    if (result.isConfirmed) {
        form.delete(route("transactions.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <DataTable :data="data" :columns="columns"></DataTable>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Tooltip from '@/Components/Tooltip.vue';
import Swal from 'sweetalert2';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Pagination from '@/Components/Pagination.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import ActionButton from '@/Components/ActionButton.vue';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    formType: String,
    purchaseOrders: Array,
});

const title = props.formType == 'submission' ? 'Pengajuan' : 'purchasing';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];

const orderStatus = [
    { value: 'SUBMISSION_PENDING', label: 'Pengajuan Diajukan' },
    { value: 'SUBMISSION_APPROVED', label: 'Pengajuan Disetujui' },
    { value: 'SUBMISSION_REJECTED', label: 'Pengajuan Ditolak' },
    { value: 'COMPLETED', label: 'Selesai' },
    { value: 'CANCELLED', label: 'Dibatalkan' },
    { value: 'REFUNDED', label: 'Dikembalikan' },
];

const columns = [
    { name: 'rfq_number', label: 'Nomor Pengajuan' },
    // { name: 'po_number', label: 'Nomor PO' },
    // { name: 'supplier_name', label: 'Supplier' },
    { name: 'request_date', label: 'Tanggal Pengajuan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'total_amount', label: 'Total', align: 'right' },
    { name: 'verifikasi', label: 'Verifikasi' },
    { name: 'payment_status', label: 'Status Pembayaran' },
    { name: 'status', label: 'Status' },
];

const data = props.purchaseOrders.map(item => ({
    ...item,
    supplier_name: item.supplier?.supplier_name || '',
    user_name: item.user.name,
    // status: orderStatus.find(status => status.value === item.status)?.label || item.status,
    verifikasi: "kepala-divisi-logistik: ✔️<br/>admin-gudang: ✔️<br/>Purchasing: ❌<br/>Pimpinan STP: ✔️",
    payment_status: "Belum Lunas",
    status: "Pending",
}));


// Delete purchaseOrder with confirmation
const deleteAction = async (id) => {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    });

    if (result.isConfirmed) {
        uniqueKey.value++;
        form.delete(route("purchaseOrders.destroy", id), {
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

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <SuccessButton v-if="props.formType == 'submission'"
                :href="route('purchase-orders.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1"
                        :href="route('purchase-orders.edit', { id: item.id }) + `?formType=${props.formType}`">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1"
                        :href="route('purchase-orders.show', { id: item.id }) + `?formType=${props.formType}`">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>

    </AppLayout>
</template>

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
    salesOrders: Array,
});

const title = props.formType == 'submission' ? 'Pengajuan' : 'Purchase Order';
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

const columns = props.formType == 'submission' ? [
    { name: 'order_date', label: 'Tanggal Pengajuan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'status', label: 'Status' },
    { name: 'comment', label: 'Komentar' },
] : [
    { name: 'supplier_name', label: 'Supplier' },
    { name: 'order_date', label: 'Tanggal Pengajuan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'status', label: 'Status' },
    { name: 'total_amount', label: 'Total Amount' },
];

const data = props.salesOrders.map(item => ({
    ...item,
    supplier_name: item.supplier?.supplier_name || '',
    user_name: item.user.name,
    status: orderStatus.find(status => status.value === item.status)?.label || item.status,
}));


// Delete salesOrder with confirmation
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
        form.delete(route("salesOrders.destroy", id), {
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
                :href="route('sales-orders.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1"
                        :href="route('sales-orders.edit', { id: item.id }) + `?formType=submission`">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1"
                        :href="route('sales-orders.show', { id: item.id }) + `?formType=submission`">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>

    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    items: Array,
});

const dummyData = [
    {
        id: 1,
        tag: 'Electronics',
        supplier_name: 'Supplier A',
        discount: 10,
        tax: 5,
        status: 'Pending',
        user: 'User A',
    },
    {
        id: 2,
        tag: 'Furniture',
        supplier_name: 'Supplier B',
        discount: 15,
        tax: 8,
        status: 'Approved',
        user: 'User B',
    },
    {
        id: 3,
        tag: 'Clothing',
        supplier_name: 'Supplier C',
        discount: 20,
        tax: 12,
        status: 'Rejected',
        user: 'User C',
    }
];

const title = 'Pengajuan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'tag', label: 'Kategori' },
    { name: 'supplier_name', label: 'Supplier' },
    { name: 'discount', label: 'Diskon' },
    { name: 'tax', label: 'Pajak %' },
    { name: 'status', label: 'Status' },
];

const data = dummyData.map(item => ({
    ...item,
}));
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <!-- <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <SuccessButton :href="route('rfqs.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div> -->

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1" :href="route('rfqs.edit', { id: item.id })">
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

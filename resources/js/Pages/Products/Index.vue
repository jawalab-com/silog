<script setup>
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    products: Array,
});

const form = useForm({});

const title = 'Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'product_name', label: 'Nama Barang' },
    { name: 'brand_name', label: 'Merk' },
    { name: 'tag_name', label: 'Tag' },
    { name: 'product_description', label: 'Deskripsi Barang' },
    { name: 'minimum_quantity', label: 'Stok Minimum', align: 'right' },
    { name: 'quantity', label: 'Jumlah Stok', align: 'right' },
    { name: 'verified', label: 'Terverifikasi', align: 'center' },
    // { name: 'price', label: 'Harga', align: 'right' },
    // { name: 'updated_at', label: 'Tanggal Update', align: 'right' },
];
const data = props.products.map(item => ({
    ...item,
    tag_name: item.tag?.tag_name,
    brand_name: item.brand.brand_name,
    quantity: item.inventory?.quantity || 0,
    verified: item.verified ? '✔️' : '❌',
    price: utils.formatCurrency(item.price),
    updated_at: utils.formatDateTime(item.updated_at),
}));

const deleteAction = async (id) => {
    const result = await utils.confirm({
        title: "Hapus Data",
        text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!",
    });

    if (result.isConfirmed) {
        form.delete(route("products.destroy", id), {
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

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
            <Button color="green" :href="route('products.create')">
                <template #prefix>
                    <Icon name="plus" />
                </template>
                Tambah
            </Button>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1" :href="route('products.edit', item.id)">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1" :href="route('products.show', item.id)">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                    <!-- <Button color="red" class="p-0 py-1" @click="deleteAction(item.id)">
                        <Icon name="close" class="w-4.5 h-4.5" />
                    </Button> -->
                </fwb-button-group>
            </template>
        </DataTable>
    </AppLayout>
</template>

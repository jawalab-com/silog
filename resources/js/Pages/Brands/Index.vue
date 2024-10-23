<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    brands: Array,
});

const form = useForm({});

const title = 'Merk';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'brand_name', label: 'Brand Name' },
    { name: 'brand_description', label: 'Brand Description' },
    { name: 'updated_at', label: 'Tanggal Diperbarui', align: 'right' },
];
const data = computed(() => {
    return props.brands.map(item => ({
        ...item,
        updated_at: new Date(item.updated_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }),
    }));
});

const deleteAction = async (id) => {
    const result = await utils.confirm({
        title: "Hapus Data",
        text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!",
    });

    if (result.isConfirmed) {
        form.delete(route("brands.destroy", id), {
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
            <Button color="green" :href="route('brands.create')">
                <template #prefix>
                    <Icon name="plus" />
                </template>
                Tambah
            </Button>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1" :href="route('brands.edit', item.id)">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="red" class="p-0 py-1" @click="deleteAction(item.id)">
                        <Icon name="close" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>
    </AppLayout>
</template>

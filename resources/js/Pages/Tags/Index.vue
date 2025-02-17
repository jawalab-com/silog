<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import Log from '@/Components/Log.vue';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    tags: Array,
});

const form = useForm({});

const title = 'Kategori Produk';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'tag_name', label: 'Nama Kategori' },
    { name: 'tag_description', label: 'Deskripsi' },
    { name: 'updated_at', label: 'Tanggal Diperbarui', align: 'right' },
];
const data = computed(() => {
    return props.tags.map(item => ({
        ...item,
        updated_at: new Date(item.updated_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }),
    }));
});

const deleteAction = async (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!")) {
        form.delete(route("tags.destroy", id), {
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
            <Button color="green" :href="route('tags.create')">
                <template #prefix>
                    <Icon name="plus" />
                </template>
                Tambah
            </Button>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1" :href="route('tags.edit', item.id)">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <!-- <Button color="red" class="p-0 py-1" @click="deleteAction(item.id)">
                        <Icon name="close" class="w-4.5 h-4.5" />
                    </Button> -->
                </fwb-button-group>
            </template>
        </DataTable>

        <Log logtype="tag" />
    </AppLayout>
</template>

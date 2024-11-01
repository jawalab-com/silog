<script setup>
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    suppliers: Array,
});

const form = useForm({});

const title = 'Supplier';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'tag_name', label: 'Kategori' },
    { name: 'supplier_name', label: 'Nama Supplier' },
    { name: 'contact_name', label: 'Nama Kontak' },
    { name: 'address', label: 'Alamat' },
    { name: 'phone', label: 'Telepon' },
    { name: 'email', label: 'Email' },
];
const data = props.suppliers.map(item => ({
    ...item,
    tag_name: item.tag?.tag_name || '-',
}));

// Delete supplier with confirmation
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
        // uniqueKey.value++;
        form.delete(route("suppliers.destroy", id), {
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
            <Button color="green" :href="route('suppliers.create')">
                <template #prefix>
                    <Icon name="plus" />
                </template>
                Tambah
            </Button>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button color="yellow" class="p-0 py-1" :href="route('suppliers.edit', item.id)">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <!-- <Button color="green" class="p-0 py-1" :href="route('suppliers.show', item.id)">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button> -->
                    <Button color="red" class="p-0 py-1" @click="deleteAction(item.id)">
                        <Icon name="close" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>
    </AppLayout>
</template>

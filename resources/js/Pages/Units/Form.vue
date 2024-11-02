<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, TextInput } from '@/Components';
import { FwbButton } from 'flowbite-vue';

const props = defineProps({
    unit: Object,
});

const form = useForm({
    unit_name: props.unit?.unit_name,
    unit_description: props.unit?.unit_description,
});

const title = (!!props.unit.id ? 'Edit' : 'Tambah') + ' Satuan Produk';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Tag', href: route('units.index') },
    { name: !!props.unit ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    if (!!props.unit.id) {
        form.put(route("units.update", props.unit.id));
    } else {
        form.post(route("units.store"));
    }
};
</script>

<template>
    <AppLayout :title="title">
        <form @submit.prevent="saveAction">
            <Card class="">
                <template #header class="flex">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ title }}
                    </h2>
                </template>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="unit_name" value="Nama Tag" />
                        <TextInput id="unit_name" v-model="form.unit_name" />
                        <InputError :message="form.errors.unit_name" />
                    </div>

                    <div>
                        <InputLabel for="unit_description" value="Deskripsi Tag" />
                        <TextInput id="unit_description" v-model="form.unit_description" />
                        <InputError :message="form.errors.unit_description" />
                    </div>
                </div>
                <template #footer>
                    <div class="flex justify-end">
                        <Button color="gray" class="mr-2" @click="back">
                            Batal
                        </Button>
                        <Button color="blue" type="submit">
                            Simpan
                        </Button>
                    </div>
                </template>
            </Card>
        </form>
    </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, TextInput } from '@/Components';
import { FwbButton } from 'flowbite-vue';

const props = defineProps({
    brand: Object,
});

const form = useForm({
    brand_name: props.brand?.brand_name,
    brand_description: props.brand?.brand_description,
});

const title = (!!props.brand ? 'Edit' : 'Tambah') + ' Merk';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Merk', href: route('brands.index') },
    { name: !!props.brand ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    if (!!props.brand) {
        form.put(route("brands.update", props.brand.id));
    } else {
        form.post(route("brands.store"));
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
                        <InputLabel for="brand_name" value="Nama Merk" />
                        <TextInput id="brand_name" v-model="form.brand_name" />
                        <InputError :message="form.errors.brand_name" />
                    </div>

                    <div>
                        <InputLabel for="brand_description" value="Deskripsi Merk" />
                        <TextInput id="brand_description" v-model="form.brand_description" />
                        <InputError :message="form.errors.brand_description" />
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

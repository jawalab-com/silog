<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    supplier: Object,
});

// Initialize the form with useForm, setting initial values
const form = useForm({
    supplier_name: props.supplier?.supplier_name || '',
    contact_name: props.supplier?.contact_name || '',
    address: props.supplier?.address || '',
    phone: props.supplier?.phone || '',
    email: props.supplier?.email || '',
});

const title = (!!props.supplier ? 'Edit' : 'Tambah') + ' Supplier';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Supplier', href: route('suppliers.index') },
    { name: !!props.supplier ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    if (!!props.supplier) {
        form.put(route("suppliers.update", props.supplier.id));
    } else {
        form.post(route("suppliers.store"));
    }
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
            </h2>
        </template>

        <Card class="p-4">
            <form @submit.prevent="saveAction">

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="supplier_name" value="Name" />
                        <TextInput id="supplier_name" v-model="form.supplier_name" />
                        <InputError :message="form.errors.supplier_name" />
                    </div>
                    <div>
                        <InputLabel for="contact_name" value="Contact Name" />
                        <TextInput id="contact_name" v-model="form.contact_name" />
                        <InputError :message="form.errors.contact_name" />
                    </div>
                    <div>
                        <InputLabel for="address" value="Address" />
                        <TextInput id="address" v-model="form.address" />
                        <InputError :message="form.errors.address" />
                    </div>
                    <div>
                        <InputLabel for="phone" value="Phone" />
                        <TextInput id="phone" v-model="form.phone" />
                        <InputError :message="form.errors.phone" />
                    </div>
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" v-model="form.email" type="email" />
                        <InputError :message="form.errors.email" />
                    </div>
                </div>
                <div class="flex justify-end mt-2">
                    <PrimaryButton type="submit">
                        Simpan
                    </PrimaryButton>
                </div>
            </form>

        </Card>
    </AppLayout>
</template>

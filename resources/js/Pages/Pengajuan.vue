<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import { Breadcrumb, Button, DataTable, Icon, InputError, InputLabel, TextInput } from '@/Components';
import { FwbButton } from 'flowbite-vue';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    // po: {
    //     id: 69,
    //     perihal: 'Pengajuan pengadaan Mie Instan',
    //     tangal_digunakan: '2024-11-03',
    // },
    products: {
        type: Array,
        default: () => [
            {
                product_name: "Indomie Soto Ayam",
                brand_name: "Indomie",
                specification: "Mie instan rasa ayam bawang, berat 85 gram",
                quantity: "12",
                unit: "Bungkus"
            },
            {
                product_name: "Sarimi Sate",
                brand_name: "Sarimi",
                specification: "Mie instan rasa soto ayam, berat 75 gram",
                quantity: "10",
                unit: "Bungkus"
            },
            {
                product_name: "Supermi Tom Yum",
                brand_name: "SUpermi",
                specification: "Mie instan rasa kaldu ayam, berat 70 gram",
                quantity: "15",
                unit: "Bungkus"
            },
            {
                product_name: "Mie Sedaap Goreng Spesial",
                brand_name: "Mie Sedap",
                specification: "Mie instan rasa ayam bawang, berat 90 gram",
                quantity: "20",
                unit: "Bungkus"
            },
            {
                product_name: "Pop Mie Bakso",
                brand_name: "Pop Mie",
                specification: "Mie instan cup rasa ayam bawang, berat 75 gram",
                quantity: "8",
                unit: "Cup"
            }
        ]
    },
});

const form = useForm({
    product_name: props.products?.products_name,
    brand_name: props.products?.brand_name,
    specification: props.products?.specification,
    quantity: props.products?.quantity,
    unit: props.products?.unit,
});

const title = (!!props.po ? 'Edit' : 'Tambah') + ' Pengajuan Barang';
// const breadcrumbs = [
//     { name: 'Home', href: route('dashboard') },
//     { name: 'Merk', href: route('products.index') },
//     { name: !!props.po ? 'Edit' : 'Tambah', href: '#' },
// ];
const columns = [
    { name: 'product_name', label: 'Nama Barang' },
    { name: 'brand_name', label: 'Merk' },
    { name: 'specification', label: 'Spesifikasi' },
    { name: 'quantity', label: 'Jumlah', align: 'right' },
    { name: 'unit', label: 'Satuan' },
];
const data = computed(() => {
    return props.products.map(item => ({
        ...item,
    }));
});

const back = () => window.history.back();

const saveAction = () => {
    // if (!!props.brand) {
    //     form.put(route("brands.update", 69));
    // } else {
    //     form.post(route("brands.store"));
    // }
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
                        <InputLabel for="product_name" value="Perihal" />
                        <TextInput id="product_name" v-model="form.product_name" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="product_name" value="Tanggal Digunakan" />
                        <TextInput id="product_name" v-model="form.product_name" type="date" />
                        <InputError :message="form.errors.product_name" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 my-6">
                    <div>
                        <InputLabel for="product_name" value="Perihal" />
                        <TextInput id="product_name" v-model="form.product_name" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="product_name" value="Tanggal Digunakan" />
                        <TextInput id="product_name" v-model="form.product_name" type="date" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="product_name" value="Jumlah" />
                        <TextInput id="product_name" v-model="form.product_name" type="date" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="product_name" value="Satuan" />
                        <TextInput id="product_name" v-model="form.product_name" type="date" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="product_name" value="&nbsp;" />
                        <Button color="green">
                            Tambah Barang
                        </Button>
                    </div>
                </div>

                <DataTable :data="data" :columns="columns">
                    <template v-slot:actionColumn="{ item, columns, index }">
                        <fwb-button-group>
                            <!-- <Button color="yellow" class="p-0 py-1">
                                <Icon name="pencil" class="w-4.5 h-4.5" />
                            </Button> -->
                            <Button color="red" class="p-0 py-1" @click="deleteAction(item.id)">
                                <Icon name="close" class="w-4.5 h-4.5" />
                            </Button>
                        </fwb-button-group>
                    </template>
                </DataTable>

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

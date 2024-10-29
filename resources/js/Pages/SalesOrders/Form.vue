<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';

const props = defineProps({
    formType: String,
    salesOrder: Object,
    suppliers: Object,
});

const form = useForm({
    _method: props.salesOrder.id ? 'put' : 'post',
    form_type: props.formType,
    supplier_id: props.salesOrder?.supplier_id || '',
    user_id: props.salesOrder?.user_id || '',
    number: props.salesOrder?.number,
    order_date: props.salesOrder?.order_date || new Date().toISOString().split('T')[0],
    status: props.salesOrder?.status || '',
    total_amount: props.salesOrder?.total_amount || '',
    details: props.salesOrder?.details || [],
});

const satuanOptions = [
    { value: 'unit', label: 'Unit' },
    { value: 'lusin', label: 'Lusin' },
    { value: 'kodi', label: 'Kodi' },
    { value: 'rim', label: 'Rim' },
    { value: 'kg', label: 'Kg' },
    { value: 'gram', label: 'Gram' },
    { value: 'liter', label: 'Liter' },
    { value: 'ml', label: 'Mililiter' },
    { value: 'm', label: 'Meter' },
    { value: 'cm', label: 'Centimeter' },
    { value: 'inch', label: 'Inci' },
    { value: 'm3', label: 'Meter Kubik' },
    { value: 'pack', label: 'Pack' },
    { value: 'bottle', label: 'Botol' },
    { value: 'can', label: 'Kaleng' },
    { value: 'gallon', label: 'Galon' },
    { value: 'sack', label: 'Karung' },
    { value: 'carton', label: 'Dus/Karton' },
    { value: 'set', label: 'Set' },
    { value: 'gross', label: 'Gross' },
];

const newProduct = ref({
    product_id: '',
    product_label: '',
    quantity: 1,
    unit: 'unit',
});

const productDetails = ref(null);

const addRow = () => {
    form.details.push({
        product_id: newProduct.value.product_id,
        product_label: newProduct.value.product_label,
        quantity: newProduct.value.quantity,
        unit: newProduct.value.unit
    });
};

const removeRow = (index) => {
    form.details.splice(index, 1);
};

const title = (!!props.salesOrder ? 'Edit' : 'Tambah') + (props.formType == 'submission' ? ' Pengajuan' : ' Sales Order');
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Sales Order', href: route('purchase-orders.index') },
    { name: !!props.salesOrder ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    if (!!props.salesOrder.id) {
        form.put(route("purchase-orders.update", props.salesOrder.id));
    } else {
        form.post(route("purchase-orders.store"));
    }
};

const goBack = () => {
    window.history.back();
};

watch(() => newProduct.value.product_id, async (newVal) => {
    if (newVal) {
        try {
            const response = await axios.get(route('products.get', { id: newVal }));
            productDetails.value = response.data;
        } catch (error) {
            console.error('Error fetching product:', error);
            productDetails.value = null;
        }
    } else {
        productDetails.value = null;
    }
});

</script>

<template>
    <AppLayout :title="title">
        <Card>
            <template #header class="flex">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ title }}
                </h2>
            </template>

            <form @submit.prevent="saveAction">
                <div class="grid grid-cols-2 gap-2">
                    <div v-if="formType == 'purchase-order'">
                        <InputLabel for="supplier_id" value="Supplier" />
                        <Select id="supplier_id" v-model="form.supplier_id">
                            <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">
                                {{ supplier.supplier_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.supplier_id" />
                    </div>

                    <div>
                        <InputLabel for="number" value="Nomor" />
                        <TextInput id="number" v-model="form.number" disabled />
                        <InputError :message="form.errors.number" />
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Pengajuan" />
                        <TextInput type="date" id="order_date" v-model="form.order_date" />
                        <InputError :message="form.errors.order_date" />
                    </div>
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                    Daftar Barang
                </h2>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <InputLabel for="product_id" value="Barang" />
                        <AutoComplete v-model="newProduct.product_id" :label="newProduct.product_label"
                            @update:label="newProduct.product_label = $event" apiUrl="/api/products/suggestions" />
                    </div>
                    <div>
                        <InputLabel for="brand" value="Merk" />
                        <p class="dark:text-white mt-2">{{ productDetails?.brand?.brand_name }}</p>
                    </div>
                    <div>
                        <InputLabel for="unit" value="Kategori" />
                        <p class="dark:text-white mt-2">{{ productDetails?.tag }}</p>
                    </div>
                    <!-- <div>
                        <InputLabel for="quantity" value="Jumlah" />
                        <TextInput type="number" id="quantity" v-model="newProduct.quantity" />
                        <InputError :message="form.errors.quantity" />
                    </div>
                    <div>
                        <InputLabel for="unit" value="Satuan" />
                        <TextInput id="unit" v-model="newProduct.unit" />
                        <InputError :message="form.errors.unit" />
                    </div> -->
                    <div>
                        <InputLabel for="unit" value="&nbsp;" />
                        <Button type="button" color="green" @click="addRow">
                            Tambah
                        </Button>
                    </div>
                </div>
                <div class="mt-2">
                    <InputLabel for="unit" value="Spesifikasi" />
                    <p class="dark:text-white mt-2">{{ productDetails?.product_description }}&nbsp;</p>
                </div>

                <!-- Display product details returned from the API -->
                <!-- <div v-if="productDetails" class="mt-2 text-dark dark:text-white">
                    <p>ID: {{ productDetails.id }}</p>
                    <p>Kategori: {{ productDetails.tag }}</p>
                    <p>Merk: {{ productDetails.brand.brand_name }}</p>
                    <p>Spesifikasi: {{ productDetails.product_description }}</p>
                </div> -->

                <div class="relative overflow-x-auto overflow-y-hidden shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3">Barang</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.details" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.product_label }}</td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1" type="number" v-model="item.quantity" />
                                </td>
                                <td class="px-4 py-1">
                                    <!-- <TextInput class="py-1" type="text" v-model="item.unit" /> -->
                                    <Select v-model="item.unit">
                                        <option v-for="option in satuanOptions" :value="option.value"
                                            :key="option.value">
                                            {{ option.label }}
                                        </option>
                                    </Select>
                                </td>
                                <td class="px-4 py-1">
                                    <Button type="button" color="red" @click="removeRow(index)">
                                        Hapus
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between mt-2">
                    <Button color="gray" @click="goBack" type="button">
                        Kembali
                    </Button>
                    <PrimaryButton type="submit">
                        Simpan
                    </PrimaryButton>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>

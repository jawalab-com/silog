<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';

const props = defineProps({
    formType: String,
    purchaseOrder: Object,
    tags: Object,
    suppliers: Object,
});

const form = useForm({
    _method: props.purchaseOrder.id ? 'put' : 'post',
    form_type: props.formType,
    supplier_id: props.purchaseOrder?.supplier_id || '',
    user_id: props.purchaseOrder?.user_id || '',
    submission_number: props.purchaseOrder?.submission_number,
    order_date: props.purchaseOrder?.order_date || new Date().toISOString().split('T')[0],
    status: props.purchaseOrder?.status || '',
    total_amount: props.purchaseOrder?.total_amount || '',
    details: props.purchaseOrder?.details || [],
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

const title = (!!props.purchaseOrder ? 'Edit' : 'Tambah') + (props.formType == 'submission' ? ' Pengajuan' : ' Purchase Order');
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Purchase Order', href: route('purchase-orders.index') },
    { name: !!props.purchaseOrder ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    if (!!props.purchaseOrder.id) {
        form.put(route("purchase-orders.update", props.purchaseOrder.id));
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
                    <div>
                        <InputLabel for="submission_number" value="Nomor" />
                        <TextInput type="hidden" id="submission_number" v-model="form.submission_number" disabled />
                        <p class="py-2 dark:text-white">
                            {{ form.submission_number }}
                        </p>
                        <InputError :message="form.errors.submission_number" />
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Pengajuan" />
                        <TextInput type="hidden" id="order_date" v-model="form.order_date" />
                        <p class="py-2 dark:text-white">
                            {{ form.order_date }}
                        </p>
                        <InputError :message="form.errors.order_date" />
                    </div>

                    <div>
                        <InputLabel for="slug" value="Kategori" />
                        <Select id="slug" v-model="form.slug">
                            <option v-for="tag in tags" :value="tag.slug" :key="tag.slug">
                                {{ tag.tag_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.supplier_id" />
                    </div>

                    <div>
                        <InputLabel for="supplier_id" value="Supplier" />
                        <Select id="supplier_id" v-model="form.supplier_id">
                            <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">
                                {{ supplier.supplier_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.supplier_id" />
                    </div>
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                    Daftar Barang
                </h2>

                <div class="relative overflow-x-auto overflow-y-hidden shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3">Barang</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th class="px-4 py-3">Harga</th>
                                <th class="px-4 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.details" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.product_label }}</td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1" type="hidden" v-model="item.quantity" />
                                    <p class="py-1">{{ item.quantity }}</p>
                                </td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1" type="hidden" v-model="item.unit" />
                                    <p class="py-1">
                                        {{ satuanOptions.find(option => option.value === item.unit)?.label }}
                                    </p>
                                </td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1" type="number" v-model="item.price" />
                                </td>
                                <td class="px-4 py-1">
                                    <p class="py-1">
                                        {{ isNaN(item.quantity * item.price) ? '0.00' : (item.quantity *
                                            item.price).toFixed(0) }}
                                    </p>
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

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
    comment: props.salesOrder?.comment,
});

const orderStatus = [
    { value: 'SUBMISSION_PENDING', label: 'Pengajuan Tertunda' },
    { value: 'SUBMISSION_APPROVED', label: 'Pengajuan Disetujui' },
    { value: 'SUBMISSION_REJECTED', label: 'Pengajuan Ditolak' },
    { value: 'COMPLETED', label: 'Selesai' },
    { value: 'CANCELLED', label: 'Dibatalkan' },
    { value: 'REFUNDED', label: 'Dikembalikan' },
];

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
    { name: 'Sales Order', href: route('sales-orders.index') },
    { name: !!props.salesOrder ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    try {
        form.put(route("sales-orders.update", props.salesOrder.id), {
            onSuccess: () => {
                console.log('Sales order updated successfully');
            },
            onError: (errors) => {
                console.error('Failed to update sales order:', errors);
            }
        });
    } catch (error) {
        console.error('An unexpected error occurred:', error);
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
                        <InputLabel for="number" value="Nomor" />
                        <p class="dark:text-white mt-2">{{ salesOrder.number }}</p>
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Pengajuan" />
                        <p class="dark:text-white mt-2">{{ salesOrder.order_date }}</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.details" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.product_label }}</td>
                                <td class="px-4 py-1">{{ item.quantity }}</td>
                                <td class="px-4 py-1">
                                    {{ satuanOptions.find(option => option.value === item.unit)?.label }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <div class="card-header px-4 py-4 border-b border-gray-500"></div>
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-2">
                        Persetujuan
                    </h2>
                    <p class="text-base leading-relaxed text-gray-800 dark:text-gray-200">
                        Apakah Anda yakin ingin menerima pengajuan sales order ini?
                        Pastikan data pengajuan sudah benar dan sesuai dengan permintaan.
                    </p>
                    <label for="message" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">
                        Komentar (opsional)
                    </label>
                    <textarea v-model="form.comment" id="message" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Berikan komentar untuk menuliskan alasan penolakan jika diperlukan..."></textarea>
                </div>

                <p class="text-base leading-relaxed text-gray-800 dark:text-gray-200 text-right mt-2">
                    Klik "Terima" untuk menyetujui atau "Tolak" untuk Menolak.
                </p>

                <div class="flex justify-between mt-2">
                    <Button color="gray" @click="goBack" type="button">
                        Kembali
                    </Button>
                    <div>
                        <Button color="red" @click="form.status = 'SUBMISSION_REJECTED'" type="submit">
                            Tolak
                        </Button>
                        <Button color="green" @click="form.status = 'SUBMISSION_APPROVED'" type="submit" class="ml-2">
                            Terima
                        </Button>
                    </div>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>

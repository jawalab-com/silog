<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';

const props = defineProps({
    rfq: Object,
    tagSuppliers: Array,
    rfqStatus: Array,
    suppliers: Array,
});

const form = useForm({
    _method: props.rfq.id ? 'put' : 'post',
    // supplier_id: props.rfq?.supplier_id || '',
    user_id: props.rfq?.user_id || '',
    rfq_number: props.rfq?.rfq_number,
    request_date: props.rfq?.request_date || new Date().toISOString().split('T')[0],
    total_amount: props.rfq?.total_amount || '',
    status: props.rfq?.status || '',
    comment: props.rfq?.comment || '',
    products: props.rfq?.products || [],
    suppliers: props.rfq?.suppliers || [],
});

const newProduct = ref({
    product_id: '',
    product_name: '',
    quantity: 1,
    unit: 'unit',
});

const productDetails = ref(null);

const addRow = () => {
    form.products.push({
        product_id: newProduct.value.product_id,
        product_name: newProduct.value.product_name,
        quantity: newProduct.value.quantity,
        unit: newProduct.value.unit
    });
};

const removeRow = (index) => {
    form.products.splice(index, 1);
};

const title = 'Pengajuan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Purchase Order', href: route('rfqs.index') },
    { name: !!props.rfq ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    try {
        form.put(route("rfqs.update", props.rfq.id), {
            onSuccess: () => {
                console.log('Purchase order updated successfully');
            },
            onError: (errors) => {
                console.error('Failed to update purchase order:', errors);
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
                <div class="flex justify-between w-full">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ title }}
                    </h2>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Status: {{ rfq.status.toUpperCase() }}
                    </h2>
                </div>
            </template>

            <form @submit.prevent="saveAction">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="number" value="Nomor" />
                        <p class="dark:text-white mt-2">{{ rfq.rfq_number }}</p>
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Pengajuan" />
                        <p class="dark:text-white mt-2">{{ rfq.request_date }}</p>
                    </div>
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                    Supplier
                </h2>

                <div class="relative overflow-x-auto overflow-y-hidden sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                        <!-- <thead class="text-xs text-gray-700 uppercase dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Supplier</th>
                            </tr>
                        </thead> -->
                        <tbody>
                            <tr v-for="(item, index) in form.suppliers" :key="index" class="">
                                <td class="px-4 py-1">{{ item.tag.tag_name }}</td>
                                <td class="px-4 py-1">
                                    <Select v-if="rfq.status === rfqStatus['PENDING']" id="supplier_id"
                                        v-model="item.supplier_id" class="py-1 px-2">
                                        <option v-for="supplier in tagSuppliers[item.tag.slug]" :value="supplier.id"
                                            :key="supplier.id">
                                            {{ supplier.supplier_name }}
                                        </option>
                                    </Select>
                                    <span v-else>{{ item.supplier.supplier_name }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <InputError :message="form.errors.suppliers" />
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                    Daftar Barang
                </h2>

                <div class="relative overflow-x-auto overflow-y-hidden shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Barang</th>
                                <th class="px-4 py-3">Stok</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th class="px-4 py-3">Harga</th>
                                <th class="px-4 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.products" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.tag_name }}</td>
                                <td class="px-4 py-1">{{ item.product_name }}</td>
                                <td class="px-4 py-1">{{ item.stock }}</td>
                                <td class="px-4 py-1">{{ item.quantity }}</td>
                                <td class="px-4 py-1">{{ item.unit_name }}</td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1"
                                        :type="rfqStatus['PENDING'] === rfq.status ? 'number' : 'hidden'"
                                        v-model="item.unit_price" step="0.01" />
                                    {{ rfqStatus['PENDING'] === rfq.status ? '' : item.unit_price }}
                                </td>
                                <td class="px-4 py-1">
                                    <p class="py-1">
                                        <TextInput class="py-1" type="hidden" v-model="item.total_price" />
                                        {{
                                            item.total_price = isNaN(item.quantity * item.unit_price) ? 0.00 :
                                                (item.quantity * item.unit_price).toFixed(0)
                                        }}
                                    </p>
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
                        Apakah Anda yakin ingin menerima pengajuan purchase order ini?
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
                        <Button color="red" @click="form.status = rfqStatus['REJECTED']" type="submit">
                            Tolak
                        </Button>
                        <Button color="green"
                            @click="form.status = rfq.status === rfqStatus['PENDING'] ? rfqStatus['VERIFIED'] : rfqStatus['APPROVED']"
                            type="submit" class="ml-2">
                            Terima
                        </Button>
                    </div>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>

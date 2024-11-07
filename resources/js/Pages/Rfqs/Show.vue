<script setup>
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FwbButtonGroup } from 'flowbite-vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';
import utils from '@/utils';

const props = defineProps({
    rfq: Object,
    tagSuppliers: Object,
    rfqStatus: Object,
    suppliers: Array,
});

const page = usePage();
const role = (page.props.auth.user.all_teams.find(team => team.id === page.props.auth.user.current_team_id)).membership?.role || 'owner';

const form = useForm({
    _method: props.rfq.id ? 'put' : 'post',
    // supplier_id: props.rfq?.supplier_id || '',
    user_id: props.rfq?.user_id || '',
    rfq_number: props.rfq?.rfq_number,
    request_date: props.rfq?.request_date || new Date().toISOString().split('T')[0],
    total_amount: props.rfq?.total_amount || '',
    verified: null,
    status: props.rfq?.status || '',
    comment: props.rfq?.comment || '',
    products: props.rfq?.products || [],
    test: null,
    suppliers: props.rfq?.suppliers?.map(supplier => ({
        rfq_id: supplier.rfq_id || '',
        tag: supplier.tag || '',
        supplier_id: supplier.supplier_id || '',
        discount: supplier.discount || '',
        tax: supplier.tax || '',
        transportation: supplier.transportation || '',
        file_proof: supplier.file_proof || null,
        file_invoice: supplier.file_invoice || null,
        file_receipt: supplier.file_receipt || null,
        file_proof_path: null,
        file_invoice_path: null,
        file_receipt_path: null,
        date_sent: supplier.date_sent || '',
        date_received: supplier.date_received || ''
    })) || [],
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
        form.post(route("rfqs.update", props.rfq.id), {
            onSuccess: () => {
                console.log('Purchase order updated successfully');
            },
            onError: (errors) => {
                console.error('Failed to update purchase order:', errors);
            },
            forceFormData: true,
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

            <form @submit.prevent="saveAction" enctype="multipart/form-data">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="number" value="Nomor" />
                        <p class="dark:text-white mt-2">{{ rfq.rfq_number }}</p>
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Perihal" />
                        <p class="dark:text-white mt-2">{{ rfq.title }}</p>
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Pengajuan" />
                        <p class="dark:text-white mt-2">{{ rfq.request_date }}</p>
                    </div>

                    <div>
                        <InputLabel for="order_date" value="Tanggal Peruntukan" />
                        <p class="dark:text-white mt-2">{{ rfq.allocation_date }}</p>
                    </div>
                </div>

                <div v-if="(rfq.verified_3) || (rfq.verified_2 && ['purchasing'].includes(role))">
                    <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                        Supplier
                    </h2>
                    <div class="relative overflow-x-auto overflow-y-hidden sm:rounded-lg mt-2">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                            <tbody>
                                <template v-for="(item, index) in form.suppliers" :key="index">
                                    <tr>
                                        <td class="px-4 py-0.5">{{ item.tag.tag_name }}</td>
                                        <td class="px-4 py-0.5" colspan="3">
                                            <Select
                                                v-if="(rfq.verified_2 && !rfq.verified_3 && ['purchasing'].includes(role))"
                                                v-model="item.supplier_id" class="py-1 px-2">
                                                <option v-for="supplier in tagSuppliers[item.tag.slug]"
                                                    :value="supplier.id" :key="supplier.id">
                                                    {{ supplier.supplier_name }}
                                                </option>
                                            </Select>
                                            <span
                                                v-else-if="(rfq.verified_2 && rfq.verified_3 && ['purchasing'].includes(role))">
                                                {{ tagSuppliers[item.tag.slug].find(supplier => supplier.id ===
                                                    item.supplier_id)?.supplier_name }}
                                            </span>
                                            <span v-else>:
                                                {{ item.supplier.supplier_name }}
                                            </span>
                                        </td>
                                        <td :colspan="role === 'purchasing' && !rfq.verified_3 ? '3' : '2'">
                                            <div class="flex">
                                                <div class="flex items-center me-4"
                                                    v-if="role === 'purchasing' && rfq.verified_3">
                                                    <Button color="gray" @click="form.verified = 1" type="submit"
                                                        class="py-1">
                                                        Diterima
                                                    </Button>
                                                </div>
                                                <div class="flex items-center me-4"
                                                    v-if="role === 'keuangan' && rfq.verified_3">
                                                    <Button color="gray" @click="form.verified = 1" type="submit"
                                                        class="py-1">
                                                        Dibayar
                                                    </Button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-0.5">Diskon</td>
                                        <td class="px-4 py-0.5">
                                            <TextInput v-if="role === 'purchasing' && !rfq.verified_3" class="py-1 px-2"
                                                type="number" v-model="item.discount" />
                                            <span class="text-md" v-else>{{ item.discount }}</span>
                                        </td>
                                        <td class="px-4 py-0.5">Tanggal Dikirim</td>
                                        <td class="px-4 py-0.5">
                                            {{ item.date_sent }}
                                            <TextInput class="py-1 px-2" type="hidden" v-model="item.date_sent" />
                                        </td>
                                        <td class="px-4 py-0.5">Bukti</td>
                                        <td class="px-4 py-0.5" v-if="role === 'purchasing' && !rfq.verified_3">
                                            <input
                                                class="h-8 block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                id="small_size" type="file"
                                                @change="event => form.suppliers[index].file_proof_path = event.target.files[0]">
                                        </td>
                                        <td v-if="item.file_proof" class="px-4 py-0.5">
                                            <a v-if="item.file_invoice" :href="`/storage/${item.file_proof}`"
                                                class="text-blue-700 dark:text-blue-300 hover:underline">
                                                Lihat File
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-0.5">Pajak %</td>
                                        <td class="px-4 py-0.5">
                                            <TextInput v-if="role === 'purchasing' && !rfq.verified_3" class="py-1 px-2"
                                                type="number" v-model="item.tax" />
                                            <span class="text-md" v-else>{{ item.tax }}</span>
                                        </td>
                                        <td class="px-4 py-0.5">Tanggal Diterima</td>
                                        <td class="px-4 py-0.5">
                                            {{ item.date_received }}
                                            <TextInput class="py-1 px-2" type="hidden" v-model="item.date_received" />
                                        </td>
                                        <td class="px-4 py-0.5">Invoice</td>
                                        <td class="px-4 py-0.5" v-if="role === 'purchasing' && !rfq.verified_3">
                                            <input
                                                class="h-8 block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                type="file"
                                                @change="event => form.suppliers[index].file_invoice_path = event.target.files[0]">
                                        </td>
                                        <td class="px-4 py-0.5">
                                            <a v-if="item.file_invoice" :href="`/storage/${item.file_invoice}`"
                                                class="text-blue-700 dark:text-blue-300 hover:underline">
                                                Lihat File
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-0.5">Transport</td>
                                        <td class="px-4 py-0.5">
                                            <TextInput v-if="role === 'purchasing' && !rfq.verified_3" class="py-1 px-2"
                                                type="number" v-model="item.transportation" />
                                            <span class="text-md" v-else>{{ item.transportation }}</span>
                                        </td>
                                        <td class="px-4 py-0.5">Lama Pengiriman</td>
                                        <td class="px-4 py-0.5">
                                            <span class="text-xl">{{ item.date_sent && item.date_received ?
                                                Math.ceil((new
                                                    Date(item.date_received) - new Date(item.date_sent)) / (1000 * 60 * 60 *
                                                        24)) + ' hari' : '-' }}</span>
                                        </td>
                                        <td class="px-4 py-0.5">Nota</td>
                                        <td class="px-4 py-0.5" v-if="role === 'purchasing' && !rfq.verified_3">
                                            <input
                                                class="h-8 block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                type="file"
                                                @change="event => form.suppliers[index].file_receipt_path = event.target.files[0]">
                                        </td>
                                        <td class="px-4 py-0.5">
                                            <a v-if="item.file_receipt" :href="`/storage/${item.file_receipt}`"
                                                target="_blank"
                                                class="text-blue-700 dark:text-blue-300 hover:underline">
                                                Lihat File
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-0.5" colspan="7">&nbsp;</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="relative overflow-x-auto overflow-y-hidden sm:rounded-lg mt-2">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                            <thead class="text-xs text-gray-700 uppercase dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Supplier</th>
                                    <th class="px-4 py-3">Diskon</th>
                                    <th class="px-4 py-3">Pajak %</th>
                                    <th class="px-4 py-3">Transport</th>
                                    <th class="px-4 py-3">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(item, index) in form.suppliers" :key="index">
                                    <tr class="">
                                        <td class="px-4 py-1">{{ item.tag.tag_name }}</td>
                                        <td class="px-4 py-1">
                                            <Select v-if="rfq.verified_2 && ['purchasing'].includes(role)"
                                                v-model="item.supplier_id" class="py-1 px-2">
                                                <option v-for="supplier in tagSuppliers[item.tag.slug]"
                                                    :value="supplier.id" :key="supplier.id">
                                                    {{ supplier.supplier_name }}
                                                </option>
                                            </Select>
                                            <span v-else>:
                                                {{ item.supplier.supplier_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <TextInput class="py-1 px-2" type="number" v-model="item.discount" />
                                        </td>
                                        <td>
                                            <TextInput class="py-1 px-2" type="number" v-model="item.tax" />
                                        </td>
                                        <td>
                                            <TextInput class="py-1 px-2" type="number" v-model="item.transportation" />
                                        </td>
                                        <td>
                                            <fwb-button-group class="py-1 px-2">
                                                <Button color="yellow" type="button" class="p-0 py-1"
                                                    :data-modal-target="'proof-' + index"
                                                    :data-modal-toggle="'proof-' + index" title="Bukti">
                                                    Bukti
                                                </Button>
                                                <Button color="yellow" type="button" class="p-0 py-1"
                                                    :data-modal-target="'receipt-' + index"
                                                    :data-modal-toggle="'receipt-' + index" title="Nota">
                                                    Nota
                                                </Button>
                                                <Button color="green" class="p-0 py-1">
                                                    <Icon name="info" class="w-4.5 h-4.5" />
                                                </Button>
                                            </fwb-button-group>

                                            <div :id="'proof-' + index" tabindex="-1" aria-hidden="true"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <div
                                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3
                                                                class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Upload Bukti Supplier
                                                            </h3>
                                                        </div>
                                                        <div class="p-4 md:p-5 space-y-4">
                                                            <InputLabel value="Nota Supplier" />
                                                            <TextInput type="file" v-model="item.file_proof_path" />
                                                            <Link v-if="item.file_proof" :href="'#'" target="_blank"
                                                                class="text-lg text-blue-700 dark:text-blue-300 hover:underline mt-8">
                                                            Lihat File
                                                            </Link>
                                                        </div>
                                                        <div
                                                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                            <button :data-modal-hide="'proof-' + index" type="button"
                                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                Ok
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div :id="'receipt-' + index" tabindex="-1" aria-hidden="true"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <div
                                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3
                                                                class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Upload Nota Supplier
                                                            </h3>
                                                        </div>
                                                        <div class="p-4 md:p-5 space-y-4">
                                                            <InputLabel value="Nota Supplier" />
                                                            <TextInput type="file" v-model="item.file_proof_path" />
                                                            <Link v-if="item.file_receipt" :href="'#'" target="_blank"
                                                                class="text-lg text-blue-700 dark:text-blue-300 hover:underline mt-8">
                                                            Lihat File
                                                            </Link>
                                                        </div>
                                                        <div
                                                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                            <button :data-modal-hide="'receipt-' + index" type="button"
                                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                Ok
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <InputError :message="form.errors.suppliers" />
                    </div> -->
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
                                <th v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-3 text-center" colspan="2">Stok</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-3 text-right">Harga</th>
                                <th v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.products" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.tag_name }}</td>
                                <td class="px-4 py-1">{{ item.product_name }}</td>
                                <td v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-1 text-right pr-4">
                                    {{ item.stock }}
                                </td>
                                <td v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-0 py-1 text-right">
                                    <span v-if="item.stock - item.quantity >= 0"
                                        class="ml-2 bg-green-100 text-green-800 text-xs font-medium me-2 px-1.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        Tersedia
                                    </span>
                                    <span v-else-if="item.stock > 0"
                                        class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-1.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                        Kurang
                                    </span>
                                    <span v-else
                                        class="ml-2 bg-red-100 text-red-800 text-xs font-medium me-2 px-1.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                        Habis
                                    </span>
                                </td>
                                <td class="px-4 py-1 text-right pr-4">{{ item.quantity }}</td>
                                <td class="px-4 py-1">{{ item.unit_name }}</td>
                                <td v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-1 text-right pr-4">
                                    <template v-if="
                                        (rfq.verified_2 && ['purchasing'].includes(role)) && !rfq.verified_4 && !rfq.verified_3
                                    ">
                                        <TextInput class="py-1" type="number" v-model="item.unit_price" step="0.01" />
                                    </template>
                                    <template v-else>
                                        {{ utils.formatDecimal(item.unit_price) }}
                                        <TextInput class="py-1" type="hidden" v-model="item.unit_price" step="0.01" />
                                    </template>
                                </td>
                                <td v-if="(['admin-gudang', 'purchasing', 'Pimpinan STP'].includes(role))"
                                    class="px-4 py-1 text-right pr-4">
                                    <p class="py-1">
                                        <TextInput class="py-1" type="hidden" v-model="item.total_price" />
                                        {{
                                            utils.formatDecimal(item.total_price = isNaN(item.quantity * item.unit_price) ?
                                                0.00 :
                                                (item.quantity * item.unit_price).toFixed(2))
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

                <!-- <p class="text-base leading-relaxed text-gray-800 dark:text-gray-200 text-right mt-2">
                    Klik "Terima" untuk menyetujui atau "Tolak" untuk Menolak.
                </p> -->

                <div class="flex justify-between mt-2">
                    <Button color="gray" @click="goBack" type="button">
                        Kembali
                    </Button>
                    <div v-if="
                        (role === 'pimpinan-gudang' && rfq.verified_1 == null) ||
                        (role === 'admin-gudang' && rfq.verified_1 != null && rfq.verified_2 == null) ||
                        (role === 'purchasing' && rfq.verified_2 != null && rfq.verified_3 == null) ||
                        (role === 'Pimpinan STP' && rfq.verified_3 != null && rfq.verified_4 == null)
                    ">
                        <!-- <Button color="red" @click="form.status = rfqStatus['REJECTED']" type="submit">
                            Tolak
                        </Button>
                        <Button color="green"
                            @click="form.status = rfq.status === rfqStatus['PENDING'] ? rfqStatus['VERIFIED'] : rfqStatus['APPROVED']"
                            type="submit" class="ml-2">
                            Terima
                        </Button> -->
                        <Button color="red" @click="form.verified = 0" type="submit" v-if="role !== 'purchasing'">
                            Tolak
                        </Button>
                        <Button color="green" @click="form.verified = 1" type="submit" class="ml-2">
                            {{ role === 'purchasing' ? 'Kunci' : 'Terima' }}
                        </Button>
                    </div>
                </div>
            </form>
        </Card>
        <div class="h-40"></div>
    </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';

const props = defineProps({
    pr: Object,
    units: Array,
});

const form = useForm({
    _method: props.pr.id ? 'put' : 'post',
    // supplier_id: props.pr?.supplier_id || '',
    user_id: props.pr?.user_id || '',
    name: props.pr?.name,
    date_created: props.pr?.date_created || new Date().toISOString().split('T')[0],
    date_deadline: props.pr?.date_deadline || new Date().toISOString().split('T')[0],
    subject: props.pr?.subject || '',
    state: props.pr?.state || '',
    lines: props.pr?.lines || [],
});

const neLine = ref({
    product_id: '',
    product_name: '',
    quantity: 1,
    unit_id: 1,
});

const productDetails = ref(null);

const addRow = () => {
    form.lines.push({
        product_id: neLine.value.product_id,
        product_name: neLine.value.product_name,
        quantity: neLine.value.quantity,
        unit_id: neLine.value.unit_id
    });
};

const removeRow = (index) => {
    form.lines.splice(index, 1);
};

const subject = (!!props.pr.id ? 'Edit' : 'Tambah') + ' Pengajuan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Purchase Order', href: route('purchase-requisitions.index') },
    { name: !!props.pr ? 'Edit' : 'Tambah', href: '#' },
];

const saveAction = () => {
    if (!!props.pr.id) {
        form.put(route("purchase-requisitions.update", props.pr.id));
    } else {
        form.post(route("purchase-requisitions.store"));
    }
};

const goBack = () => {
    window.history.back();
};

watch(() => neLine.value.product_id, async (newVal) => {
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
    <AppLayout :subject="subject">
        <Card>
            <template #header class="flex">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ subject }}
                </h2>
            </template>

            <form @submit.prevent="saveAction">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="name" value="Nomor Pengajuan" />
                        <TextInput id="name" v-model="form.name" disabled />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="subject" value="Perihal" />
                        <TextInput type="text" id="subject" v-model="form.subject" />
                        <InputError :message="form.errors.subject" />
                    </div>

                    <div>
                        <InputLabel for="date_created" value="Tanggal Pengajuan" />
                        <TextInput type="date" id="date_created" v-model="form.date_created" />
                        <InputError :message="form.errors.date_created" />
                    </div>

                    <div>
                        <InputLabel for="date_deadline" value="Tanggal Peruntukan" />
                        <TextInput type="date" id="date_deadline" v-model="form.date_deadline" />
                        <InputError :message="form.errors.date_deadline" />
                    </div>
                    <!-- <div>
                        <InputLabel for="supplier_id" value="Supplier" />
                        <Select id="supplier_id" v-model="form.supplier_id">
                            <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">
                                {{ supplier.supplier_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.supplier_id" />
                    </div> -->
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight my-4">
                    Daftar Barang
                </h2>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <InputLabel for="product_id" value="Barang" />
                        <AutoComplete v-model="neLine.product_id" :label="neLine.product_name"
                            @update:label="neLine.product_name = $event" apiUrl="/api/products/suggestions" />
                        <!-- <AutoComplete v-model="neLine.product_id" :label="neLine.product_name"
                            @update:label="neLine.product_name = $event" api-url="/api/lines/suggestions">
                            <template #suggestion-item="{ suggestion, highlighted }">
                                <li :class="['cursor-pointer px-4 py-2 flex items-center', { 'bg-blue-200': highlighted }]"
                                    @click="$emit('click', suggestion)" @mousedown="$emit('mousedown', suggestion)">
                                    <p class="text-md font-semibold">{{ suggestion.product_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ suggestion.brand.brand_name }}
                                    </p>
                                </li>
                                <hr class="my-1">
                            </template>
                        </AutoComplete> -->
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
                        <TextInput type="number" id="quantity" v-model="neLine.quantity" />
                        <InputError :message="form.errors.quantity" />
                    </div>
                    <div>
                        <InputLabel for="unit" value="Satuan" />
                        <TextInput id="unit" v-model="neLine.unit" />
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

                <!-- Display product lines returned from the API -->
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
                            <tr v-for="(item, index) in form.lines" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">{{ item.product_name }}</td>
                                <td class="px-4 py-1">
                                    <TextInput class="py-1" type="number" v-model="item.quantity" />
                                </td>
                                <td class="px-4 py-1">
                                    <!-- <TextInput class="py-1" type="text" v-model="item.unit" /> -->
                                    <Select v-model="item.unit_id">
                                        <option v-for="option in units" :value="option.id" :key="option.id">
                                            {{ option.unit_name }}
                                        </option>
                                    </Select>
                                </td>
                                <td class="px-4 py-1">
                                    <button type="button" class="text-red-500 font-bold hover:text-red-700 mt-2"
                                        @click="removeRow(index)">
                                        <Icon name="close" class="w-6 h-6 font-bold text-red-500 hover:text-red-700" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <InputError :message="form.errors.lines" />
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

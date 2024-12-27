<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Breadcrumb, Button, DataTable, Icon, Select } from '@/Components';
import { FwbButton } from 'flowbite-vue';

const props = defineProps({
    stockOpnames: Array,
    product: Object,
    stockOpname: Object,
});

const form = useForm({
    _method: props.stockOpname.id ? 'put' : 'post',
    product_id: props.product?.id || '',
    initial_stock: props.product?.inventory?.quantity || 0,
    final_stock: props.stockOpname?.final_stock || props.product?.inventory?.quantity || 0,
    date_opname: props.stockOpname?.date_opname || new Date().toISOString().slice(0, 10),
    proof: props.stockOpname?.proof || '',
    proof_path: props.stockOpname?.proof || '',
    comment: props.stockOpname?.comment || '',
});

const columns = [
    { name: 'date_opname', label: 'Tanggal' },
    { name: 'initial_stock', label: 'Stok sebelum diganti' },
    { name: 'final_stock', label: 'Stok setelah diganti' },
    { name: 'proof', label: 'Bukti' },
    { name: 'user_name', label: 'Oleh' },
    { name: 'comment', label: 'Komentar' },
];
const data = props.stockOpnames.map(item => ({
    ...item,
    user_name: item.user.name,
    proof: item.proof ? `<a href="/storage/${item.proof}" target="_blank" class="text-blue-700 dark:text-blue-300">Lihat</a>` : '-',
    date_opname: utils.formatDateTime(item.date_opname),
}));

const changeStock = ref(false);

const title = 'Ubah Stok Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Product', href: route('products.index') },
    { name: !!props.stockOpname ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    if (!!props.stockOpname.id) {
        form.put(route("stock-opnames.update", props.stockOpname.id));
    } else {
        form.post(route("stock-opnames.store"));
    }
};
</script>

<template>
    <AppLayout :title="title">
        <form @submit.prevent="saveAction" enctype="multipart/form-data">
            <Card class="">
                <template #header class="flex">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ title }}
                    </h2>
                </template>

                <div class="grid grid-cols-2 gap-2">
                    <!-- <template v-for="(value, key) in stockOpname" :key="key">
                        <div v-if="!['id', 'user_id', 'updated_at', 'deleted_at', 'created_at'].includes(key)">
                            <InputLabel :for="key"
                                :value="key.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase())" />
                            <template v-if="typeof value === 'string'">
                                <TextInput :id="key" v-model="form[key]" />
                            </template>
                            <template v-else-if="typeof value === 'number'">
                                <TextInput :id="key" v-model="form[key]" type="number" />
                            </template>
                            <InputError :message="form.errors[key]" />
                        </div>
                    </template> -->

                    <div>
                        <InputLabel for="stockOpname_name" value="Nama:" />
                        <p class="dark:text-white mt-2">{{ product.product_name }}</p>
                    </div>

                    <div>
                        <InputLabel for="brand_id" value="Merk:" />
                        <p class="dark:text-white mt-2">{{ product.brand.brand_name }}</p>
                    </div>

                    <div>
                        <InputLabel for="tag" value="Kategori:" />
                        <p class="dark:text-white mt-2">{{ product.tag.tag_name }}</p>
                    </div>

                    <div>
                        <InputLabel for="description" value="Spesifikasi:" />
                        <p class="dark:text-white mt-2">{{ product.product_description }}</p>
                    </div>

                    <div>
                        <InputLabel for="verified" value="Status Verifikasi:" />
                        <p class="mt-2" :class="product.verified ? 'text-green-500' : 'text-red-500'">
                            {{ product.verified ? '✓ Terverifikasi' : 'Belum Terverifikasi' }}

                        </p>
                    </div>

                    <!-- <div>
                        <InputLabel for="price" value="Harga" />
                        <TextInput id="price" v-model="form.price" type="number" />
                        <InputError :message="form.errors.price" />
                    </div> -->
                </div>

                <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700"></div>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div>
                        <InputLabel for="initial_stock" value="Stok Semula" />
                        <p class="dark:text-white mt-2">{{ form.initial_stock }}</p>
                        <TextInput type="hidden" id="initial_stock" v-model="form.initial_stock" />
                        <InputError :message="form.errors.initial_stock" />
                    </div>

                    <div>
                        <InputLabel for="final_stock" value="Stok setelah diubah" />
                        <TextInput type="number" id="final_stock" v-model="form.final_stock" />
                        <InputError :message="form.errors.final_stock" />
                    </div>

                    <div>
                        <InputLabel for="final_stock" value="Tanggal diubah" />
                        <p class="dark:text-white mt-2">{{ form.date_opname }}</p>
                        <TextInput type="hidden" id="date_opname" v-model="form.date_opname" />
                        <InputError :message="form.errors.date_opname" />
                    </div>

                    <div>
                        <InputLabel for="proof" value="Upload Bukti" />
                        <TextInput type="file" id="proof" @change="event => form.proof_path = event.target.files[0]" />
                        <InputError :message="form.errors.proof" />
                    </div>
                </div>

                <div>
                    <label for="message" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">
                        Komentar (opsional)
                    </label>
                    <textarea v-model="form.comment" id="message" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Berikan komentar untuk menuliskan alasan penolakan jika diperlukan..."></textarea>
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

        <Card class="mt-8">
            <template #header class="flex">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Riwayat Perubahan Stok Barang
                </h2>
            </template>
            <DataTable :data="data" :columns="columns" />
        </Card>

        <div class="h-60"></div>
    </AppLayout>
</template>

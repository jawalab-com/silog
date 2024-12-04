<script setup>
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Breadcrumb, Button, DataTable, Icon } from '@/Components';
import { FwbButton } from 'flowbite-vue';

const props = defineProps({
    product: Object,
    brands: Array,
    tags: Array,
    units: Array,
});

const page = usePage();
const role = (page.props.auth.user.all_teams.find(team => team.id === page.props.auth.user.current_team_id)).membership?.role || 'owner';

const form = useForm({
    product_name: props.product?.product_name || '',
    brand_id: props.product?.brand_id || '',
    tag: props.product?.tag || '',
    product_description: props.product?.product_description || '',
    price: props.product?.price || 0,
    minimum_quantity: props.product?.minimum_quantity || 0,
    verified: !!props.product?.verified,
    unit_id: props.product?.unit_id || null,
    unit_conversions: props.product?.unit_conversions || [],
    inventory: {
        quantity: props.product?.inventory?.quantity || 0,
        new_quantity: props.product?.inventory?.quantity || 0,
    },
});

const changeStock = ref(false);

const title = (!!props.product.id ? 'Edit' : 'Tambah') + ' Product';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Product', href: route('products.index') },
    { name: !!props.product ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    if (!!props.product.id) {
        form.put(route("products.update", props.product.id));
    } else {
        form.post(route("products.store"));
    }
};

const addRow = () => {
    form.unit_conversions.push({
        product_id: props.product.id,
        from_unit_id: form.unit_id,
        from_unit: {
            id: form.unit_id,
            unit_name: props.units.find(unit => unit.id === form.unit_id)?.unit_name || ''
        },
        to_unit_id: null,
        factor: 1
    });
};

const removeRow = (index) => {
    form.unit_conversions.splice(index, 1);
};

watch(() => form.unit_id, (newUnitId) => {
    form.unit_conversions.forEach(conversion => {
        conversion.from_unit_id = newUnitId;
        conversion.from_unit.id = newUnitId;
        conversion.from_unit.unit_name = props.units.find(unit => unit.id === newUnitId)?.unit_name || '';
    });
});

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
                    <!-- <template v-for="(value, key) in product" :key="key">
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
                        <InputLabel for="product_name" value="Nama" />
                        <TextInput id="product_name" v-model="form.product_name" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="brand_id" value="Merk" />
                        <Select id="brand_id" v-model="form.brand_id" :options="brands" filter optionLabel="brand_name"
                            optionValue="id" class="w-full" />
                        <InputError :message="form.errors.brand_id" />
                    </div>

                    <div>
                        <InputLabel for="product_description" value="Spesifikasi" />
                        <TextInput id="product_description" v-model="form.product_description" />
                        <InputError :message="form.errors.product_description" />
                    </div>

                    <div>
                        <InputLabel for="tag" value="Kategori" />
                        <Select id="tag" v-model="form.tag" :options="tags" filter optionLabel="tag_name"
                            optionValue="slug" class="w-full" />
                        <InputError :message="form.errors.tag" />
                    </div>

                    <div>
                        <InputLabel for="minimum_quantity" value="Stok Minimum" />
                        <TextInput id="minimum_quantity" v-model="form.minimum_quantity" />
                        <InputError :message="form.errors.minimum_quantity" />
                    </div>

                    <div>
                        <InputLabel for="unit_id" value="Satuan Terkecil" />
                        <Select v-model="form.unit_id" :options="units" filter optionLabel="unit_name" optionValue="id"
                            placeholder="Pilih satuan terkecil" class="w-full" />
                        <InputError :message="form.errors.unit_id" />
                    </div>

                    <div class="flex items-center" v-if="role != 'pengaju'">
                        <input checked id="verified" type="checkbox" v-model="form.verified"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <InputLabel for="verified" value="Terverifikasi" class="ml-2" />
                        <InputError :message="form.errors.verified" />
                    </div>

                    <!-- <div>
                        <InputLabel for="price" value="Harga" />
                        <TextInput id="price" v-model="form.price" type="number" />
                        <InputError :message="form.errors.price" />
                    </div> -->

                </div>

                <div class="card-header px-4 pb-2 pt-8 border-b border-gray-200 dark:border-gray-700"></div>

                <h2 class="text-lg py-4">Konversi Satuan</h2>
                <p>Konversi satuan memungkinkan Anda untuk mengatur konversi dari satu satuan ke satuan lainnya.
                    Misalnya, Anda dapat
                    mengonversi dari kilogram ke gram atau dari liter ke mililiter. Setiap konversi memerlukan satuan
                    tujuan dan faktor
                    konversi yang sesuai.</p>

                <div class="relative overflow-x-auto overflow-y-hidden shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3 w-40">Satuan</th>
                                <th class="px-4 py-3 w-12">&nbsp;</th>
                                <th class="px-4 py-3 w-40">Jumlah konversi</th>
                                <th class="px-4 py-3 w-12">&nbsp;</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in form.unit_conversions" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-1">
                                    <Select v-model="item.to_unit_id" :options="units" filter optionLabel="unit_name"
                                        optionValue="id" placeholder="Pilih satuan terkecil" class="w-full" />
                                </td>
                                <td class="px-4 py-1 font-bold text-lg">=</td>
                                <td class="px-4 py-1">
                                    <TextInput type="number" v-model="item.factor" />
                                </td>
                                <td class="px-4 py-1">{{ item.from_unit.unit_name }}</td>
                                <td class="px-4 py-1">
                                    <button type="button" class="text-red-500 font-bold hover:text-red-700 mt-2"
                                        @click="removeRow(index)">
                                        <Icon name="close" class="w-6 h-6 font-bold text-red-500 hover:text-red-700" />
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3" colspan="5">
                                    <button type="button"
                                        class="w-full text-blue-700 hover:text-blue-500 dark:text-blue-300 font-bold"
                                        @click="addRow">
                                        <Icon name="plus" class="w-6 h-6 inline-block" /> Tambah Satuan Konversi
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <InputError :message="form.errors.products" />
                </div>

                <!-- <div class="flex items-center my-4">
                    <input id="changeStock" type="checkbox" v-model="changeStock"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <InputLabel for="changeStock" value="Ubah Stok" class="ml-2" />
                    <InputError :message="form.errors.changeStock" />
                </div>

                <div v-if="changeStock">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="quantity" value="Stok Semula" class="ml-2" />
                            <TextInput disabled id="quantity" v-model="form.inventory.quantity" />
                            <InputError :message="form.errors.quantity" />
                        </div>

                        <div>
                            <InputLabel for="quantity" value="Stok setelah diubah" class="ml-2" />
                            <TextInput type="number" id="quantity" v-model="form.inventory.new_quantity" />
                            <InputError :message="form.errors.quantity" />
                        </div>

                        <div>
                            <InputLabel for="proof" value="Upload Bukti" class="ml-2" />
                            <TextInput type="file" id="proof" v-model="form.proof" />
                            <InputError :message="form.errors.proof" />
                        </div>
                    </div>
                </div> -->

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

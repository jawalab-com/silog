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
    product: Object,
    brands: Array,
    tags: Array,
});

const form = useForm({
    product_name: props.product?.product_name || '',
    brand_id: props.product?.brand_id || '',
    tag: props.product?.tag || '',
    product_description: props.product?.product_description || '',
    price: props.product?.price || 0,
    minimum_quantity: props.product?.minimum_quantity || 0,
    verified: props.product?.verified || false,
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
                        <Select id="brand_id" v-model="form.brand_id">
                            <option value="">Pilih Brand</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.brand_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.brand_id" />
                    </div>

                    <div>
                        <InputLabel for="tag" value="Kategori" />
                        <Select id="tag" v-model="form.tag">
                            <option value="">Pilih Brand</option>
                            <option v-for="tag in tags" :key="tag.slug" :value="tag.slug">
                                {{ tag.tag_name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.tag" />
                    </div>

                    <div>
                        <InputLabel for="product_description" value="Spesifikasi" />
                        <TextInput id="product_description" v-model="form.product_description" />
                        <InputError :message="form.errors.product_description" />
                    </div>

                    <div class="flex items-center">
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

                <!-- <div class="card-header px-4 pb-2 pt-8 border-b border-gray-200 dark:border-gray-700"></div>

                <div class="flex items-center my-4">
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

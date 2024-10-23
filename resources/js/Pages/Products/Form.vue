<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
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
});

const form = useForm({
    product_name: props.product?.product_name || '',
    brand_id: props.product?.brand_id || '',
    tag: props.product?.tag || '',
    product_description: props.product?.product_description || '',
    price: props.product?.price || 0,
});

const title = (!!props.product ? 'Edit' : 'Tambah') + ' Product';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Product', href: route('products.index') },
    { name: !!props.product ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    if (!!props.product) {
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
                        <InputLabel for="product_name" value="Name" />
                        <TextInput id="product_name" v-model="form.product_name" />
                        <InputError :message="form.errors.product_name" />
                    </div>

                    <div>
                        <InputLabel for="brand_id" value="Brand" />
                        <TextInput id="brand_id" v-model="form.brand_id" />
                        <InputError :message="form.errors.brand_id" />
                    </div>

                    <div>
                        <InputLabel for="tag" value="Tag" />
                        <TextInput id="tag" v-model="form.tag" />
                        <InputError :message="form.errors.tag" />
                    </div>

                    <div>
                        <InputLabel for="product_description" value="Deskripsi" />
                        <TextInput id="product_description" v-model="form.product_description" />
                        <InputError :message="form.errors.product_description" />
                    </div>

                    <div>
                        <InputLabel for="price" value="Harga" />
                        <TextInput id="price" v-model="form.price" type="number" />
                        <InputError :message="form.errors.price" />
                    </div>
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
    </AppLayout>
</template>

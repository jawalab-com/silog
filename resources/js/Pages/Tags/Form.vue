<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, TextInput } from '@/Components';
import { FwbButton } from 'flowbite-vue';

const props = defineProps({
    tag: Object,
});

const form = useForm({
    tag_name: props.tag?.tag_name,
    tag_description: props.tag?.tag_description,
    slug: props.tag?.slug,
});

const title = (!!props.tag ? 'Edit' : 'Tambah') + ' Kategori Produk';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: 'Tag', href: route('tags.index') },
    { name: !!props.tag ? 'Edit' : 'Tambah', href: '#' },
];

const back = () => window.history.back();

const saveAction = () => {
    form.slug = utils.generateSlug(form.tag_name);
    if (!!props.tag) {
        form.put(route("tags.update", props.tag.id));
    } else {
        form.post(route("tags.store"));
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
                    <div>
                        <InputLabel for="tag_name" value="Nama Tag" />
                        <TextInput id="tag_name" v-model="form.tag_name" />
                        <InputError :message="form.errors.tag_name" />
                    </div>

                    <div>
                        <InputLabel for="tag_description" value="Deskripsi Tag" />
                        <TextInput id="tag_description" v-model="form.tag_description" />
                        <InputError :message="form.errors.tag_description" />
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

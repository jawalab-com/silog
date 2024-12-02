<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, Card, TextInput, InputLabel, InputError, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    tags: Array,
});

const form = useForm({});

const title = 'Laporan Penerimaan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];

</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <Card class="">

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <InputLabel for="date_from" value="Dari Tanggal" />
                    <TextInput type="date" id="date_from" v-model="form.date_from" />
                    <InputError :message="form.errors.date_from" />
                </div>

                <div>
                    <InputLabel for="date_to" value="Sampai Tanggal" />
                    <TextInput type="date" id="date_to" v-model="form.date_to" />
                    <InputError :message="form.errors.date_to" />
                </div>
            </div>

            <template #footer>
                <div class="flex justify-end">
                    <Button color="blue" type="submit">
                        Unduh
                    </Button>
                </div>
            </template>

        </Card>
    </AppLayout>
</template>

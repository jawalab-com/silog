<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Select, Button, Card, TextInput, InputLabel, InputError, DataTable, Icon } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';

const props = defineProps({
    tags: Array,
});

const form = useForm({
    date_from: new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0],
    date_to: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).toISOString().split('T')[0],
    status: 'selesai',
});

const title = 'Laporan Penerimaan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];

const rfq_statuses = [
    { value: '', label: 'SEMUA' },
    { value: 'selesai', label: 'SELESAI' },
    { value: 'draft', label: 'DRAFT' },
    { value: 'pending', label: 'PENDING' },
    { value: 'sedang-dalam-pengiriman', label: 'SEDANG DALAM PENGIRIMAN' },
    { value: 'siap-diambil', label: 'SIAP DIAMBIL' },
    { value: 'diproses', label: 'DIPROSES' },
    // { value: 'verified', label: 'VERIFIED' },
    // { value: 'approved', label: 'APPROVED' },
    // { value: 'rejected', label: 'REJECTED' },
    // { value: 'canceled', label: 'CANCELED' },
];

</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <form method="get" :action="route('rfqs.export')">
            <Card class="">

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="date_from" value="Dari Tanggal" />
                        <TextInput name="date_from" type="date" id="date_from" v-model="form.date_from" />
                        <InputError :message="form.errors.date_from" />
                    </div>

                    <div>
                        <InputLabel for="date_to" value="Sampai Tanggal" />
                        <TextInput name="date_to" type="date" id="date_to" v-model="form.date_to" />
                        <InputError :message="form.errors.date_to" />
                    </div>

                    <div>
                        <InputLabel for="status" value="Status" />
                        <Select name="status" :options="rfq_statuses" class="w-full">
                            <option v-for="status in rfq_statuses" :key="status.value" :value="status.value">
                                {{ status.label }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.status" />
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
        </form>
    </AppLayout>
</template>

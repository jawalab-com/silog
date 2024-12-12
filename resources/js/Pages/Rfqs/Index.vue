<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { AppLayout } from '@/Layouts';
import { Breadcrumb, Button, DataTable, Icon, Select } from '@/Components';
import { FwbButtonGroup } from 'flowbite-vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import utils from '@/utils';

const props = defineProps({
    formType: String,
    rfqs: Array,
    rfqSummary: Array,
    rfqStatus: Object,
    rfqTotal: Object,
});

const page = usePage();
const role = (page.props.auth.user.all_teams.find(team => team.id === page.props.auth.user.current_team_id)).membership?.role || 'owner';

const title = 'Pengajuan Barang';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];

const columns = [
    { name: 'rfq_number', label: 'Nomor Pengajuan' },
    { name: 'request_date', label: 'Tanggal Pengajuan' },
    { name: 'allocation_date', label: 'Tanggal Digunakan' },
    { name: 'user_name', label: 'Pengaju' },
    { name: 'title', label: 'Perihal' },
    { name: 'total_amount', label: 'Total' },
    { name: 'verified', label: 'Status Verifikasi' },
    role === 'keuangan' ? { name: 'payment_status', label: 'Status Pembayaran' } : null,
    { name: 'status', label: 'Status' },
].filter(Boolean);

function getActiveColor(status) {
    return props.rfqStatus == status ? 'bg-blue-200 dark:bg-blue-800 dark:hover:bg-blue-700 hover:bg-blue-100' : 'bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 hover:bg-gray-100';
}

function getActiveTotal(status) {
    return props.rfqTotal == status ? 'bg-blue-200 dark:bg-blue-800 dark:hover:bg-blue-700 hover:bg-blue-100' : 'bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 hover:bg-gray-100';
}

function getActiveLunas(status) {
    return props.rfqLunas == status ? 'bg-blue-200 dark:bg-blue-800 dark:hover:bg-blue-700 hover:bg-blue-100' : 'bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 hover:bg-gray-100';
}

const data = props.rfqs.map(item => ({
    ...item,
    total_amount: utils.formatCurrency(item.total_amount),
    user_name: item.user.name,
    comment: (item.comment?.length || 0) > 30 ? item.comment.substring(0, 30) + '...' : item.comment,
    verified: `Kep. Divisi Logistik: ${item.verified_1 === 1 ? '✔️' : item.verified_1 === 0 ? '❌' : '-'}<br/>` +
        `Admin Gudang: ${item.verified_2 === 1 ? '✔️' : item.verified_2 === 0 ? '❌' : '-'}<br/>` +
        `Purchasing: ${item.verified_3 === 1 ? '✔️' : item.verified_3 === 0 ? '❌' : '-'}<br/>` +
        `Pimpinan: ${item.verified_4 === 1 ? '✔️' : item.verified_4 === 0 ? '❌' : '-'}`,
    payment_status: item.payment_status ? 'Lunas' : 'Belum Lunas',
}));
</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
            v-if="['pengaju'].includes(role)">
            <SuccessButton :href="route('rfqs.create', { formType: formType })">
                <Icon name="plus" class="mr-2" />
                Tambah {{ title }}
            </SuccessButton>
        </div>

        <div class="mb-2">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <Link :href="route('rfqs.index', { rfq_status: 'pending', rfq_total: rfqTotal })"
                    :class="getActiveColor('pending')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Pending ({{ rfqSummary.pending_count }})
                </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm" role="group">
                <Link :href="route('rfqs.index')" :class="getActiveColor('belum')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Belum Selesai ({{ rfqSummary.belum_count }})
                </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: 'pending', rfq_total: rfqTotal })"
                    :class="getActiveColor('pending')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Pending ({{ rfqSummary.pending_count }})
                </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: 'sedang-dalam-pengiriman', rfq_total: rfqTotal })"
                    :class="getActiveColor('sedang-dalam-pengiriman')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Dalam Pengiriman ({{ rfqSummary.pengiriman_count }})
                </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: 'siap-diambil', rfq_total: rfqTotal })"
                    :class="getActiveColor('siap-diambil')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Siap Diambil ({{ rfqSummary.siap_diambil_count }})
                </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: 'selesai', rfq_total: rfqTotal })"
                    :class="getActiveColor('selesai')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Selesai ({{ rfqSummary.siap_diambil_count }})
                </Link>
            </div>
        </div>

        <div class="mb-2">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'est_lt' })"
                    :class="getActiveTotal('est_lt')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Total estimasi harga <= 1000000 </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'est_gt' })"
                    :class="getActiveTotal('est_gt')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Total estimasi harga > 1000000 </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'price_lt' })"
                    :class="getActiveTotal('price_lt')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Total harga <= 1000000 </Link>
            </div>

            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'price_gt' })"
                    :class="getActiveTotal('price_gt')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Total harga > 1000000 </Link>
            </div>
        </div>

        <div class="mb-2">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'est_lt' })"
                    :class="getActiveLunas('')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Lunas + Belum lunas
                </Link>
            </div>
            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'est_lt' })"
                    :class="getActiveLunas('1')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Lunas
                </Link>
            </div>
            <div class="inline-flex rounded-md shadow-sm ml-2" role="group">
                <Link :href="route('rfqs.index', { rfq_status: rfqStatus, rfq_total: 'est_lt' })"
                    :class="getActiveLunas('0')"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 border border-gray-200 rounded-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-700 dark:text-white dark:hover:text-white dark:focus:ring-blue-500 dark:focus:text-white">
                Belum Lunas
                </Link>
            </div>
        </div>

        <DataTable :data="data" :columns="columns">
            <template v-slot:actionColumn="{ item, columns, index }">
                <fwb-button-group>
                    <Button v-if="['pengaju'].includes(role) && [rfqStatus['PENDING']].includes(item.status)"
                        color="yellow" class="p-0 py-1" :href="route('rfqs.edit', { id: item.id })">
                        <Icon name="pencil" class="w-4.5 h-4.5" />
                    </Button>
                    <Button color="green" class="p-0 py-1" :href="route('rfqs.show', { id: item.id })">
                        <Icon name="info" class="w-4.5 h-4.5" />
                    </Button>
                </fwb-button-group>
            </template>
        </DataTable>

    </AppLayout>
</template>

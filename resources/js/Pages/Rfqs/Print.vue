<script setup>
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import PrintLayout from '@/Layouts/PrintLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FwbButtonGroup } from 'flowbite-vue';
import { AutoComplete, Breadcrumb, Button, Card, DataTable, Icon, InputError, InputLabel, Select, TextInput } from '@/Components';
import utils from '@/utils';

const props = defineProps({
    rfq: Object,
    supplier: Object,
    products: Object,
});

const page = usePage();
const role = (page.props.auth.user.all_teams.find(team => team.id === page.props.auth.user.current_team_id)).membership?.role || 'owner';
let total = 0;
</script>

<template>
    <PrintLayout title="Cetak PO">
        <div class="bg-gray-100 flex justify-center items-center min-h-screen">

            <div class="a4">
                <!-- Header Section -->
                <header class="text-center mb-2 border-b border-gray-200 pb-4">
                    <h1 class="text-2xl font-bold">SOLO TECHNOPARK</h1>
                    <p class="text-gray-600">Jl. Ki Hajar Dewantara No. 19 Jebres, Kec. Jebres, Kota Surakarta</p>
                    <p class="text-gray-600">Telp: (0271) 666628 | Email: info@solotechnopark.id</p>
                </header>

                <!-- Content Section -->
                <div class="px-8">
                    <h2 class="text-md text-center font-semibold mb-2">
                        PURCHASE ORDER<br />
                        {{ rfq.rfq_number }}
                    </h2>

                    <div class="mb-2">
                        <div class="flex">
                            <p class="w-44">Perihal</p>
                            <p class="text-gray-700">: {{ rfq.title }}</p>
                        </div>

                        <div class="flex">
                            <p class="w-44">Tanggal Permintaan</p>
                            <p class="text-gray-700">: {{ new Date(rfq.request_date).toLocaleDateString('id-ID') }}</p>
                        </div>

                        <div class="flex">
                            <p class="w-44">Kepada</p>
                            <p class="text-gray-700">: {{ supplier.supplier.supplier_name }}</p>
                        </div>
                    </div>

                    <p class="mb-2">
                        Berikut adalah daftar barang yang kami pesan:
                    </p>

                    <!-- Table Section -->
                    <table class="min-w-full border border-gray-300 mb-2">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-2 border border-gray-300 text-left font-semibold text-sm">Barang</th>
                                <th class="px-2 py-2 border border-gray-300 text-right font-semibold text-sm">Jumlah
                                </th>
                                <th class="px-2 py-2 border border-gray-300 text-right font-semibold text-sm">Harga</th>
                                <th class="px-2 py-2 border border-gray-300 text-right font-semibold text-sm">Sub Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td class="px-2 py-1 border border-gray-300 text-sm">
                                    {{ product.product.product_name }}
                                </td>
                                <td class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{ utils.formatCurrency(product.unit_price) }}
                                </td>
                                <td class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{ utils.formatCurrency(product.quantity * product.unit_price) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border border-gray-300 text-sm" colspan="2">Total</td>
                                <td colspan="2" class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{
                                        utils.formatCurrency(total = products.reduce((sum, item) =>
                                            sum + (item.unit_price * item.quantity), 0)
                                        )
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border border-gray-300 text-sm" colspan="2">Diskon</td>
                                <td colspan="2" class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{
                                        utils.formatCurrency(supplier.discount)
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border border-gray-300 text-sm" colspan="2">
                                    Pajak {{ supplier.tax }}%
                                </td>
                                <td colspan="2" class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{ utils.formatCurrency(total * supplier.tax / 100) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border border-gray-300 text-sm" colspan="2">
                                    Transportasi
                                </td>
                                <td colspan="2" class="px-2 py-1 border border-gray-300 text-sm text-right">
                                    {{ utils.formatCurrency(supplier.transportation) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-1 border border-gray-300 text-sm font-bold" colspan="2">
                                    Grant Total
                                </td>
                                <td colspan="2" class="px-2 py-1 border border-gray-300 text-sm text-right font-bold">
                                    {{
                                        utils.formatCurrency(total + supplier.tax + (total * supplier.tax / 100) +
                                            supplier.transportation)
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="mb-6">
                        Mohon segera diproses dan dikirimkan ke alamat kami secepatnya. Terima kasih atas kerjasamanya.
                    </p>

                    <p>Mengetahui,</p>
                    <br />
                    <br />
                    <br />
                    <p class="font-semibold">Febriansyah Dipokusumo Heryawan</p>
                </div>
            </div>

        </div>
    </PrintLayout>
</template>

<style>
/* A4 size: 210mm x 297mm */
.a4 {
    width: 210mm;
    min-height: 297mm;
    margin: auto;
    padding: 10mm;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: white;
}

/* Print styling */
@media print {
    @page {
        size: A4;
        margin: 0;
        /* Use minimal margin to ensure full use of page */
    }

    body {
        margin: 0;
    }

    .a4 {
        box-shadow: none;
        margin: 0;
        padding: 10mm;
        /* Ensure padding for print-friendly layout */
        width: 100%;
        /* Ensure full width usage on print */
        height: auto;
        /* Allow page height to extend if content overflows */
    }
}
</style>

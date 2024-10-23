<script setup>
import { ref, computed, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Tooltip from '@/Components/Tooltip.vue';
import Swal from 'sweetalert2';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Pagination from '@/Components/Pagination.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import SuccessButton from '@/Components/SuccessButton.vue';
import Icon from '@/Components/Icon.vue';
import ActionButton from '@/Components/ActionButton.vue';

const props = defineProps({
    purchaseOrders: Array,
});

const form = useForm({});

const title = 'Purchase Order';
const breadcrumbs = [
    { name: 'Home', href: route('dashboard') },
    { name: title, href: '#' },
];
const columns = [
    { name: 'supplier_id', label: 'Supplier' },
    { name: 'user_id', label: 'User' },
    { name: 'order_date', label: 'Order Date' },
    { name: 'status', label: 'Status' },
    { name: 'total_amount', label: 'Total Amount' },
];
const perPageOptions = [10, 25, 50, 100];
const perPage = ref(perPageOptions[0]);
const currentPage = ref(1);
const searchQuery = ref('');
const sortKey = ref('');
const sortOrder = ref('');
const uniqueKey = ref(0);

// Filtered and ordered purchaseOrders based on search query and sort parameters
const filteredProducts = computed(() => {
    return searchQuery.value
        ? props.purchaseOrders.filter((purchaseOrder) =>
            purchaseOrder.purchaseOrder_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            purchaseOrder.contact_name.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
        : props.purchaseOrders;
});

const orderedProducts = computed(() => {
    return [...filteredProducts.value].sort((a, b) => {
        let modifier = sortOrder.value === 'asc' ? 1 : -1;
        if (a[sortKey.value] < b[sortKey.value]) return -1 * modifier;
        if (a[sortKey.value] > b[sortKey.value]) return 1 * modifier;
        return 0;
    });
});

// Computed properties for pagination
const totalItems = computed(() => orderedProducts.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return orderedProducts.value.slice(start, end);
});

// Item range display
const startItemIndex = computed(() => (currentPage.value - 1) * perPage.value + 1);
const endItemIndex = computed(() => Math.min(currentPage.value * perPage.value, totalItems.value));

// Change page handlers
const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value += 1;
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value -= 1;
    }
};

// Sort key setter
const setSortKey = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
    uniqueKey.value++;
};

// Watchers to reset the page and force re-render when filters change
watch([perPage, searchQuery], () => {
    currentPage.value = 1;
    uniqueKey.value++;
});

// Delete purchaseOrder with confirmation
const deleteAction = async (id) => {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    });

    if (result.isConfirmed) {
        uniqueKey.value++;
        form.delete(route("purchaseOrders.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :title="title">
        <template #header>
            <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        </template>

        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <SuccessButton :href="route('purchase-orders.create')">
                <Icon name="plus" class="mr-2" />
                Tambah
            </SuccessButton>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto">
            <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                <div class="flex items-center space-x-2">
                    <select id="perPage" v-model="perPage"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-auto p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option :value="option" v-for="option in perPageOptions" :key="'perPage-' + option">
                            {{ option }}
                        </option>
                    </select>
                    <label for="perPage" class="block text-sm font-medium text-gray-900 dark:text-white">
                        entries per page
                    </label>
                </div>
                <div class="relative">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" v-model="searchQuery"
                        class="block p-1.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items">
                </div>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th v-for="(column, key) in columns" :key="key" scope="col"
                        class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                        @click="setSortKey(column.name)">
                        <div class="flex items-center justify-between">
                            {{ column.label }}
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    :class="{ 'text-black dark:text-white': sortKey === column.name && sortOrder === 'asc', 'text-gray-500 dark:text-gray-400': !(sortKey === column.name && sortOrder === 'asc') }"
                                    d="M12.832 3.445a1 1 0 0 0-1.664 0l-4 6A1 1 0 0 0 8 11h8a1 1 0 0 0 .832-1.555l-4-6Z" />
                                <path
                                    :class="{ 'text-black dark:text-white': sortKey === column.name && sortOrder === 'desc', 'text-gray-500 dark:text-gray-400': !(sortKey === column.name && sortOrder === 'desc') }"
                                    d="M11.168 20.555a1 1 0 0 0 1.664 0l4-6A1 1 0 0 0 16 13H8a1 1 0 0 0-.832 1.555l4 6Z" />
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody :key="uniqueKey">
                <tr v-for="(item, index) in paginatedProducts" :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-4 py-2">
                        {{ item.supplier.supplier_name }}
                    </td>
                    <td class="px-4 py-2">
                        {{ item.user.name }}
                    </td>
                    <td class="px-4 py-2">
                        {{ item.order_date }}
                    </td>
                    <td class="px-4 py-2">
                        {{ item.status }}
                    </td>
                    <td class="px-4 py-2">
                        {{ item.total_amount }}
                    </td>
                    <td class="m-0 p-0">
                        <div class="inline-flex rounded-md mt-1">
                            <!-- Show Button -->
                            <ActionButton color="cyan" :href="route('purchase-orders.show', item.id)"
                                :data-tooltip-target="`tooltip-edit-${item.id}`" class="rounded-s hidden">
                                <Icon name="info" class="w-4 h-4" />
                            </ActionButton>
                            <Tooltip :id="`tooltip-show-${item.id}`">Show</Tooltip>
                            <!-- Edit Button -->
                            <ActionButton color="yellow" :href="route('purchase-orders.edit', item.id)"
                                :data-tooltip-target="`tooltip-edit-${item.id}`" class="rounded-s">
                                <Icon name="pencil" class="w-4 h-4" />
                            </ActionButton>
                            <Tooltip :id="`tooltip-edit-${item.id}`">Edit</Tooltip>
                            <!-- Delete Button -->
                            <ActionButton color="red" @click.prevent="deleteAction(item.id)"
                                :data-tooltip-target="`tooltip-delete-${item.id}`" class="rounded-e">
                                <Icon name="close" class="w-4 h-4" />
                            </ActionButton>
                            <Tooltip :id="`tooltip-delete-${item.id}`">Delete</Tooltip>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <Pagination :currentPage="currentPage" :totalPages="totalPages" :startItemIndex="startItemIndex"
            :endItemIndex="endItemIndex" :totalItems="totalItems" @changePage="changePage" @nextPage="nextPage"
            @prevPage="prevPage" />
    </AppLayout>
</template>

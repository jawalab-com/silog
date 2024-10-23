<script setup>
// Created by: Ariefan Dipokusumo Wibowo, last update 2024-09-20

import { ref, computed, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Pagination, SortIcon, Icon } from '@/Components';
import { FwbInput } from 'flowbite-vue';

const props = defineProps({
    data: Array,
    columns: Array,
});

const perPageOptions = [10, 25, 50, 100];
const perPage = ref(perPageOptions[0]);
const currentPage = ref(1);
const q = ref('');
const sortKey = ref('');
const sortOrder = ref('');

const filteredData = computed(() => {
    return q.value
        ? props.data.filter((item) =>
            Object.values(item).some(value =>
                String(value).toLowerCase().includes(q.value.toLowerCase())
            )
        )
        : props.data;
});

const orderedData = computed(() => {
    return [...filteredData.value].sort((a, b) => {
        let modifier = sortOrder.value === 'asc' ? 1 : -1;
        if (a[sortKey.value] < b[sortKey.value]) return -1 * modifier;
        if (a[sortKey.value] > b[sortKey.value]) return 1 * modifier;
        return 0;
    });
});

// Computed properties for pagination
const totalItems = computed(() => orderedData.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return orderedData.value.slice(start, end);
});

// Sort key setter
const setSortKey = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
};
</script>

<template>
    <!-- Table -->
    <div class="relative overflow-x-auto">
        <div class="flex flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-2">
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
                <fwb-input placeholder="Search" size="sm" id="table-search" v-model="q">
                    <template #prefix>
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </template>
                    <template #suffix>
                        <Icon name="close"
                            class="w-5 h-5 text-gray-500 hover:text-gray-700 hover:dark:text-gray-300 active:text-gray-400 active:dark:text-gray-600"
                            @click="q = ''" />
                    </template>
                </fwb-input>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto overflow-y-hidden shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th v-for="(column, key) in columns" :key="key" scope="col"
                        class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                        :class="`text-${column?.align || 'left'}`" @click="setSortKey(column.name)">
                        <div class="flex items-center justify-between">
                            {{ column.label }}
                            <SortIcon :sortKey="sortKey" :sortOrder="sortOrder" :columnName="column.name" />
                        </div>
                    </th>
                    <th scope="col"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 text-right">
                        <!-- Action -->
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in paginatedData" :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <slot name="tbodyTd" :item="item" :columns="columns" :index="index">
                        <template v-for="(column, key) in columns" :key="key">
                            <td class="px-4 py-3" :class="`text-${column.align || 'left'}`">
                                {{ item[column.name] }}
                            </td>
                        </template>
                    </slot>
                    <td class="py-0 px-4 text-right">
                        <slot name="actionColumn" :item="item" :columns="columns" :index="index"></slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <Pagination v-model="currentPage" :per-page="perPage" :total-items="totalItems" :total-pages="totalPages"
        :show-labels="false" show-icons />
</template>

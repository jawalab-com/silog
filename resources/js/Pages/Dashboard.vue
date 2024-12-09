<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <!-- <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2> -->
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">6969</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total hutang (belum lunas)</dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">6969</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan belum selesai</dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">6969</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan yang sudah selesai
                    </dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">6969</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total Pengajuan yang digunakan untuk
                        bulan ini</dd>
                </div>
            </div>
        </div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4">
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
        </div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4"></div>
        <div class="grid grid-cols-2 gap-4">
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
            <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72">
            </div>
        </div>
    </AppLayout>
</template>

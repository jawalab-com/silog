<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Alert from '@/Components/Alert.vue';
import Navbar from '@/Components/Navbar.vue';
import Sidebar from '@/Components/Sidebar.vue';

const props = defineProps({
    title: String,
});

const page = usePage();
const alert = computed(() => page.props.alert);
</script>

<template>
    <div>

        <Head :title="title" />
        <div class="antialiased bg-gray-50 dark:bg-gray-900">

            <!-- Navbar -->
            <Navbar />

            <!-- Sidebar -->
            <Sidebar />

            <!-- Page Heading -->
            <header v-if="$slots.header" class="pt-14 md:ml-52">
                <div class="max-w mx-auto py-3 px-4">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="px-4 md:ml-52 h-auto min-h-screen" :class="{ 'pt-16': !$slots.header }">
                <Alert :alert="alert" />
                <slot />
            </main>
        </div>
    </div>
</template>

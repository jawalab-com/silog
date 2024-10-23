<script setup>
const props = defineProps({
    alert: {
        type: Object,
        default: () => ({ success: null, error: null, info: null, warning: null }),
    },
});

</script>

<template>
    <div id="alert" v-if="alert.success || alert.error || alert.info || alert.warning"
        class="flex items-center p-4 mb-4 text-sm rounded-lg border" :class="{
            'text-green-800 border-green-300 bg-green-50 dark:bg-green-950 dark:text-green-400 dark:border -green-800': alert.success,
            'text-red-800 border-red-300 bg-red-50 dark:bg-red-950 dark:text-red-400 dark:border-red-800': alert.error,
            'text-blue-800 border-blue-300 bg-blue-50 dark:bg-blue-950 dark:text-blue-400 dark:border-blue-800': alert.info,
            'text-yellow-800 border-yellow-300 bg-yellow-50 dark:bg-yellow-950 dark:text-yellow-400 dark:border-yellow-800': alert.warning,
        }" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Alert</span>
        <div>
            <span v-if="alert.success">{{ alert.success }}</span>
            <span v-else-if="alert.error">{{ alert.error }}</span>
            <span v-else-if="alert.info">{{ alert.info }}</span>
            <span v-else-if="alert.warning">{{ alert.warning }}</span>
        </div>
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8"
            :class="{
                'bg-green-50 text-green-500 focus:ring-green-400 hover:bg-green-200 dark:bg-green-950 dark:text-green-400 dark:hover:bg-green-700': alert.success,
                'bg-red-50 text-red-500 focus:ring-red-400 hover:bg-red-200 dark:bg-red-950 dark:text-red-400 dark:hover:bg-red-700': alert.error,
                'bg-blue-50 text-blue-500 focus:ring-blue-400 hover:bg-blue-200 dark:bg-blue-950 dark:text-blue-400 dark:hover:bg-blue-700': alert.info,
                'bg-yellow-50 text-yellow-500 focus:ring-yellow-400 hover:bg-yellow-200 dark:bg-yellow-950 dark:text-yellow-400 dark:hover:bg-yellow-700': alert.warning,
            }" data-dismiss-target="#alert" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</template>

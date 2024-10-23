<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
    sortKey: {
        type: String,
        required: true
    },
    sortOrder: {
        type: String,
        required: true
    },
    columnName: {
        type: String,
        required: true
    }
})

const isSortedAsc = computed(() => props.sortKey === props.columnName && props.sortOrder === 'asc')
const isSortedDesc = computed(() => props.sortKey === props.columnName && props.sortOrder === 'desc')
</script>

<template>
    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="currentColor" viewBox="0 0 24 24">
        <path :class="{
            'text-black dark:text-white': isSortedAsc,
            'text-gray-400': !isSortedAsc
        }" d="M12.832 3.445a1 1 0 0 0-1.664 0l-4 6A1 1 0 0 0 8 11h8a1 1 0 0 0 .832-1.555l-4-6Z" />
        <path :class="{
            'text-black dark:text-white': isSortedDesc,
            'text-gray-400': !isSortedDesc
        }" d="M11.168 20.555a1 1 0 0 0 1.664 0l4-6A1 1 0 0 0 16 13H8a1 1 0 0 0-.832 1.555l4 6Z" />
    </svg>
</template>

<style scoped></style>

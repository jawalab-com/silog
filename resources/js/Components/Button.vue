<script setup>
import { FwbButton } from 'flowbite-vue';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    class: '',
    color: 'default',
    gradient: null,
    size: 'md',
    shadow: null,
    pill: false,
    square: false,
    outline: false,
    loading: false,
    loadingPosition: 'prefix',
    disabled: false,
    href: '',
    tag: 'span',
});

const colorClasses = {
    red: 'bg-red-800 dark:bg-red-200 text-red-200 dark:text-red-800 hover:bg-red-700 dark:hover:bg-red-100 focus:bg-red-700 dark:focus:bg-red-100 active:bg-red-900 dark:active:bg-red-300 focus:ring-red-500 dark:focus:ring-offset-red-800',
    blue: 'bg-blue-800 dark:bg-blue-200 text-blue-200 dark:text-blue-800 hover:bg-blue-700 dark:hover:bg-blue-100 focus:bg-blue-700 dark:focus:bg-blue-100 active:bg-blue-900 dark:active:bg-blue-300 focus:ring-blue-500 dark:focus:ring-offset-blue-800',
    green: 'bg-green-800 dark:bg-green-200 text-green-200 dark:text-green-800 hover:bg-green-700 dark:hover:bg-green-100 focus:bg-green-700 dark:focus:bg-green-100 active:bg-green-900 dark:active:bg-green-300 focus:ring-green-500 dark:focus:ring-offset-green-800',
    yellow: 'bg-yellow-800 dark:bg-yellow-200 text-yellow-200 dark:text-yellow-800 hover:bg-yellow-700 dark:hover:bg-yellow-100 focus:bg-yellow-700 dark:focus:bg-yellow-100 active:bg-yellow-900 dark:active:bg-yellow-300 focus:ring-yellow-500 dark:focus:ring-offset-yellow-800',
    purple: 'bg-purple-800 dark:bg-purple-200 text-purple-200 dark:text-purple-800 hover:bg-purple-700 dark:hover:bg-purple-100 focus:bg-purple-700 dark:focus:bg-purple-100 active:bg-purple-900 dark:active:bg-purple-300 focus:ring-purple-500 dark:focus:ring-offset-purple-800',
    gray: 'bg-gray-800 dark:bg-gray-200 text-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-gray-100 focus:bg-gray-700 dark:focus:bg-gray-100 active:bg-gray-900 dark:active:bg-gray-300 focus:ring-gray-500 dark:focus:ring-offset-gray-800',
    default: 'bg-default-800 dark:bg-default-200 text-default-200 dark:text-default-800 hover:bg-default-700 dark:hover:bg-default-100 focus:bg-default-700 dark:focus:bg-default-100 active:bg-default-900 dark:active:bg-default-300 focus:ring-default-500 dark:focus:ring-offset-default-800',
};

const buttonClasses = computed(() => {
    const colorClass = colorClasses[props.color] || colorClasses.default;
    return `
        inline-flex
        items-center
        px-3
        py-2
        border
        border-transparent
        rounded-full
        font-semibold
        text-xs
        ${colorClass}
        focus:outline-none
        focus:ring-2
        focus:ring-offset-2
        disabled:opacity-50
        transition
        ease-in-out
        duration-150
        ` + props.class;
});
</script>

<template>
    <!-- <Link v-if="href"> -->
    <fwb-button :class="buttonClasses" :color="color" :gradient="gradient" :size="size" :shadow="shadow" :pill="pill"
        :square="square" :outline="outline" :loading="loading" :loading-position="loadingPosition" :disabled="disabled"
        :tag="tag" @click="href ? $inertia.visit(href) : () => { }">
        <template #prefix>
            <slot v-if="$slots.prefix" name="prefix" />
        </template>
        <slot />
        <template #suffix>
            <slot v-if="$slots.suffix" name="suffix" />
        </template>
    </fwb-button>
</template>

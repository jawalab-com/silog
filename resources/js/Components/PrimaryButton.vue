<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    href: String,
});

const goto = (url) => router.visit(url);
</script>

<template>
    <button @click="href ? goto(router.visit(href)) : ''" :type="type" class="
        inline-flex
        items-center
        px-4
        py-2
        bg-primary-800
        dark:bg-primary-200
        border
        border-transparent
        rounded-full
        font-semibold
        text-xs
        text-white
        dark:text-primary-800
        hover:bg-primary-700
        dark:hover:bg-primary-100
        focus:bg-primary-700
        dark:focus:bg-primary-100
        active:bg-primary-900
        dark:active:bg-primary-300
        focus:outline-none
        focus:ring-2
        focus:ring-primary-500
        focus:ring-offset-2
        dark:focus:ring-offset-primary-800
        disabled:opacity-50
        transition
        ease-in-out
        duration-150
    ">
        <slot />
    </button>
</template>

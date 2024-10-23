<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
    type: {
        type: String,
        default: 'button',
    },
    href: String,
});

const goto = (url) => router.visit(url);
</script>

<template>
    <button @click="href ? goto(router.visit(href)) : ''" :type="type" class="
        inline-flex
        items-center
        justify-center
        px-4
        py-2
        bg-red-600
        border
        border-transparent
        rounded-full
        font-semibold
        text-xs
        text-white
        uppercase
        tracking-widest
        hover:bg-red-500
        active:bg-red-700
        focus:outline-none
        focus:ring-2
        focus:ring-red-500
        focus:ring-offset-2
        dark:focus:ring-offset-gray-800
        transition
        ease-in-out
        duration-150
    ">
        <slot />
    </button>
</template>

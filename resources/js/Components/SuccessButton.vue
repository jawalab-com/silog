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
    <button @click="href ? goto(href) : ''" :type="type" class="
        inline-flex
        items-center
        px-4
        py-2
        bg-green-800
        dark:bg-green-200
        border
        border-transparent
        rounded-full
        font-semibold
        text-xs
        text-white
        dark:text-green-800
        hover:bg-green-700
        dark:hover:bg-green-100
        focus:bg-green-700
        dark:focus:bg-green-100
        active:bg-green-900
        dark:active:bg-green-300
        focus:outline-none
        focus:ring-2
        focus:ring-green-500
        focus:ring-offset-2
        dark:focus:ring-offset-green-800
        disabled:opacity-50
        transition
        ease-in-out
        duration-150
    ">
        <slot />
    </button :is="clickable ? 'a' : 'div'">
</template>

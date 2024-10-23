<script setup>
defineProps({});
</script>

<template>
    <div role="tooltip" class="
        absolute
        z-10
        invisible
        inline-block
        px-3
        py-2
        text-sm
        font-medium
        text-white
        transition-opacity
        duration-300
        bg-gray-700
        rounded-lg
        shadow-sm
        opacity-0
        tooltip
        dark:bg-gray-900
    ">
        <slot />
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</template>

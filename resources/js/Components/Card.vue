<script setup>
const props = defineProps({
    clickable: {
        type: Boolean,
        default: false,
    },
    href: {
        type: String,
        default: '#',
    },
});

const baseClasses =
    'block max-w-7xl mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700';
const hoverClasses = 'hover:bg-gray-100 dark:hover:bg-gray-700';
const classes = props.clickable ? `${baseClasses} ${hoverClasses}` : baseClasses;
</script>

<template>
    <component :is="clickable ? 'a' : 'div'" :class="classes" v-bind="clickable ? { href } : {}">
        <!-- Header Slot -->
        <template v-if="$slots.header">
            <div class="card-header px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <slot name="header" />
            </div>
        </template>

        <!-- Default Slot for Main Content -->
        <div class="card-body p-4">
            <slot />
        </div>

        <!-- Footer Slot -->
        <template v-if="$slots.footer">
            <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                <slot name="footer" />
            </div>
        </template>
    </component>
</template>

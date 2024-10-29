<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: [String, Number],
});

defineEmits(['update:modelValue']);

</script>

<template>
    <select :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="
        bg-gray-50
        border
        border-gray-300
        text-gray-900
        rounded-md
        focus:ring-primary-500
        focus:border-primary-500
        block
        w-full
        dark:bg-gray-900
        dark:border-gray-700
        dark:placeholder-gray-400
        dark:text-gray-100
        dark:focus:ring-primary-600
        dark:focus:border-primary-600">
        <slot />
    </select>
</template>

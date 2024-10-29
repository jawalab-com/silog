<template>
    <div class="relative w-full" @keydown.down.prevent="onArrowDown" @keydown.up.prevent="onArrowUp"
        @keydown.enter.prevent="onEnter" ref="autocomplete">
        <div class="flex">
            <!-- Input field -->
            <input type="text" :value="displayLabel" @input="onInput($event.target.value)" :placeholder="placeholder"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full
                dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-100 dark:focus:ring-primary-600 dark:focus:border-primary-600"
                @focus="showDropdown" ref="textInput" />
        </div>

        <!-- Dropdown button with hover effect -->
        <!-- <button type="button" @click="onButtonClick"
                class="bg-gray-300 border border-gray-300 text-gray-900 px-2 rounded-r-md focus:outline-none hover:bg-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                &#x25BC;
            </button> -->

        <!-- Dropdown suggestions list -->
        <ul v-if="isDropdownVisible && suggestions.length"
            class="absolute w-full bg-white border border-gray-300 rounded-md mt-1 z-10">
            <template v-for="(suggestion, index) in suggestions.slice(0, 10)" :key="index">
                <slot name="suggestion-item" :suggestion="suggestion" :highlighted="index === highlightedIndex"
                    @click="selectSuggestion(suggestion)" @mousedown="selectSuggestion(suggestion)">
                    <!-- Default rendering if no slot provided -->
                    <li @click="selectSuggestion(suggestion)" @mousedown="selectSuggestion(suggestion)"
                        :class="['cursor-pointer px-4 py-2 hover:bg-gray-100', { 'bg-gray-200': index === highlightedIndex }]">
                        {{ suggestion.label }}
                    </li>
                </slot>
            </template>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { debounce } from 'lodash';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    apiUrl: {
        type: String,
        default: '/api/products/suggestions'
    },
    debounceTime: {
        type: Number,
        default: 300
    },
    placeholder: {
        type: String,
        default: 'Search...'
    },
    label: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue', 'update:label']);

const query = ref('');
const selectedValue = ref(props.modelValue);
const selectedLabel = ref(props.label);
const displayLabel = ref(selectedLabel.value);
const suggestions = ref([]);
const isDropdownVisible = ref(false);
const highlightedIndex = ref(-1);

// Watch for changes to modelValue
watch(() => props.modelValue, (newValue) => {
    selectedValue.value = newValue;
    const selectedSuggestion = suggestions.value.find(suggestion => suggestion.value === newValue);
    selectedLabel.value = selectedSuggestion ? selectedSuggestion.label : '';
    displayLabel.value = selectedLabel.value || query.value;
});

// Fetch suggestions
const searchSuggestions = async () => {
    const response = await fetch(`${props.apiUrl}?q=${query.value}`);
    const data = await response.json();
    suggestions.value = data;
    highlightedIndex.value = -1;
};

// Debounced search
const debouncedSearch = debounce(searchSuggestions, props.debounceTime);

// Handle input change
const onInput = (value) => {
    query.value = value;
    displayLabel.value = value;
    selectedValue.value = '';
    selectedLabel.value = '';
    emit('update:modelValue', '');  // Clear value
    emit('update:label', '');  // Clear label
    isDropdownVisible.value = true;
    debouncedSearch();
};

// Select a suggestion
const selectSuggestion = (suggestion) => {
    selectedValue.value = suggestion.value;
    selectedLabel.value = suggestion.label;
    displayLabel.value = selectedLabel.value;
    emit('update:modelValue', selectedValue.value);
    emit('update:label', selectedLabel.value);
    isDropdownVisible.value = false;
};

// Show dropdown on button click and focus on the input
const onButtonClick = () => {
    if (!isDropdownVisible.value) {
        // Focus on the input field
        textInput.value.focus();
        // If no keyword typed, fetch suggestions with empty query
        if (query.value.length === 0) {
            searchSuggestions();
        }
        isDropdownVisible.value = true;
    } else {
        isDropdownVisible.value = false;
    }
};

// Show dropdown on input focus
const showDropdown = () => {
    isDropdownVisible.value = true;
};

// Hide dropdown when clicking outside
const hideDropdownOnOutsideClick = (event) => {
    if (!autocomplete.value.contains(event.target)) {
        isDropdownVisible.value = false;
    }
};

// Add click event listener to detect clicks outside component
const autocomplete = ref(null);
const textInput = ref(null);
onMounted(() => {
    document.addEventListener('click', hideDropdownOnOutsideClick);
});

// Remove click event listener when component is unmounted
onBeforeUnmount(() => {
    document.removeEventListener('click', hideDropdownOnOutsideClick);
});

// Handle arrow down key
const onArrowDown = () => {
    if (highlightedIndex.value < suggestions.value.length - 1) {
        highlightedIndex.value++;
    } else {
        highlightedIndex.value = 0;
    }
};

// Handle arrow up key
const onArrowUp = () => {
    if (highlightedIndex.value > 0) {
        highlightedIndex.value--;
    } else {
        highlightedIndex.value = suggestions.value.length - 1;
    }
};

// Handle enter key
const onEnter = () => {
    if (highlightedIndex.value !== -1 && suggestions.value[highlightedIndex.value]) {
        selectSuggestion(suggestions.value[highlightedIndex.value]);
    }
};
</script>

<style scoped>
/* Tailwind CSS already applies most of the styling, including hover states for the button */
</style>

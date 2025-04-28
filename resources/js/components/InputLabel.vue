<script setup>
defineProps({
    value: {
        type: String,
    },
    isRequired: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
        <span v-if="value">{{ value  }} <span class="text-red-500">{{ isRequired ? '*' : '' }}</span></span>
        <span v-else><slot /></span>
    </label>
</template>

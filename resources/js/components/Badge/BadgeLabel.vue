<script setup lang="ts">
const props = defineProps(['type'])

let type = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';

switch (props.type) {
    case 'red':
        type = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        break;
    case 'green':
        type = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        break;
    default:
        break;
}
</script>

<template>
    <span :class="type" class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">
        <slot></slot>
    </span>
</template>


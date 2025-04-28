<template>
    <!-- absolute h-full left-0 top-0 w-full bg-white bg-opacity-70 -->
    <div :class="`flex justify-center items-center overflow-hidden ${overlay ? 'absolute h-full left-0 top-0 w-full bg-white bg-opacity-70' : ''}`">
        <div :class="`border-gray-300 h-${height} w-${width} animate-spin rounded-full border-8 border-t-blue-600`"></div>
    </div>
</template>

<script setup>
defineProps({
    height: {
        type: String,
        default: '25',
    },
    width: {
        type: String,
        default: '25',
    },
    overlay: {
        type: Boolean,
        default: false,
    },
});
</script>

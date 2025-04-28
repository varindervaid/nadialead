<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <input
        class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white"
        v-model="model"
        ref="input"
    />
</template>

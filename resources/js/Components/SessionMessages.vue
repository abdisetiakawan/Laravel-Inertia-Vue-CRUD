<script setup>
defineProps({
    status: String,
});
</script>

<template>
    <div
        v-if="status"
        class="text-bold mb-3 text-gray-800 dark:text-gray-200 border border-green-500 dark:border-green-300 rounded-lg p-3 bg-gray-50 dark:bg-gray-800"
    >
        {{ status }}
    </div>
</template>

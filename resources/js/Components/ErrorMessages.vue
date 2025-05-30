<script setup>
defineProps({
    errors: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <div class="mb-4" v-if="Object.keys(errors).length">
        <p class="text-sm text-red-500">Something went wrong!</p>
        <ul class="list-disc ml-4 list-inside">
            <li
                v-for="(error, index) in errors"
                :key="index"
                class="text-sm text-red-500"
            >
                {{ error }}
            </li>
        </ul>
    </div>
</template>

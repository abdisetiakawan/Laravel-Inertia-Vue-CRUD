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
        <ul class="list-disc pl-5">
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

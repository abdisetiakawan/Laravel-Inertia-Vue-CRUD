<script setup>
import UpdateInfo from "./Sections/UpdateInfo.vue";
import UpdatePassword from "./Sections/UpdatePassword.vue";
defineProps({
    user: Object,
    info_status: {
        type: String,
        default: null,
    },
    password_status: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <Head title="- Profile" />
    <UpdateInfo :user="user" :status="info_status" />
    <UpdatePassword :status="password_status" />
</template>

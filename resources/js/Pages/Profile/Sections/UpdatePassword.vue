<script setup>
import { useForm } from "@inertiajs/vue3";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});
const submitPasswordUpdate = () => {
    form.put(route("profile.password"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
    });
};
const props = defineProps({
    status: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <Container class="mb-8">
        <div class="mb-6">
            <h2 class="text-lg font-medium">Update Password</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's password.
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form @submit.prevent="submitPasswordUpdate" class="space-y-6">
            <InputField
                label="Current Password"
                type="password"
                icon="lock"
                v-model="form.current_password"
            />
            <InputField
                label="New Password"
                type="password"
                icon="lock"
                v-model="form.password"
            />
            <InputField
                label="Confirm New Password"
                type="password"
                icon="lock"
                v-model="form.password_confirmation"
            />
            <SessionMessages :status="props.status" />
            <PrimaryButton>Save</PrimaryButton>
        </form>
    </Container>
</template>

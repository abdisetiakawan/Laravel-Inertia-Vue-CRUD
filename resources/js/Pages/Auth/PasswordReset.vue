<script setup>
import Container from "../../Components/Container.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
});

defineProps({ status: String });

const submit = () => {
    form.post(route("password.email"), {
        onFinish: () => form.reset("email"),
    });
};
</script>

<template>
    <Head title="- Forgot Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </p>
        </div>

        <!-- Errors messages -->
        <ErrorMessages :errors="form.errors" />

        <!-- Session messages -->
        <SessionMessages :status="status" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" v-model="form.email" />
            <PrimaryButton :disabled="form.processing"
                >Send Password Reset Link</PrimaryButton
            >
        </form>
    </Container>
</template>

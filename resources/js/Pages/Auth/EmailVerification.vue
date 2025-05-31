<script setup>
import { useForm } from "@inertiajs/vue3";
import Container from "../../Components/Container.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SessionMessages from "../../Components/SessionMessages.vue";

const form = useForm({});
const submit = () => {
    form.post(route("verification.resend"), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

defineProps({
    status: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <Head title="- Email Verification" />
    <Container class="bg-white dark:bg-gray-900">
        <div class="max-w-md mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-4">Email Verification</h1>
            <p class="mb-4">
                Please verify your email address to continue using the
                application.
            </p>
            <SessionMessages :status="status" />
            <form @submit.prevent="submit">
                <PrimaryButton :disabled="form.processing"
                    >Resend Verification Email</PrimaryButton
                >
            </form>
        </div>
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                If you did not receive the email, check your spam folder or try
                again in a few minutes.
            </p>
        </div>
    </Container>
</template>

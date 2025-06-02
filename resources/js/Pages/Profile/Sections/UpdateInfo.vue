<script setup>
import { router, useForm } from "@inertiajs/vue3";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
const props = defineProps({
    user: Object,
    status: {
        type: String,
        default: null,
    },
});
const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const resendEmail = (e) => {
    router.post(
        route("verification.resend"),
        {},
        {
            onStart: () => (e.target.disabled = true),
            onFinish: () => (e.target.disabled = false),
        }
    );
};
</script>

<template>
    <Container class="mb-8">
        <div class="mb-6">
            <h2 class="text-lg font-medium">Update Information</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="space-y-6"
        >
            <InputField
                label="Name"
                type="text"
                icon="user"
                v-model="form.name"
            />
            <InputField
                label="Email"
                type="email"
                icon="envelope"
                v-model="form.email"
            />
            <SessionMessages :status="props.status" />
            <div
                class="flex gap-2 items-center"
                v-if="!props.user.email_verified_at"
            >
                <p>Email is unverified.</p>
                <button
                    @click="resendEmail"
                    class="text-indigo-500 hover:text-indigo-600 font-medium underline dark:text-indigo-400 dark:hover:indigo-500 disabled:cursor-wait"
                >
                    Click here to re-send verification email
                </button>
            </div>
            <PrimaryButton>Save</PrimaryButton>
        </form>
    </Container>
</template>

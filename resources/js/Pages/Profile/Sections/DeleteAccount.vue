<script setup>
import { useForm } from "@inertiajs/vue3";
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import { ref } from "vue";
const showConfirmPassword = ref(false);
const form = useForm({
    password: "",
});
const deleteAccount = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Container class="mb-8">
        <div class="mb-6">
            <h2 class="text-lg font-medium">Delete Account</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once you delete your account, there is no going back. Please be
                certain.
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <div v-if="showConfirmPassword">
            <form @submit.prevent="deleteAccount" class="space-y-6">
                <InputField
                    label="Confirm Password"
                    type="password"
                    icon="lock"
                    class="w-1/2"
                    v-model="form.password"
                />
                <div class="space-x-2">
                    <PrimaryButton :disabled="form.processing"
                        >Confirm</PrimaryButton
                    >
                    <SecondaryButton
                        type="button"
                        @click="showConfirmPassword = false"
                        >Cancel</SecondaryButton
                    >
                </div>
            </form>
        </div>

        <button
            v-if="!showConfirmPassword"
            @click="showConfirmPassword = true"
            class="px-6 py-2 rounded-lg bg-red-500 text-white"
        >
            <i class="fa-solid fa-trash mr-2"></i>Delete Account
        </button>
    </Container>
</template>

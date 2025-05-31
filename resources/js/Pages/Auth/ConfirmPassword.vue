<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import CheckBox from "../../Components/CheckBox.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="- Password Confirm" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>
                Please confirm your password before continuing.
            </p>
        </div>

        <!-- Errors messages -->
        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Password"
                type="password"
                icon="key"
                v-model="form.password"
            />
            <PrimaryButton :disabled="form.processing">Login</PrimaryButton>
        </form>
    </Container>
</template>

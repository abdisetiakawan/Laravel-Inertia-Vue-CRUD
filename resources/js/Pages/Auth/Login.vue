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
    email: "",
    password: "",
    remember: null,
});

defineProps({ status: String });
const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="- Login" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p>
                Don't have an account?
                <TextLink routeName="register" label="Register" />
            </p>
        </div>

        <!-- Errors messages -->
        <ErrorMessages :errors="form.errors" />
        <!-- Session messages -->
        <SessionMessages :status="status" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" v-model="form.email" />
            <InputField
                label="Password"
                type="password"
                icon="key"
                v-model="form.password"
            />
            <div class="flex items-center justify-between">
                <CheckBox name="remember" v-model="form.remember">
                    Remember me
                </CheckBox>

                <TextLink
                    routeName="password.request"
                    label="Forgot Password?"
                />
            </div>
            <PrimaryButton :disabled="form.processing">Login</PrimaryButton>
        </form>
    </Container>
</template>

<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
</script>

<template>
    <Container class="w1/2 max-w-md mx-auto mt-12">
        <div class="mb-8 text-center">
            <Title>Register a new account</Title>
            <p>
                Already have an account?
                <TextLink routeName="home" label="Login" />
            </p>
        </div>

        <form class="space-y-6">
            <InputField label="Name" icon="id-badge" />
            <InputField label="Email" icon="envelope" type="email" />
            <InputField label="Password" icon="lock" type="password" />
            <InputField label="Confirm Password" icon="lock" type="password" />

            <p class="text-sm text-slate-600 dark:text-slate-400">
                By creating an account, you agree to our
                <TextLink routeName="home" label="Terms of Service" /> and
                <TextLink routeName="home" label="Privacy Policy" />
            </p>

            <PrimaryButton>Register</PrimaryButton>
        </form>
    </Container>
</template>

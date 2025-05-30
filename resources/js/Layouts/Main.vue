<script setup>
import { switchTheme } from "../theme";
import NavLink from "../Components/NavLink.vue";
</script>

<template>
    <header class="bg-slate-800 text-white">
        <nav
            class="p-6 mx-auto max-w-screen-lg flex justify-between items-center"
        >
            <NavLink routeName="home" componentName="Home">Home</NavLink>

            <div class="flex gap-2">
                <NavLink routeName="register" componentName="Auth/Register"
                    >Register</NavLink
                >
                <button
                    class="p-2 text-white bg-slate-700 hover:bg-slate-600 rounded-full"
                    @click="switchTheme"
                >
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>

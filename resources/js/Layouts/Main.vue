<script setup>
import { switchTheme } from "../theme";
</script>

<template>
    <header class="bg-slate-800 text-white">
        <nav
            class="p-6 mx-auto max-w-screen-lg flex justify-between items-center"
        >
            <Link :href="route('home')">Home</Link>
        </nav>

        <div>
            <button
                class="p-2 text-white bg-slate-700 hover:bg-slate-600 rounded-full fixed top-4 right-4"
                @click="switchTheme"
            >
                <i class="fa-solid fa-moon"></i>
            </button>
        </div>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>

<script setup>
import { switchTheme } from "../theme";
import NavLink from "../Components/NavLink.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const show = ref(false);
</script>

<template>
    <!-- overlay -->
    <div class="fixed inset-0 z-40" v-show="show" @click="show = false"></div>
    <header class="bg-slate-800 text-white">
        <nav
            class="p-6 mx-auto max-w-screen-lg flex justify-between items-center"
        >
            <NavLink routeName="home" componentName="Home">Home</NavLink>

            <div class="flex gap-2">
                <!-- Auth links -->
                <div v-if="user" class="relative">
                    <div
                        @click="show = !show"
                        class="flex gap-2 items-center px-3 py-1 rounded-lg cursor-pointer hover:bg-slate-700 transition-colors"
                    >
                        <p class="text-white">
                            {{ user.name }}
                        </p>
                        <i
                            class="fa-solid fa-angle-down transition-transform duration-200"
                            :class="{ 'rotate-90': show }"
                        ></i>
                    </div>

                    <!-- Dropdown -->
                    <div
                        v-show="show"
                        @click="show = false"
                        class="absolute z-50 top-12 right-0 bg-slate-700 text-white rounded-lg overflow-hidden w-40"
                    >
                        <Link
                            class="block w-full px-6 py-3 hover:bg-slate-800 text-left"
                            >Dashboard</Link
                        >
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="block w-full px-6 py-3 hover:bg-slate-800 text-left"
                            >Logout</Link
                        >
                    </div>
                </div>
                <!-- Guest links -->
                <div v-else class="flex gap-2">
                    <NavLink routeName="login" componentName="Auth/Login"
                        >Login</NavLink
                    >
                    <NavLink routeName="register" componentName="Auth/Register"
                        >Register</NavLink
                    >
                </div>
                <button
                    class="ml-2 p-2 text-white bg-slate-700 hover:bg-slate-600 rounded-full"
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

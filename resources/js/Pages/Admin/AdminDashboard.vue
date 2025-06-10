<script setup>
import PaginationLinks from "../../Components/PaginationLinks.vue";
import RoleSelect from "../../Components/RoleSelect.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import InputField from "../../Components/InputField.vue";
import { useForm, router } from "@inertiajs/vue3";

defineProps({ users: Object, status: String });

const params = route().params;
const form = useForm({
    search: params.search,
});

const search = () => {
    router.get(route("admin.index"), {
        search: form.search,
        user_role: params.user_role,
    });
};

const toggleRole = (e) => {
    if (e.target.checked) {
        router.get(
            route("admin.index", {
                search: form.search,
                user_role: "suspended",
            })
        );
    } else {
        router.get(
            route("admin.index", {
                search: form.search,
                user_role: null,
            })
        );
    }
};
</script>

<template>
    <Head title="- Admin" />

    <!-- Session Messages -->
    <SessionMessages :status="status" />
    <!-- Heading -->
    <div class="flex items-end justify-between mb-4">
        <div class="flex items-center gap-2">
            <!-- Search -->
            <form @submit.prevent="search">
                <InputField
                    label=""
                    icon="magnifying-glass"
                    placeholder="Search..."
                    v-model="form.search"
                />
            </form>
            <Link
                class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 dark:bg-slate-700 dark:hover:bg-slate-600"
                v-if="params.search"
                :href="
                    route('admin.index', {
                        ...params,
                        search: null,
                        page: null,
                    })
                "
                >{{ params.search }}
                <i class="fa-solid fa-xmark"></i>
            </Link>
        </div>
        <!-- Toggle role button -->
        <div
            class="flex items-center gap-1 text-xs hover:bg-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md"
        >
            <input
                @input="toggleRole"
                :checked="params.user_role"
                type="checkbox"
                id="toggle-role"
                class="cursor-pointer rounded-md border-1 outline-1 text-indigo-500 ring-indigo-500 border-slate-700"
            />
            <label
                for="toggle-role"
                class="cursor-pointer block text-sm font-medium text-slate-700 dark:text-slate-300"
            >
                Show suspended users
            </label>
        </div>
    </div>

    <!-- Table -->
    <table
        class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
    >
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                <th class="w-3/6 p-3">Name</th>
                <th class="w-2/6 p-3">Role</th>
                <th class="w-1/6 p-3">Listings</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="user in users.data" :key="user.id">
                <td class="w-3/6 py-5 px-3">
                    <p class="font-bold mb-1">{{ user.name }}</p>
                    <p class="font-light text-xs">{{ user.email }}</p>
                </td>

                <td class="w-2/6 py-5 px-3">
                    <RoleSelect :user="user" />
                </td>

                <td class="w-1/6 py-5 px-3">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1">
                            <p>
                                {{
                                    user.listings.filter((l) => l.is_approved)
                                        .length
                                }}
                            </p>
                            <i
                                class="fa-solid fa-circle-check text-green-400"
                            ></i>
                        </div>
                        <div class="flex items-center gap-1">
                            <p>
                                {{
                                    user.listings.filter((l) => !l.is_approved)
                                        .length
                                }}
                            </p>
                            <i
                                class="fa-solid fa-circle-xmark text-red-400"
                            ></i>
                        </div>
                    </div>
                </td>

                <td class="w-1/6 py-5 px-3 text-left">
                    <Link
                        class="fa-solid fa-up-right-from-square text-indigo-500 hover:text-indigo-600 dark:text-indigo-400 dark:hover:text-indigo-300"
                        :href="route('user.show', user.id)"
                    >
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLinks :paginator="users" />
    </div>
</template>

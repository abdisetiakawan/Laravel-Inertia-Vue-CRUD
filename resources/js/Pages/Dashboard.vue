<script setup>
import { Link, router } from "@inertiajs/vue3";
import Title from "../Components/Title.vue";
import PaginationLinks from "../Components/PaginationLinks.vue";
import SessionMessages from "../Components/SessionMessages.vue";
defineProps({
    listings: Object,
    status: String,
});

const deleteListing = (id) => {
    if (confirm("Are you sure you want to delete this listing?")) {
        router.delete(route("listings.destroy", id));
    }
};
</script>

<template>
    <Head title="- Dashboard" />
    <SessionMessages :status="status" />
    <div v-if="listings">
        <div v-if="Object.keys(listings.data).length">
            <div class="mb-6">
                <!-- Heading -->
                <div class="flex items-center justify-between mb-4">
                    <Title>Your Listings</Title>
                    <div class="flex items-center gap-4 text-xs">
                        <p>
                            Approved
                            <i
                                class="fa-solid fa-circle-check text-green-500"
                            ></i>
                        </p>
                        <p>
                            Pending Approval
                            <i
                                class="fa-solid fa-circle-xmark text-red-500"
                            ></i>
                        </p>
                    </div>
                </div>
                <!-- Listings Table -->
                <table
                    class="w-full table-fixed border-collapse overflow-hidden rounded-md text-sm ring-1 ring-slate-300 dark:ring-slate-600 bg-white shadow"
                >
                    <thead
                        class="bg-slate-300 text-xs uppercase text-slate-600 dark:text-slate-400 dark:bg-slate-900"
                    >
                        <tr>
                            <th class="w-3/4 p-3 text-left">Listing Title</th>
                            <th class="w-1/4 p-3 text-left">View</th>
                            <th class="w-1/5 p-3 text-left">Edit</th>
                            <th class="w-1/5 p-3 text-left">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-600 dark:border-slate-600"
                            v-for="listing in listings.data"
                            :key="listing.id"
                        >
                            <td class="w-3/4 p-3 text-left">
                                <div class="flex items-center gap-2">
                                    <img
                                        :src="
                                            listing.image
                                                ? `/storage/${listing.image}`
                                                : '/storage/images/listings/default.jpg'
                                        "
                                        alt=""
                                        class="h-10 w-10 rounded-full object-cover object-center"
                                    />
                                    <h4 class="font-bold">
                                        {{ listing.title }}
                                    </h4>
                                    <i
                                        :class="`fa-solid fa-${
                                            listing.is_approved
                                                ? 'circle-check'
                                                : 'circle-xmark'
                                        } text-${
                                            listing.is_approved
                                                ? 'green-500'
                                                : 'red-500'
                                        }`"
                                    ></i>
                                </div>
                            </td>
                            <td class="w-1/4 p-3 text-left">
                                <Link
                                    v-if="listing.is_approved"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline"
                                    :href="route('listings.show', listing.id)"
                                    >View</Link
                                >
                            </td>
                            <td class="w-1/5 p-3 text-left">
                                <Link
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline"
                                    :href="route('listings.edit', listing.id)"
                                    >Edit</Link
                                >
                            </td>
                            <td class="w-1/5 p-3 text-left">
                                <button
                                    class="text-red-600 dark:text-red-400 hover:underline"
                                    @click="deleteListing(listing.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <PaginationLinks :paginator="listings" class="mt-4" />
                </div>
            </div>
        </div>
        <div v-else>No listings available at the moment.</div>
    </div>
    <div v-else>
        Due to your account status, you cannot access this content.
    </div>
</template>

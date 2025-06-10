<script setup>
import Container from "../../Components/Container.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    listing: Object,
    user: Object,
    status: String,
    canUpdate: Boolean,
});

const deleteListing = () => {
    if (confirm("Are you sure you want to delete this listing?")) {
        router.delete(route("listings.destroy", props.listing.id), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const toggleApprove = () => {
    let msg = props.listing.is_approved
        ? "Are you sure you want to disapprove this listing?"
        : "Are you sure you want to approve this listing?";
    if (confirm(msg)) {
        router.put(route("admin.approve", props.listing.id));
    }
};
</script>

<template>
    <Head title="- Listing Detail" />
    <!-- Admin -->
    <div
        v-if="$page.props.auth.user.role === 'admin'"
        class="bg-slate-800 text-white mb-6 p-6 rounded-md font-medium flex items-center justify-between"
    >
        <p>
            This listing is
            {{ listing.is_approved ? "Approved" : "Disapproved" }}.
        </p>
        <button
            @click.prevent="toggleApprove"
            class="bg-slate-600 px-3 py-1 rounded-md"
        >
            {{ listing.is_approved ? "Disapprove it" : "Approve it" }}
        </button>
    </div>
    <Container class="flex gap-4">
        <div class="w-1/4 rounded-md overflow-hidden">
            <img
                :src="
                    listing.image
                        ? `/storage/${listing.image}`
                        : '/storage/images/listings/default.jpg'
                "
                class="w-full h-full object-cover object-center"
                alt=""
            />
        </div>

        <div class="w-3/4">
            <!-- Listing info -->
            <div class="mb-6">
                <SessionMessages :status="status" />
                <div class="flex items-end justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Listing detail</p>

                    <!-- Edit and delete buttons -->
                    <div class="pl-4 flex items-center gap-4" v-if="canUpdate">
                        <Link
                            class="bg-green-500 text-white rounded-md px-6 py-2 hover:outline outline-green-500 outline-offset-2"
                            :href="route('listings.edit', listing.id)"
                        >
                            Edit
                        </Link>
                        <button
                            class="bg-red-500 text-white rounded-md px-6 py-2 hover:outline outline-red-500 outline-offset-2"
                            @click="deleteListing"
                            type="button"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                <h3 class="font-bold text-2xl mb-4">{{ listing.title }}</h3>
                <p>{{ listing.desc }}</p>
            </div>

            <!-- Contact info -->
            <div class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Contact info</p>

                <!-- Email -->
                <div v-if="listing.email" class="flex items-center mb-2 gap-2">
                    <i class="fa-solid fa-at"></i>
                    <p>Email:</p>
                    <a :href="`mailto:${listing.email}`" class="text-link">
                        {{ listing.email }}
                    </a>
                </div>

                <!-- Link -->
                <div v-if="listing.link" class="flex items-center mb-2 gap-2">
                    <i class="fa-solid fa-up-right-from-square"></i>
                    <p>External Link:</p>
                    <a
                        :href="listing.link"
                        target="_blank"
                        class="text-link"
                        :title="listing.link"
                    >
                        {{
                            listing.link.length > 30
                                ? listing.link.slice(0, 35) + "..."
                                : listing.link
                        }}
                    </a>
                </div>

                <!-- User -->
                <div class="flex items-center mb-2 gap-2">
                    <i class="fa-solid fa-user"></i>
                    <p>Listed by:</p>
                    <Link
                        :href="route('home', { user_id: user.id })"
                        class="text-link"
                    >
                        {{ user.name }}
                    </Link>
                </div>
            </div>

            <!-- Tags -->
            <div v-if="listing.tags" class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Tags</p>

                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link
                            :href="route('home', { tag })"
                            class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900"
                        >
                            {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>

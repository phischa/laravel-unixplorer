<template>

    <Head :title="university.name" />

    <AppHeader />

    <div class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <Link href="/" class="text-sm text-blue-600 hover:underline">
            ← Back to list
        </Link>

        <!-- University Details -->
        <div class="mt-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ university.name }}</h1>
            <a :href="university.homepage ?? ''" target="_blank"
                class="mt-2 inline-block text-blue-600 hover:underline">
                {{ university.homepage }}
            </a>
        </div>

        <!-- Courses -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900">Courses Offered</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                <span v-for="course in university.courses" :key="course.id"
                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                    {{ course.name }}
                </span>
            </div>
        </div>

        <!-- Application Form -->
        <div class="mt-12 max-w-md">
            <h2 class="text-xl font-semibold text-gray-900">Apply to this University</h2>

            <!-- Success Message -->
            <div v-if="page.props.flash?.success" class="mt-4 rounded-lg bg-green-50 p-4 text-sm text-green-700">
                {{ page.props.flash.success }}
            </div>

            <form @submit.prevent="submitApplication" class="mt-4 space-y-4">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Name
                    </label>
                    <input id="name" v-model="form.name" type="text"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.name }" />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input id="email" v-model="form.email" type="email"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.email }" />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" :disabled="form.processing"
                    class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-50">
                    {{ form.processing ? 'Submitting...' : 'Submit Application' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppHeader from "@/Components/AppHeader.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import type { University, AppPageProps } from "@/types";

const props = defineProps<{
    university: University;
}>();

const page = usePage<AppPageProps>();

/**
 * Form state managed by Inertia's useForm helper
 */
const form = useForm({
    name: '',
    email: '',
});

/**
 * Submit the application form
 */
function submitApplication() {
    form.post(`/universities/${props.university.id}/apply`, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>
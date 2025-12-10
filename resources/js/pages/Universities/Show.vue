<template>

    <Head :title="university.name" />

    <AppHeader />

    <div class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <Link href="/" class="text-sm text-custom-purple dark:text-custom-light-purple hover:underline">
            ← Back to list
        </Link>

        <!-- University Details -->
        <div class="mt-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-dark-text">{{ university.name }}</h1>
            <a :href="university.homepage ?? ''" target="_blank"
                class="mt-2 inline-block text-blue-600 hover:underline dark:text-custom-light-purple">
                {{ university.homepage }}
            </a>
        </div>

        <!-- Courses -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-dark-text">Courses Offered</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                <span v-for="course in university.courses" :key="course.id"
                    class="rounded-xl bg-darker-powder px-3 py-1 text-sm text-gray-700 dark:bg-dark-surface dark:text-dark-text">
                    {{ course.name }}
                </span>
            </div>
        </div>

        <!-- Application Form -->
        <div class="mt-12 mb-8 max-w-md">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-dark-text">Apply to this University</h2>

            <!-- Success Message -->
            <div v-if="page.props.flash?.success" class="mt-4 rounded-xl bg-green-50 p-4 text-sm text-green-700">
                {{ page.props.flash.success }}
            </div>

            <form @submit.prevent="submitApplication" class="mt-4 space-y-4">
                <!-- Name Input -->
                <div>
                    <label for="name" class="ml-2 block text-sm font-medium text-gray-700 dark:text-dark-text">
                        Name
                    </label>
                    <input id="name" v-model="form.name" type="text" placeholder="Enter your name here"
                        class="mt-1 w-full rounded-xl shadow-md bg-white dark:bg-dark-surface px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:text-dark-text"
                        :class="{ 'border-red-500': form.errors.name }" />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="ml-2 block text-sm font-medium text-gray-700 dark:text-dark-text">
                        Email
                    </label>
                    <input id="email" v-model="form.email" type="email" placeholder="Enter your email address here"
                        class="mt-1 w-full rounded-xl shadow-md bg-white dark:bg-dark-surface px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:text-dark-text"
                        :class="{ 'border-red-500': form.errors.email }" />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" :disabled="form.processing"
                    class="mt-4 w-full rounded-xl bg-custom-purple px-4 py-2 text-sm font-semibold text-white hover:bg-custom-dark-purple disabled:opacity-50 cursor-pointer">
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

/**
 * Page props passed from Laravel controller
 */
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
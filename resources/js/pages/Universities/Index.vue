<template>

    <Head title="UniXplorer" />

    <AppHeader />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 px-4">
        <div class="min-w-0 flex-1">
            <h2
                class="text-2xl font-bold leading-7 text-gray-900 dark:text-dark-text sm:truncate sm:text-3xl sm:tracking-tight">
                Universities in Germany
            </h2>
        </div>

        <!-- Filters -->
        <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input v-model="filters.search" type="text" placeholder="Search by name..."
                    class="w-full bg-white dark:bg-dark-surface rounded-xl shadow-md px-4 py-2 text-sm text-gray-900 dark:text-dark-text placeholder-gray-400 dark:placeholder-dark-muted focus:border-[#6C4AFE] focus:ring-[#6C4AFE]" />
            </div>

            <!-- Course Filter -->
            <div class="sm:w-64">
                <select v-model="filters.course"
                    class="w-full bg-white dark:bg-dark-surface rounded-xl shadow-md px-4 py-2 text-sm text-gray-900 dark:text-dark-text focus:border-[#6C4AFE] focus:ring-[#6C4AFE]">
                    <option value="">All Courses</option>
                    <option v-for="course in courses" :key="course.id" :value="course.id">
                        {{ course.name }}
                    </option>
                </select>
            </div>

            <!-- Rating Checkbox -->
            <div class="flex items-center self-end sm:self-auto">
                <label
                    class="flex items-center gap-2 text-sm text-gray-700 dark:text-dark-text font-semibold cursor-pointer">
                    <input v-model="filters.rating" type="checkbox"
                        class="h-4 w-4 rounded border-[#6C4AFE] text-blue-600 focus:ring-blue-500 cursor-pointer" />
                    Rating ≥ 4
                </label>
            </div>
        </div>

        <!-- Desktop Table (hidden on mobile) -->
        <div v-if="universities.data.length > 0"
            class="mt-8 overflow-hidden rounded-xl shadow-lg dark:shadow-none hidden sm:block">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-dark-border dark:border dark:border-dark-surface table-fixed">
                <thead class="bg-darker-powder dark:bg-dark-surface">
                    <tr>
                        <th class="w-[62%] px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-dark-text">
                            Name
                        </th>
                        <th class="w-21%] px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-dark-text">
                            Website
                        </th>
                        <th class="w-[6%] px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-dark-text">
                            Courses
                        </th>
                        <th class="w-[11%] px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-dark-text">
                            Avg. Rating
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-dark-border bg-white dark:bg-dark-bg">
                    <tr v-for="university in universities.data" :key="university.id">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-dark-text">
                            <Link :href="`/universities/${university.id}`"
                                class="hover:text-blue-600 dark:hover:text-custom-purple hover:underline">
                                {{ university.name }}
                            </Link>
                        </td>
                        <td class="px-6 py-4 text-sm text-custom-purple dark:text-custom-light-purple">
                            <a :href="university.homepage ?? ''" target="_blank" class="hover:underline">
                                {{ university.homepage }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-center font-semibold text-gray-600 dark:text-dark-text">
                            {{ university.courses_count }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center font-semibold text-gray-600 dark:text-dark-text">
                            {{ university.courses_avg_rating?.toFixed(1) ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (hidden on desktop) -->
        <div v-if="universities.data.length > 0" class="mt-8 space-y-4 sm:hidden">
            <div v-for="university in universities.data" :key="university.id"
                class="rounded-xl shadow-lg dark:shadow-none bg-white dark:bg-dark-surface p-4">
                <Link :href="`/universities/${university.id}`"
                    class="hover:text-blue-600 dark:hover:text-custom-purple">
                    <h3 class="font-medium text-gray-900 dark:text-dark-text hover:underline">{{ university.name }}</h3>
                </Link>
                <a :href="university.homepage ?? ''" target="_blank"
                    class="mt-1 block text-sm text-custom-purple dark:text-custom-light-purple hover:underline truncate">
                    {{ university.homepage }}
                </a>
                <div class="mt-3 flex justify-between text-sm text-gray-500 dark:text-dark-text">
                    <span>{{ university.courses_count }} courses</span>
                    <span>Rating: {{ university.courses_avg_rating?.toFixed(1) ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="universities.data.length === 0" class="mt-8 text-center py-12">
            <p class="text-gray-500 dark:text-dark-muted">No universities found matching your criteria.</p>
            <button @click="clearFilters"
                class="bg-custom-purple hover:bg-custom-dark-purple text-white font-bold mt-4 py-2 px-4 rounded-full cursor-pointer">
                Clear filters
            </button>
        </div>

        <!-- Pagination -->
        <div v-if="universities.data.length > 0"
            class="mt-8 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-700 dark:text-dark-muted">
                Showing {{ universities.from }} to {{ universities.to }} of {{ universities.total }} universities
            </p>
            <nav class="flex flex-wrap gap-1">
                <Link v-for="link in universities.links" :key="link.label" :href="link.url ?? ''"
                    class="px-3 py-2 text-sm rounded-xl" :class="{
                        'bg-custom-purple text-white': link.active,
                        'bg-darker-powder dark:bg-dark-surface text-gray-900 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-border': !link.active && link.url,
                        'bg-gray-50 dark:bg-dark-bg text-gray-400 dark:text-dark-muted cursor-not-allowed': !link.url
                    }">
                    <span v-html="link.label"></span>
                </Link>
            </nav>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import AppHeader from "@/Components/AppHeader.vue";
import { reactive, watch } from "vue";
import type { PaginatedUniversities, Course, Filters } from "@/types";

/**
 * Page props passed from Laravel controller
 */
const props = defineProps<{
    universities: PaginatedUniversities;
    courses: Course[];
    filters: Filters;
}>();

/**
 * Reactive filter state initialized from server-side values
 */
const filters = reactive<Filters>({
    search: props.filters?.search ?? '',
    course: props.filters?.course ?? '',
    rating: props.filters?.rating ?? false,
});

/**
 * Watch for filter changes and reload page with new parameters
 */
watch(filters, (newFilters) => {
    router.get('/', newFilters, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}, { deep: true });

/**
 * Reset all filters to default values
 */
function clearFilters() {
    filters.search = '';
    filters.course = '';
    filters.rating = false;
}
</script>
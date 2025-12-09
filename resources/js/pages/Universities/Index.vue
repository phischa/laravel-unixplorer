<template>

    <Head title="UniXplorer" />

    <AppHeader />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 px-4">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Universities in Germany
            </h2>
        </div>

        <!-- Filters -->
        <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input v-model="filters.search" type="text" placeholder="Search by name..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <!-- Course Filter -->
            <div class="sm:w-64">
                <select v-model="filters.course"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Courses</option>
                    <option v-for="course in courses" :key="course.id" :value="course.id">
                        {{ course.name }}
                    </option>
                </select>
            </div>

            <!-- Rating Checkbox -->
            <div class="flex items-center self-end sm:self-auto">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input v-model="filters.rating" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                    Rating ≥ 4
                </label>
            </div>
        </div>

        <!-- Desktop Table (hidden on mobile) -->
        <div v-if="universities.data.length > 0"
            class="mt-8 overflow-hidden rounded-lg border border-gray-200 hidden sm:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Website
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Courses
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Avg. Rating
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="university in universities.data" :key="university.id">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <Link :href="`/universities/${university.id}`" class="hover:text-blue-600 hover:underline">
                                {{ university.name }}
                            </Link>
                        </td>
                        <td class="px-6 py-4 text-sm text-blue-600">
                            <a :href="university.homepage ?? ''" target="_blank" class="hover:underline">
                                {{ university.homepage }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ university.courses_count }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ university.courses_avg_rating?.toFixed(1) ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (hidden on desktop) -->
        <div v-if="universities.data.length > 0" class="mt-8 space-y-4 sm:hidden">
            <div v-for="university in universities.data" :key="university.id"
                class="rounded-lg border border-gray-200 bg-white p-4">
                <Link :href="`/universities/${university.id}`" class="hover:text-blue-600">
                    <h3 class="font-medium text-gray-900 hover:underline">{{ university.name }}</h3>
                </Link>
                <a :href="university.homepage ?? ''" target="_blank"
                    class="mt-1 block text-sm text-blue-600 hover:underline truncate">
                    {{ university.homepage }}
                </a>
                <div class="mt-3 flex justify-between text-sm text-gray-500">
                    <span>{{ university.courses_count }} courses</span>
                    <span>Rating: {{ university.courses_avg_rating?.toFixed(1) ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="universities.data.length === 0" class="mt-8 text-center py-12">
            <p class="text-gray-500">No universities found matching your criteria.</p>
            <button @click="clearFilters"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded-full cursor-pointer">
                Clear filters
            </button>
        </div>

        <!-- Pagination -->
        <div v-if="universities.data.length > 0"
            class="mt-4 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-700">
                Showing {{ universities.from }} to {{ universities.to }} of {{ universities.total }} universities
            </p>
            <nav class="flex flex-wrap gap-1">
                <Link v-for="link in universities.links" :key="link.label" :href="link.url ?? ''"
                    class="px-3 py-2 text-sm rounded-md" :class="{
                        'bg-blue-600 text-white': link.active,
                        'bg-gray-100 text-gray-700 hover:bg-gray-200': !link.active && link.url,
                        'bg-gray-50 text-gray-400 cursor-not-allowed': !link.url
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
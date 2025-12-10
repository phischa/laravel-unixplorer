<template>
    <header class="bg-light-powder dark:bg-dark-bg">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex flex-1">
                <div class="hidden lg:flex lg:gap-x-12">
                    <a v-for="item in navigation" :key="item.name" :href="item.href"
                        class="text-sm leading-6 font-semibold text-gray-900 dark:text-dark-text">{{
                            item.name
                        }}</a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 dark:text-dark-text"
                        @click="mobileMenuOpen = true">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
            </div>
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">UniXplorer</span>
                <span class="text-xl font-black text-custom-purple">UniXplorer</span>
            </a>
            <div class="flex flex-1 justify-end">
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode"
                    class="rounded-lg p-2 text-gray-700 hover:bg-dark-powder dark:text-dark-text dark:hover:bg-dark-surface cursor-pointer">
                    <SunIcon v-if="isDark" class="h-5 w-5" />
                    <MoonIcon v-else class="h-5 w-5" />
                </button>
            </div>
        </nav>
        <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-10" />
            <DialogPanel class="fixed inset-y-0 left-0 z-10 w-full overflow-y-auto bg-white dark:bg-dark-bg px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex flex-1">
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700 dark:text-dark-text"
                            @click="mobileMenuOpen = false">
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="sr-only">UniXplorer</span>
                        <span class="text-xl font-black text-custom-purple">UniXplorer</span>
                    </a>
                    <div class="flex flex-1 justify-end">
                        <button @click="toggleDarkMode"
                            class="rounded-lg p-2 text-gray-700 dark:text-dark-text cursor-pointer">
                            <SunIcon v-if="isDark" class="h-5 w-5" />
                            <MoonIcon v-else class="h-5 w-5" />
                        </button>
                    </div>
                </div>
                <div class="mt-6 space-y-2">
                    <a v-for="item in navigation" :key="item.name" :href="item.href"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base leading-7 font-semibold text-gray-900 dark:text-dark-text hover:bg-gray-50 dark:hover:bg-dark-surface">{{
                            item.name }}</a>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
</template>

<script setup lang="ts">
import { Dialog, DialogPanel } from '@headlessui/vue';
import { Bars3Icon, XMarkIcon, SunIcon, MoonIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

const navigation = [{ name: 'Universities', href: '/' }];
const mobileMenuOpen = ref(false);

const { isDark, toggleDarkMode } = useDarkMode();
</script>
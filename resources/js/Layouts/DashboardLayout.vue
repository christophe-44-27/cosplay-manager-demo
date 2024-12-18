<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const isUserMenuOpen = ref(false)

const navigationItems = [
    { name: 'Tableau de bord', href: '/dashboard' },
    { name: 'Mes projets', href: '/projects' },
    { name: 'La communauté', href: '/community' },
]

const userMenuItems = [
    { name: 'Mon compte', href: '/account' },
]
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-purple-50">
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationLogo
                                    class="block h-9 w-auto fill-current text-gray-800"
                                />
                            </Link>
                        </div>
                        <div class="hidden md:flex md:ml-6 space-x-8">
                            <Link
                                v-for="item in navigationItems"
                                :key="item.name"
                                :href="item.href"
                                class="text-gray-700 hover:text-orange-600 px-3 py-2 text-sm font-medium"
                                :class="{ 'text-orange-600': $page.url.startsWith(item.href) }"
                            >
                                {{ item.name }}
                            </Link>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="relative ml-3">
                            <div>
                                <button
                                    @click="isUserMenuOpen = !isUserMenuOpen"
                                    class="flex items-center bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500"
                                >
                                    <img class="h-8 w-8 rounded-full" :src="$page.props.auth.user.avatar || '/images/default-avatar.jpeg'" alt="" />
                                </button>
                            </div>

                            <div
                                v-if="isUserMenuOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1"
                            >
                                <Link
                                    v-for="item in userMenuItems"
                                    :key="item.name"
                                    :href="item.href"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50"
                                    method="get"
                                >
                                    {{ item.name }}
                                </Link>
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50"
                                >
                                    Déconnexion
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-6">
            <slot/>
        </main>
    </div>
</template>

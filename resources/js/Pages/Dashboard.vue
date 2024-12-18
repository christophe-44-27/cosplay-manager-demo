<!-- Dashboard.vue -->
<template>
    <DashboardLayout>
        <!-- Section des projets -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">
                    Mes projets en cours
                </h2>
                <div class="space-y-4">
                    <div
                        v-for="project in currentProjects"
                        :key="project.id"
                        class="p-4 border border-orange-200 rounded-md hover:bg-orange-50 transition-colors"
                    >
                        <Link
                            :href="`/projects/${project.id}`"
                            class="block"
                        >
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <img
                                        :src="project.thumbnail || '/images/default-project-thumbnail.jpeg'"
                                        :alt="project.title"
                                        class="w-16 h-16 object-cover rounded-lg"
                                    />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-800 truncate">{{ project.title }}</h3>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ project.description }}</p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">
                    Mes projets terminés
                </h2>
                <div class="space-y-4">
                    <div
                        v-for="project in completedProjects"
                        :key="project.id"
                        class="p-4 border border-orange-200 rounded-md hover:bg-orange-50 transition-colors"
                    >
                        <Link
                            :href="`/projects/${project.id}`"
                            class="block"
                        >
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <img
                                        :src="project.thumbnail || '/images/default-project-thumbnail.jpeg'"
                                        :alt="project.title"
                                        class="w-16 h-16 object-cover rounded-lg"
                                    />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-800 truncate">{{ project.title }}</h3>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ project.description }}</p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

const page = usePage();
const currentProjects = page.props.currentProjects;
const completedProjects = page.props.finishedProjects;
</script>

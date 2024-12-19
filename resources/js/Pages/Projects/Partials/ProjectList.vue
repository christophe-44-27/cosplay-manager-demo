<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import {
    PlusIcon,
    FunnelIcon,
    ClockIcon,
    CurrencyEuroIcon,
    CalendarIcon,
    EyeIcon,
} from '@heroicons/vue/24/outline'
import Badge from '@/Components/Badge.vue'

const props = defineProps({
    projects: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const filters = ref({
    is_published: props.filters.is_published || '',
    is_finished: props.filters.is_finished || '',
    is_private: props.filters.is_private || ''
})

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    }).format(price)
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    })
}

const getStatusVariant = (project) => {
    if (!project.is_published) return 'warning'
    if (project.is_finished) return 'success'
    return 'info'
}

const resetFilters = () => {
    filters.value = {
        is_published: '',
        is_finished: '',
        is_private: '',
    }
    applyFilters()
}

const applyFilters = () => {
    const formattedFilters = Object.entries(filters.value)
        .filter(([_, value]) => value !== '')
        .reduce((acc, [key, value]) => {
            acc[`filter[${key}]`] = value
            return acc
        }, {})
    router.get(
        route('projects.index'),
        formattedFilters,
        {
            preserveState: false,
            preserveScroll: false,
            replace: true
        }
    )
}
const getEmptyStateMessage = () => {
    // Si des filtres sont actifs
    if (Object.values(filters.value).some(value => value !== '')) {
        return "Essayez de modifier vos filtres pour voir plus de résultats"
    }
    // Si aucun filtre n'est actif
    return "Commencez par créer votre premier projet"
}
</script>
<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Mes Projets</h1>
            <Link
                :href="route('projects.create')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
            >
                <PlusIcon class="w-5 h-5" />
                Nouveau projet
            </Link>
        </div>

        <!-- Section des filtres -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <FunnelIcon class="w-5 h-5 text-gray-500" />
                <h2 class="text-lg font-medium">Filtres</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Statut
                    </label>
                    <select
                        v-model="filters.is_published"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">Tous les statuts</option>
                        <option value="0">Brouillon</option>
                        <option value="1">Publié</option>
                    </select>
                </div>

                <!-- État -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        État
                    </label>
                    <select
                        v-model="filters.is_finished"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">Tous les états</option>
                        <option value="0">En cours</option>
                        <option value="1">Terminé</option>
                    </select>
                </div>

                <!-- Visibilité -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Visibilité
                    </label>
                    <select
                        v-model="filters.is_private"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">Toutes les visibilités</option>
                        <option value="0">Public</option>
                        <option value="1">Privé</option>
                    </select>
                </div>
            </div>

            <!-- Boutons d'action des filtres -->
            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-200">
                <button
                    @click="resetFilters"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
                >
                    Réinitialiser
                </button>
                <button
                    @click="applyFilters"
                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                >
                    Appliquer les filtres
                </button>
            </div>
        </div>

        <!-- Liste des projets -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="grid gap-4 p-4">
                <div
                    v-if="projects.data.length > 0"
                    v-for="project in projects.data"
                    :key="project.id"
                    class="flex gap-4 p-4 rounded-lg border border-gray-200 hover:border-purple-200 transition-colors"
                >
                    <!-- Image du projet -->
                    <div class="flex-shrink-0">
                        <img
                            :src="project.thumbnail || '/images/default-project-thumbnail.jpeg'"
                            :alt="project.title"
                            class="w-24 h-24 object-cover rounded-lg"
                        />
                    </div>

                    <!-- Informations du projet -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 truncate">
                                    <Link :href="route('projects.show', {'project': project})">
                                        {{ project.title }}
                                    </Link>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {{ project.description }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <div class="flex gap-2">
                                    <Badge :variant="getStatusVariant(project)">
                                        {{ project.is_published ? 'Publié' : 'Brouillon' }}
                                    </Badge>
                                    <Badge :variant="project.is_private ? 'danger' : 'success'">
                                        {{ project.is_private ? 'Privé' : 'Public' }}
                                    </Badge>
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ formatDate(project.updated_at) }}
                                </div>
                            </div>
                        </div>

                        <!-- Métriques du projet -->
                        <div class="mt-4 flex items-center gap-6 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <ClockIcon class="w-4 h-4" />
                                {{ project.duration }} heures
                            </div>
                            <div class="flex items-center gap-1">
                                <CurrencyEuroIcon class="w-4 h-4" />
                                {{ formatPrice(project.estimated_price) }}
                            </div>
                            <div class="flex items-center gap-1">
                                <CalendarIcon class="w-4 h-4" />
                                {{ formatDate(project.estimated_end_date) }}
                            </div>
                            <div class="flex items-center gap-1">
                                <EyeIcon class="w-4 h-4" />
                                {{ project.views }} vues
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="py-12">
                    <div class="text-center">
                        <div class="text-4xl mb-4">🔍</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">
                            Aucun projet trouvé
                        </h3>
                        <p class="text-gray-600">
                            {{ getEmptyStateMessage() }}
                        </p>
                        <div class="mt-6">
                            <Link
                                :href="route('projects.create')"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                            >
                                <PlusIcon class="w-5 h-5" />
                                Créer un projet
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
        </div>
    </div>
</template>

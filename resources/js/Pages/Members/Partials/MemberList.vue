<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    members: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const filters = ref({
    name: props.filters.name || ''
})

const reset = () => {
    filters.value = {
        name: ''
    }
    search()
}

const search = () => {
    const formattedFilters = Object.entries(filters.value)
        .filter(([_, value]) => value !== '')
        .reduce((acc, [key, value]) => {
            acc[`filter[${key}]`] = value
            return acc
        }, {})
    router.get(
        route('members.index'),
        formattedFilters,
        {
            preserveState: false,
            preserveScroll: false,
            replace: true
        }
    )
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    })
}
</script>
<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête avec recherche -->
        <!-- Barre de recherche avec boutons -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Utilisateurs</h1>
            <form @submit.prevent="search" class="flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="search"
                        v-model="filters.name"
                        placeholder="Rechercher un utilisateur..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
                    />
                </div>

                <button
                    type="submit"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2"
                >
                    <MagnifyingGlassIcon class="h-5 w-5" />
                    Rechercher
                </button>

                <button
                    type="button"
                    @click="reset"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Réinitialiser
                </button>
            </form>
        </div>

        <!-- Grid des utilisateurs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Message si aucun utilisateur -->
            <div
                v-if="!props.members.length"
                class="col-span-full py-12 text-center"
            >
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-lg font-medium text-gray-900">
                    Aucun utilisateur trouvé
                </h3>
            </div>

            <!-- Cards utilisateurs -->
            <div
                v-for="user in props.members"
                :key="user.id"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center gap-4">
                    <img
                        :src="user.avatar || '/images/default-avatar.jpeg'"
                        :alt="user.name"
                        class="h-12 w-12 rounded-full object-cover"
                    />
                    <div>
                        <h3 class="font-medium text-gray-900">
                            {{ user.name }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            Membre depuis {{ formatDate(user.created_at) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="props.members.length" class="mt-6">

        </div>
    </div>
</template>

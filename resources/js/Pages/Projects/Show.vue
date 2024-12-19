<script setup>
import { ref } from 'vue'
import {Link, usePage} from '@inertiajs/vue3'
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionRoot,
    TransitionChild
} from '@headlessui/vue'
import {
    PencilSquareIcon,
    ClockIcon,
    EyeIcon,
    CurrencyEuroIcon,
    CalendarIcon,
    TagIcon,
    UserGroupIcon,
    DocumentTextIcon,
    ClipboardDocumentListIcon,
    CheckCircleIcon,
    ShoppingCartIcon,
    PlusIcon
} from '@heroicons/vue/24/outline'
import Badge from '@/Components/Badge.vue'
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

const page = usePage();
const project = page.props.project

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

const getTaskStatusVariant = (status) => {
    const variants = {
        'à faire': 'warning',
        'en cours': 'info',
        'terminé': 'success'
    }
    return variants[status.toLowerCase()] || 'default'
}

const getItemStatusVariant = (status) => {
    const variants = {
        'à acheter': 'warning',
        'commandé': 'info',
        'reçu': 'success'
    }
    return variants[status.toLowerCase()] || 'default'
}

const showAddTaskModal = ref(false)
const showAddItemModal = ref(false)

const newTask = ref({
    name: '',
    estimated_hours: '',
    description: ''
})

const newItem = ref({
    name: '',
    estimated_price: '',
    link: '',
    notes: ''
})

const handleAddTask = () => {
    // Envoi de la requête via Inertia
    router.post(`/projects/${props.project.id}/tasks`, newTask.value, {
        onSuccess: () => {
            showAddTaskModal.value = false
            // Réinitialisation du formulaire
            newTask.value = {
                name: '',
                estimated_hours: '',
                description: ''
            }
        }
    })
}

const handleAddItem = () => {
    // Envoi de la requête via Inertia
    router.post(`/projects/${props.project.id}/items`, newItem.value, {
        onSuccess: () => {
            showAddItemModal.value = false
            // Réinitialisation du formulaire
            newItem.value = {
                name: '',
                estimated_price: '',
                link: '',
                notes: ''
            }
        }
    })
}
</script>

<template>
    <DashboardLayout>
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-5xl mx-auto">
            <!-- En-tête avec bouton d'édition -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ project.title }}</h1>
                    <div class="flex items-center gap-2 mt-2">
                        <Badge :variant="project.is_published ? 'success' : 'warning'">
                            {{ project.is_published ? 'Publié' : 'Brouillon' }}
                        </Badge>
                        <Badge :variant="project.is_private ? 'danger' : 'success'">
                            {{ project.is_private ? 'Privé' : 'Public' }}
                        </Badge>
                        <Badge :variant="project.is_finished ? 'success' : 'info'">
                            {{ project.is_finished ? 'Terminé' : 'En cours' }}
                        </Badge>
                    </div>
                </div>
                <Link
                    :href="route('projects.edit', {'project': project})"
                    class="flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                >
                    <PencilSquareIcon class="w-5 h-5" />
                    Modifier le projet
                </Link>
            </div>

            <!-- Image et informations principales -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2">
                    <img
                        :src="project.thumbnail || '/images/default-project-thumbnail.jpeg'"
                        :alt="project.title"
                        class="w-full h-[300px] object-cover rounded-lg"
                    />
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Statistiques du projet -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center gap-2 text-gray-600 mb-1">
                                <ClockIcon class="w-5 h-5" />
                                <span class="text-sm">Durée</span>
                            </div>
                            <p class="font-semibold">{{ project.duration }} heures</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center gap-2 text-gray-600 mb-1">
                                <EyeIcon class="w-5 h-5" />
                                <span class="text-sm">Vues</span>
                            </div>
                            <p class="font-semibold">{{ project.views }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center gap-2 text-gray-600 mb-1">
                                <CurrencyEuroIcon class="w-5 h-5" />
                                <span class="text-sm">Budget</span>
                            </div>
                            <p class="font-semibold">{{ formatPrice(project.estimated_price) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center gap-2 text-gray-600 mb-1">
                                <CalendarIcon class="w-5 h-5" />
                                <span class="text-sm">Date de fin</span>
                            </div>
                            <p class="font-semibold">{{ formatDate(project.estimated_end_date) }}</p>
                        </div>
                    </div>

                    <!-- Catégorie et Groupe -->
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <TagIcon class="w-5 h-5 text-gray-600" />
                            <span class="text-gray-600">Catégorie:</span>
                            <span class="font-medium">{{ project.category }}</span>
                        </div>
                        <div v-if="project.group" class="flex items-center gap-2">
                            <UserGroupIcon class="w-5 h-5 text-gray-600" />
                            <span class="text-gray-600">Groupe:</span>
                            <span class="font-medium">{{ project.group }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <DocumentTextIcon class="w-5 h-5" />
                    Description
                </h2>
                <p class="text-gray-600 leading-relaxed">{{ project.description }}</p>
            </div>

            <!-- Éléments du projet -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <ClipboardDocumentListIcon class="w-5 h-5" />
                        Éléments du projet
                    </h2>
                    <div class="flex items-center gap-3">
                        <button
                            @click="showAddTaskModal = true"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 transition-colors"
                        >
                            <PlusIcon class="w-5 h-5" />
                            Nouvelle tâche
                        </button>
                        <button
                            @click="showAddItemModal = true"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                        >
                            <PlusIcon class="w-5 h-5" />
                            Nouvel achat
                        </button>
                    </div>
                </div>

                <!-- Tâches à faire -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-md font-medium text-gray-700 flex items-center gap-2">
                            <CheckCircleIcon class="w-5 h-5 text-purple-600" />
                            Tâches à faire
                        </h3>
                        <button
                            @click="showAddTaskModal = true"
                            class="inline-flex items-center gap-1 text-sm text-purple-600 hover:text-purple-700"
                        >
                            <PlusIcon class="w-4 h-4" />
                            Ajouter
                        </button>
                    </div>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Temps estimé</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="task in project.tasks" :key="task.id">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ task.name }}</td>
                                <td class="px-6 py-4">
                                    <Badge :variant="getTaskStatusVariant(task.status)">
                                        {{ task.status }}
                                    </Badge>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 text-right">{{ task.estimated_hours }}h</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Éléments à acheter -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-md font-medium text-gray-700 flex items-center gap-2">
                            <ShoppingCartIcon class="w-5 h-5 text-purple-600" />
                            Éléments à acheter
                        </h3>
                        <button
                            @click="showAddItemModal = true"
                            class="inline-flex items-center gap-1 text-sm text-purple-600 hover:text-purple-700"
                        >
                            <PlusIcon class="w-4 h-4" />
                            Ajouter
                        </button>
                    </div>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Prix estimé</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="item in project.items_to_buy" :key="item.id">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ item.name }}</td>
                                <td class="px-6 py-4">
                                    <Badge :variant="getItemStatusVariant(item.status)">
                                        {{ item.status }}
                                    </Badge>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 text-right">{{ formatPrice(item.estimated_price) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour ajouter une tâche -->
        <TransitionRoot appear :show="showAddTaskModal" as="template">
            <Dialog as="div" @close="showAddTaskModal = false" class="relative z-10">
                <TransitionChild
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <TransitionChild
                            enter="ease-out duration-300"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                    Ajouter une nouvelle tâche
                                </DialogTitle>

                                <form @submit.prevent="handleAddTask">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nom de la tâche
                                            </label>
                                            <input
                                                type="text"
                                                v-model="newTask.name"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Temps estimé (heures)
                                            </label>
                                            <input
                                                type="number"
                                                v-model="newTask.estimated_hours"
                                                min="0"
                                                step="0.5"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Description
                                            </label>
                                            <textarea
                                                v-model="newTask.description"
                                                rows="3"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <button
                                            type="button"
                                            @click="showAddTaskModal = false"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
                                        >
                                            Annuler
                                        </button>
                                        <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg"
                                        >
                                            Ajouter
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Modal pour ajouter un élément à acheter -->
        <TransitionRoot appear :show="showAddItemModal" as="template">
            <Dialog as="div" @close="showAddItemModal = false" class="relative z-10">
                <TransitionChild
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <TransitionChild
                            enter="ease-out duration-300"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                    Ajouter un élément à acheter
                                </DialogTitle>

                                <form @submit.prevent="handleAddItem">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nom de l'élément
                                            </label>
                                            <input
                                                type="text"
                                                v-model="newItem.name"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Prix estimé (€)
                                            </label>
                                            <input
                                                type="number"
                                                v-model="newItem.estimated_price"
                                                min="0"
                                                step="0.01"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Lien (optionnel)
                                            </label>
                                            <input
                                                type="url"
                                                v-model="newItem.link"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Notes
                                            </label>
                                            <textarea
                                                v-model="newItem.notes"
                                                rows="3"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <button
                                            type="button"
                                            @click="showAddItemModal = false"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
                                        >
                                            Annuler
                                        </button>
                                        <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg"
                                        >
                                            Ajouter
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </DashboardLayout>
</template>

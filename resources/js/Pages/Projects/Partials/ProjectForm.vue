<template>
    <form @submit.prevent="handleSubmit" class="bg-white rounded-xl shadow-lg p-8">
        <div class="space-y-8">
            <!-- En-tête du formulaire -->
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ isEditing ? 'Modifier le projet' : 'Créer un nouveau projet' }}
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Remplissez les informations ci-dessous pour {{ isEditing ? 'modifier' : 'créer' }} votre projet.
                </p>
            </div>

            <!-- Informations principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Titre du projet <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        :class="{ 'border-red-300': errors.title }"
                    />
                    <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                </div>

                <!-- Thumbnail -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Image de miniature
                    </label>
                    <div class="flex items-center gap-4">
                        <div
                            v-if="form.thumbnail || preview"
                            class="relative w-32 h-32 rounded-lg overflow-hidden"
                        >
                            <img
                                :src="preview || form.thumbnail"
                                class="w-full h-full object-cover"
                                alt="Miniature du projet"
                            />
                            <button
                                @click="removeThumbnail"
                                type="button"
                                class="absolute top-1 right-1 p-1 bg-red-500 text-white rounded-full hover:bg-red-600"
                            >
                                <XMarkIcon class="w-4 h-4" />
                            </button>
                        </div>
                        <div>
                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFileUpload"
                                accept="image/*"
                                class="hidden"
                            />
                            <button
                                type="button"
                                @click="$refs.fileInput.click()"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50"
                            >
                                <PhotoIcon class="w-5 h-5" />
                                {{ form.thumbnail ? 'Changer l\'image' : 'Ajouter une image' }}
                            </button>
                        </div>
                    </div>
                    <p v-if="errors.thumbnail" class="mt-1 text-sm text-red-600">{{ errors.thumbnail }}</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        :class="{ 'border-red-300': errors.description }"
                    ></textarea>
                    <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                </div>

                <!-- Catégorie -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        v-model="form.category_id"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">Sélectionnez une catégorie</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <p v-if="errors.category_id" class="mt-1 text-sm text-red-600">{{ errors.category_id }}</p>
                </div>

                <!-- Groupe -->
                <div>
                    <label for="group" class="block text-sm font-medium text-gray-700 mb-1">
                        Groupe
                    </label>
                    <select
                        id="group"
                        v-model="form.group_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">Aucun groupe</option>
                        <option v-for="group in groups" :key="group.id" :value="group.id">
                            {{ group.name }}
                        </option>
                    </select>
                </div>

                <!-- Prix estimé -->
                <div>
                    <label for="estimated_price" class="block text-sm font-medium text-gray-700 mb-1">
                        Budget estimé (€)
                    </label>
                    <input
                        id="estimated_price"
                        v-model="form.estimated_price"
                        type="number"
                        min="0"
                        step="0.01"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    />
                </div>

                <!-- Date de fin estimée -->
                <div>
                    <label for="estimated_end_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Date de fin estimée
                    </label>
                    <input
                        id="estimated_end_date"
                        v-model="form.estimated_end_date"
                        type="date"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    />
                </div>
            </div>

            <!-- Options du projet -->
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Options du projet</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_private"
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                            />
                            <span class="text-sm text-gray-700">Projet privé</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_published"
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                            />
                            <span class="text-sm text-gray-700">Publier le projet</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_finished"
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                            />
                            <span class="text-sm text-gray-700">Projet terminé</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-end gap-4">
                <Link
                    :href="route('projects.index')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
                >
                    Annuler
                </Link>
                <button
                    type="submit"
                    :disabled="processing"
                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
          <span v-if="processing">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Traitement en cours...
          </span>
                    <span v-else>
            {{ isEditing ? 'Mettre à jour' : 'Créer le projet' }}
          </span>
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { PhotoIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    project: {
        type: Object,
        default: null
    },
    categories: {
        type: Array,
        required: true
    },
    groups: {
        type: Array,
        required: true
    }
})

const isEditing = computed(() => !!props.project)
const fileInput = ref(null)
const preview = ref(null)

// Initialisation du formulaire
const form = useForm({
    title: props.project?.title ?? '',
    description: props.project?.description ?? '',
    category_id: props.project?.category_id ?? '',
    group_id: props.project?.group_id ?? '',
    estimated_price: props.project?.estimated_price ?? '',
    estimated_end_date: props.project?.estimated_end_date ?? '',
    is_private: props.project?.is_private ?? false,
    is_published: props.project?.is_published ?? false,
    is_finished: props.project?.is_finished ?? false,
    thumbnail: props.project?.thumbnail ?? null
})

const processing = computed(() => form.processing)
const errors = computed(() => form.errors)

const handleFileUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.thumbnail = file
        preview.value = URL.createObjectURL(file)
    }
}

const removeThumbnail = () => {
    form.thumbnail = null
    preview.value = null
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

const handleSubmit = () => {
    if (isEditing.value) {
        form.put(route('projects.update', props.project.id))
    } else {
        form.post(route('projects.store'))
    }
}
</script>

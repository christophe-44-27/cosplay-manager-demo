<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ProjectForm from "@/Pages/Projects/Partials/ProjectForm.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const groups = page.props.groups;
const categories = page.props.categories;
const project = page.props.project;
</script>

<template>
    <DashboardLayout>
        <ProjectForm :project="project" :groups="groups" :categories="categories"></ProjectForm>
    </DashboardLayout>
</template>

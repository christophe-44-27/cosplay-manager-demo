<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ProjectForm from "@/Pages/Projects/Partials/ProjectForm.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const groups = page.props.groups;
const categories = page.props.categories;
</script>

<template>
    <DashboardLayout>
        <ProjectForm :groups="groups" :categories="categories"></ProjectForm>
    </DashboardLayout>
</template>

<style scoped>

</style>

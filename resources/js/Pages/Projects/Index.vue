<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import ProjectList from "@/Pages/Projects/Partials/ProjectList.vue";

const page = usePage();
const projects = page.props.projects;
</script>

<template>
    <DashboardLayout>
        <ProjectList :projects="projects"></ProjectList>
    </DashboardLayout>
</template>

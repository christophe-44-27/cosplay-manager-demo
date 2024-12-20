<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import MemberList from "@/Pages/Members/Partials/MemberList.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const members = page.props.members;
console.log(members)
</script>


<template>
    <DashboardLayout>
        <MemberList :members="members.data"></MemberList>
    </DashboardLayout>
</template>

<style scoped>

</style>

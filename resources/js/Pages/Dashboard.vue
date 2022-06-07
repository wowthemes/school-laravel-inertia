<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />
    
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="intro-y text-lg font-medium mt-10">Data List Layout</h2>
        </template>
        Hello
    </BreezeAuthenticatedLayout>
</template>

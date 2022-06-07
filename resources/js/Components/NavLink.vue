<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'side-menu side-menu--active side-menu--open'
    : 'side-menu'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <div class="side-menu__icon"></div>
        <div class="side-menu__title">
            <slot />
        </div>
    </Link>
</template>

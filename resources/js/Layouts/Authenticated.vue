<script setup>
import { ref, provide, onMounted } from "vue";
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import TopBar from "@/Components/TopBar.vue";

const showingNavigationDropdown = ref(false);


onMounted(() => {
  
})
</script>

<template>
  
  <div class="flex mt-[4.7rem] md:mt-0">
    <div class="side-nav">
      <Link :href="route('dashboard')" class="block w-2/4 text-white">
        <BreezeApplicationLogo class="router-link-active router-link-exact-active intro-x flex items-center pl-5 pt-4" />
      </Link>
      <div class="side-nav__devider my-6"></div>
      <ul>
        <li>
          <BreezeNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
          >
            Dashboard
          </BreezeNavLink>
        </li>
        <li>
          <BreezeNavLink
            :href="route('students.index')"
            :active="route().current('students.index')"
          >
            Students
          </BreezeNavLink>
        </li>
        <li>
          <BreezeNavLink
            :href="route('students.index')"
            :active="route().current('students.index')"
          >
            Attachments
          </BreezeNavLink>
        </li>
        <li>
          <BreezeNavLink
            :href="route('users.index')"
            :active="route().current('users.index')"
          >
            Users
          </BreezeNavLink>
        </li>
      </ul>
    </div>
    <div class="content">
      <!-- Page Heading -->
      <div class="top-bar" v-if="$slots.header">
        <TopBar />
      </div>
      <slot name="header" />

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { defineProps, ref } from 'vue';
import AttachmentModal from "@/Components/AttachmentModal.vue";

const props = defineProps({
  head_title: String,
  new_user: {
    type: Boolean,
    default: true
  }
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  avatar: 0,
});

const showModal = ref(false);

const submit = () => {
  Inertia.post('/users/store', form)
}
</script>

<template>
  <Head :title="head_title" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="intro-y text-lg font-medium mt-10">{{ head_title }}</h2>
    </template>
    <div class="grid grid-cols-12 gap-6 mt-5">
      <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box">
          <div
            class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
          >
            <h2 class="font-medium text-base mr-auto">Basic Details</h2>
          </div>
          <form @submit.prevent="form.post('/users/store')">
            <div class="p-5">
              
              <AttachmentModal @selected-image="form.avatar = $event" @remove="form.avatar = 0" />

              <div class="mt-3">
                <label for="regular-form-1" class="form-label">Name</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Name"
                  v-model="form.name"
                />
                <div class="text-danger mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
              </div>
              <div class="mt-3">
                <label for="regular-form-1" class="form-label">Email</label>
                <div class="input-group">
                  <div id="input-group-email" class="input-group-text">@</div>
                  <input type="email" v-model="form.email" class="form-control" placeholder="Email" />
                </div>
                <div class="text-danger mt-2" v-if="form.errors.email">{{ form.errors.email }}</div>
              </div>
              <div class="mt-3" v-if="new_user">
                <label for="regular-form-1" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  v-model="form.password"
                />
                <div class="text-danger mt-2" v-if="form.errors.password">{{ form.errors.password }}</div>
              </div>
              <div class="mt-3" v-if="new_user">
                <label for="regular-form-1" class="form-label">Re-enter Password</label>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Re-enter Password"
                  v-model="form.password_confirmation"
                />
                <div class="text-danger mt-2" v-if="form.errors.password_conformation">{{ form.errors.password_conformation }}</div>
              </div>
              <button type="submit" class="btn btn-primary mt-5" :disabled="form.processing">Create User</button>
            </div>
          </form>
        </div>
      </div>
      <div class="intro-y col-span-12 lg:col-span-6" v-if="! new_user">
        <div class="intro-y box">
          <div
            class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
          >
            <h2 class="font-medium text-base mr-auto">Change Password</h2>
          </div>
          <div class="p-5">
            <div>
              <label for="regular-form-1" class="form-label">Current Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
              />
            </div>
            <div class="mt-3">
              <label for="regular-form-1" class="form-label">New Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="New Password"
              />
            </div>
            <div class="mt-3">
              <label for="regular-form-1" class="form-label">Re-enter New Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Re-enter New Password"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

  </BreezeAuthenticatedLayout>
</template>

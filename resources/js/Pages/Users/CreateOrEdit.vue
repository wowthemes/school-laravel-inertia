<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { defineProps, ref, onMounted } from 'vue';
import AttachmentModal from "@/Components/AttachmentModal.vue";

const props = defineProps({
  head_title: String,
  new_user: {
    type: Boolean,
    default: true
  },
  user: Object
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  avatar: 0,
});

const password_form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const showModal = ref(false);

const submit = () => {
  console.log(props.new_user)
  if(props.new_user) {
    Inertia.post('/users/store', form)
  } else {
    Inertia.patch(`/users/upadte/${props.user.id}`, form)
  }
}

onMounted(() => {
  if(props.user.id) {
    form.name = props.user.name
    form.email = props.user.email
  }
})
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
          <form @submit.prevent="new_user ? form.post('/users/store') : form.patch(`/users/update/${props.user.id}`)">
            <div class="p-5">
              
              <AttachmentModal :image="user.attachments ? user.attachments[0] : {}" @selected-image="form.avatar = $event" @remove="form.avatar = 0" />

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
          <form class="p-5" @submit.prevent="password_form.post(route('users.change-password', {id: user.id}))">
            <div>
              <label for="regular-form-1" class="form-label">Current Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password_form.current_password"
              />
              <div class="text-danger mt-2" v-if="password_form.errors.current_password">{{ password_form.errors.current_password }}</div>
            </div>
            <div class="mt-3">
              <label for="regular-form-1" class="form-label">New Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="New Password"
                v-model="password_form.password"
              />
              <div class="text-danger mt-2" v-if="password_form.errors.password">{{ password_form.errors.password }}</div>
            </div>
            <div class="mt-3">
              <label for="regular-form-1" class="form-label">Re-enter New Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Re-enter New Password"
                v-model="password_form.password_confirmation"
              />
              <div class="text-danger mt-2" v-if="password_form.errors.password_confirmation">{{ password_form.errors.password_confirmation }}</div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary" :disabled="password_form.processing">Change Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </BreezeAuthenticatedLayout>
</template>

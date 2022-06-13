<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import { onMounted, ref, defineProps, inject, provide } from "vue";
import { Inertia } from '@inertiajs/inertia'


const props = defineProps({
  data: Array,
  links: Array,
  current_page: Number,
  last_page: Number,
  from: Number,
  to: Number,
  total: Number,
  path: String,
  items_per_page: Number,
  first_page_url: String,
  last_page_url: String,
  search: String,
})
// reactive state
const per_page = ref(10);
const timer = ref(null);
const search_term = ref(null);
const deleteConfirmationModal = ref(false);
const delete_user_id = ref(0);
// Success notification
const successNotification = ref();
provide("bind[successNotification]", (el) => {
  // Binding
  successNotification.value = el;
});

const moment = inject('moment');

const makeRequest = () => {
  let url = `${props.path}?page=${props.current_page}&per_page=${per_page.value}`;
  if(search_term.value) {
    url += `&search=${encodeURI(search_term.value)}`;
  }
  Inertia.visit(url)
}

const deleteUser = async () => {
  deleteConfirmationModal.value = false
  await Inertia.delete(`/users/delete/${delete_user_id.value}`);

  setTimeout(() => {
    if(_.get(usePage().props.value.flash, 'message')) {
      successNotification.value.showToast();
    }
  }, 1000)
}

const searchTimeOut = () => {
  if (! search_term.value) {
    return;
  }
  if (timer.value) {
    clearTimeout(timer.value);
    timer.value = null;
  }
  timer.value = setTimeout(() => {
    makeRequest();
  }, 1000);
}

onMounted(() => {
  if(props.items_per_page && props.items_per_page !== per_page.value) {
    per_page.value = props.items_per_page;
  }
  if(props.search && props.search !== search_term.value) {
    search_term.value = props.search;
  }

})
</script>

<template>
  <Head title="All Users" />
  <!-- BEGIN: Notification Content -->
  <Notification refKey="successNotification" class="flex" :options="{ duration: 3000, }">
    <CheckCircleIcon class="text-success" />
    <div class="ml-4 mr-4">
      <div class="font-medium">Message!</div>
      <div class="text-slate-500 mt-1">{{ $page.props.flash.message }}</div>
    </div>
  </Notification>
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="intro-y text-lg font-medium mt-10">All Users</h2>
    </template>

    <div class="grid grid-cols-12 gap-6 mt-5">
      <div
        class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2"
      >
        <Link :href="route('users.create')" class="btn btn-primary shadow-md mr-2">Add New User</Link>
        <Dropdown>
          <DropdownToggle class="btn px-2 box">
            <span class="w-5 h-5 flex items-center justify-center">
              <PlusIcon class="w-4 h-4" />
            </span>
          </DropdownToggle>
          <DropdownMenu class="w-40">
            <DropdownContent>
              <DropdownItem>
                <PrinterIcon class="w-4 h-4 mr-2" /> Print
              </DropdownItem>
              <DropdownItem>
                <FileTextIcon class="w-4 h-4 mr-2" /> Export to Excel
              </DropdownItem>
              <DropdownItem>
                <FileTextIcon class="w-4 h-4 mr-2" /> Export to PDF
              </DropdownItem>
            </DropdownContent>
          </DropdownMenu>
        </Dropdown>
        <div class="hidden md:block mx-auto text-slate-500">
          Showing {{ from }} to {{ to }} of {{ total }} entries
        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
          <div class="w-56 relative text-slate-500">
            <input
              type="search"
              class="form-control w-56 box pr-10"
              placeholder="Search..."
              @keyup="searchTimeOut()"
              v-model="search_term"
            />
            <SearchIcon class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" />
          </div>
        </div>
      </div>
      <!-- BEGIN: Data List -->
      <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
          <thead>
            <tr>
              <th class="whitespace-nowrap">AVATAR</th>
              <th class="whitespace-nowrap">USER NAME</th>
              <th class="text-center whitespace-nowrap">EMAIL</th>
              <th class="text-center whitespace-nowrap">STATUS</th>
              <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, dataKey) in data"
              :key="dataKey"
              class="intro-x"
            >
              <td class="w-40" v-if="true">
                <div class="flex">
                  <div class="w-10 h-10 image-fit zoom-in">
                    <Tippy
                      tag="img"
                      alt="Midone Tailwind HTML Admin Template"
                      class="rounded-full"
                      :src="item.avatar.url"
                      :content="`Created at ${moment(item.created_at).format('Do MMM YYYY')}`"
                    />
                  </div>
                </div>
              </td>
              <td>
                <a href="" class="font-medium whitespace-nowrap">{{
                  item.name
                }}</a>
                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                  {{ 'PC & Laptop' }}
                </div>
              </td>
              <td class="text-center">{{ item.email }}</td>
              <td class="w-40">
                <div
                  class="flex items-center justify-center"
                  :class="{
                    'text-success': item.email_verified_at ? true : false,
                    'text-danger': item.email_verified_at ? false : true,
                  }"
                >
                  <CheckSquareIcon class="w-4 h-4 mr-2" />
                  {{ item.email_verified_at ? "Active" : "Inactive" }}
                </div>
              </td>
              <td class="table-report__action w-56">
                <div class="flex justify-center items-center">
                  <Link class="flex items-center mr-3" :href="route('users.edit', {id: item.id})">
                    <CheckSquareIcon class="w-4 h-4 mr-1" /> Edit
                  </Link>
                  <a
                    class="flex items-center text-danger"
                    href="javascript:;"
                    @click="deleteConfirmationModal = true; delete_user_id = item.id"
                  >
                    <Trash2Icon class="w-4 h-4 mr-1" /> Delete
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- END: Data List -->
      <!-- BEGIN: Pagination -->
      <div
        class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
      >
        <nav class="w-full sm:w-auto sm:mr-auto" v-if="to > 1">
          <ul class="pagination">
            <li class="page-item" v-if="first_page_url">
              <Link class="page-link" :href="`${first_page_url}&per_page=${per_page}`">
                <ChevronsLeftIcon class="w-4 h-4" />
              </Link>
            </li>
            <template v-for="p_link in links" :key="p_link.label">
              <li :class="{'page-item': true, active: p_link.active}" v-if="p_link.url">
                <Link :href="`${p_link.url}&per_page=${per_page}`" class="page-link" v-if="p_link.label.search('Previous') > -1"><ChevronLeftIcon class="w-4 h-4" /></Link>
                <Link :href="`${p_link.url}&per_page=${per_page}`" class="page-link" v-else-if="p_link.label.search('Next') > -1"><ChevronRightIcon class="w-4 h-4" /></Link>
                <Link class="page-link" :href="`${p_link.url}&per_page=${per_page}`" v-else v-html="p_link.label"></Link>
              </li>
            </template>
            <li class="page-item" v-if="last_page_url">
              <Link class="page-link" :href="`${last_page_url}&per_page=${per_page}`">
                <ChevronsRightIcon class="w-4 h-4" />
              </Link>
            </li>
          </ul>
        </nav>
        <select v-model="per_page" @change="makeRequest()" class="w-20 form-select box mt-3 sm:mt-0">
          <option>10</option>
          <option>25</option>
          <option>35</option>
          <option>50</option>
        </select>
      </div>
      <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <Modal
      :show="deleteConfirmationModal"
      @hidden="deleteConfirmationModal = false"
    >
      <ModalBody class="p-0">
        <div class="p-5 text-center">
          <XCircleIcon class="w-16 h-16 text-danger mx-auto mt-3" />
          <div class="text-3xl mt-5">Are you sure?</div>
          <div class="text-slate-500 mt-2">
            Do you really want to delete these records? <br />This process cannot
            be undone.
          </div>
        </div>
        <div class="px-5 pb-8 text-center">
          <button
            type="button"
            @click="deleteConfirmationModal = false"
            class="btn btn-outline-secondary w-24 mr-1"
          >
            Cancel
          </button>
          <button @click.prevent="deleteUser()" type="button" class="btn btn-danger w-24">Delete</button>
        </div>
      </ModalBody>
    </Modal>
    <!-- END: Delete Confirmation Modal -->
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { defineProps, ref, onMounted, defineEmits, provide } from "vue";
import { usePage, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  show: Boolean,
  image: Object,
});

const showModal = ref(false);
const showdropzone = ref(false);
const dropzoneSingleRef = ref(null);
const attachments = ref([]);
const selected_image = ref(null);
const show_sidebar = ref(false);
const page = ref(1);
const last_page = ref(1);
const processing = ref(false);
const xhr_error = ref(null);

// Success notification
const successNotification = ref();
provide("bind[successNotification]", (el) => {
  // Binding
  successNotification.value = el;
});

const insertImage = (img) => {
  emits('selected-image', img.id); 
  showModal.value = false; 
  // selected_image.value = img.url;
  show_sidebar.value = false
}

const saveImageDetails = () => {
  axios.patch(`/attachments/update/${selected_image.value.id}`, selected_image.value)
  .then(res => {

  })
}
const getAttachments = () => {
  processing.value = true
  axios.get('/attachments', {params: {page: page.value}})
  .then(res => {
    if(_.size(res.data.data)) {
      _.each(res.data.data, (value) => {
        attachments.value.push(value)
      })
    }
    last_page.value = res.data.last_page
    processing.value = false
  })
  .catch(error => {
    processing.value = false;
    xhr_error.value = error
    successNotification.value.showToast();
  })
}
onMounted(() => {
  getAttachments();
  if(props.image) {
    selected_image.value = props.image
  }
})
const emits = defineEmits(['selected-image', 'remove'])
</script>

<template>
  <!-- BEGIN: Modal Toggle -->
  <div class="text-center">
    <img :src="selected_image.url" v-if="selected_image" class="inline-block rounded-md shadow" style="width: 150px;height:auto;" /><br/>
    <a href="javascript:;" v-if="selected_image" class="btn mt-3 mr-3" @click.prevent="selected_image = ''; $emit('remove')">Remove</a>
    <a href="javascript:;" @click="showModal = true" class="btn btn-primary mt-4"
      >Select Image</a
    >
  </div>
  <!-- BEGIN: Notification Content -->
  <Notification refKey="successNotification" class="flex" :options="{ duration: 3000, }">
    <CheckCircleIcon class="text-danger" />
    <div class="ml-4 mr-4">
      <div class="font-medium">There is an error!</div>
      <div class="text-slate-500 mt-1">{{ xhr_error }}</div>
    </div>
  </Notification>
  <!-- BEGIN: Modal Content -->
  <Modal :show="showModal" @hidden="showModal = false" size="modal-xl">
    <ModalBody>
      <div class="mx-6 grid grid-cols-12 gap-3">
        
        <div :class="{
          'col-span-12': (!show_sidebar || !selected_image),
          'col-span-9': (show_sidebar && selected_image),
        }">
          <!-- BEGIN: File Manager Filter -->
          <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
              <SearchIcon
                class="
                  w-4
                  h-4
                  absolute
                  my-auto
                  inset-y-0
                  ml-3
                  left-0
                  z-10
                  text-slate-500
                "
              />
              <input
                type="text"
                class="form-control w-full sm:w-64 box px-10"
                placeholder="Search files"
              />
              <Dropdown
                class="
                  inbox-filter
                  absolute
                  inset-y-0
                  mr-3
                  right-0
                  flex
                  items-center
                "
                placement="bottom-start"
              >
                <DropdownToggle
                  tag="a"
                  role="button"
                  class="w-4 h-4 block"
                  href="javascript:;"
                >
                  <ChevronDownIcon
                    class="w-4 h-4 cursor-pointer text-slate-500"
                  />
                </DropdownToggle>
                <DropdownMenu class="inbox-filter__dropdown-menu pt-2">
                  <DropdownContent tag="div">
                    <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                      <div class="col-span-6">
                        <label for="input-filter-1" class="form-label text-xs"
                          >File Name</label
                        >
                        <input
                          id="input-filter-1"
                          type="text"
                          class="form-control flex-1"
                          placeholder="Type the file name"
                        />
                      </div>
                      <div class="col-span-6">
                        <label for="input-filter-2" class="form-label text-xs"
                          >Shared With</label
                        >
                        <input
                          id="input-filter-2"
                          type="text"
                          class="form-control flex-1"
                          placeholder="example@gmail.com"
                        />
                      </div>
                      <div class="col-span-6">
                        <label for="input-filter-3" class="form-label text-xs"
                          >Created At</label
                        >
                        <input
                          id="input-filter-3"
                          type="text"
                          class="form-control flex-1"
                          placeholder="Important Meeting"
                        />
                      </div>
                      <div class="col-span-6">
                        <label for="input-filter-4" class="form-label text-xs"
                          >Size</label
                        >
                        <select id="input-filter-4" class="form-select flex-1">
                          <option>10</option>
                          <option>25</option>
                          <option>35</option>
                          <option>50</option>
                        </select>
                      </div>
                      <div class="col-span-12 flex items-center mt-3">
                        <button class="btn btn-secondary w-32 ml-auto">
                          Create Filter
                        </button>
                        <button class="btn btn-primary w-32 ml-2">
                          Search
                        </button>
                      </div>
                    </div>
                  </DropdownContent>
                </DropdownMenu>
              </Dropdown>
            </div>
            <div class="w-full sm:w-auto flex">
              <button class="btn btn-primary shadow-md mr-2" @click.prevent="showdropzone = true">
                Upload New Files
              </button>
              <Dropdown>
                <DropdownToggle class="btn px-2 box">
                  <span class="w-5 h-5 flex items-center justify-center">
                    <PlusIcon class="w-4 h-4" />
                  </span>
                </DropdownToggle>
                <DropdownMenu class="w-40">
                  <DropdownContent>
                    <DropdownItem>
                      <FileIcon class="w-4 h-4 mr-2" /> Share Files
                    </DropdownItem>
                    <DropdownItem>
                      <SettingsIcon class="w-4 h-4 mr-2" /> Settings
                    </DropdownItem>
                  </DropdownContent>
                </DropdownMenu>
              </Dropdown>
            </div>
          </div>
          <!-- END: File Manager Filter -->
          <div v-if="showdropzone" class="my-5">
            <Dropzone
              ref-key="dropzoneSingleRef"
              :options="{
                url: route('attachments.store'),
                thumbnailWidth: 150,
                maxFilesize: 1.0,
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFiles: 10,
                addRemoveLinks: true,
                withCredentials: true,
                //previewsContainer: '.dropzone-container',
                headers: { 'X-CSRF-TOKEN': usePage().props.value.csrf },
              }"
              @successful="showdropzone = false"
              @hidezone="showdropzone = false"
              class="dropzone"
            >
              <div class="text-lg font-medium">
                Drop files here or click to upload.
              </div>
              <div class="text-gray-600">
                This is just a demo dropzone. Selected files are
                <span class="font-medium">not</span> actually uploaded.
              </div>
            </Dropzone>

            <div
              class="dropzone-container dropzone-previews dropzone border-0"
              style="border: none"
            ></div>
          </div>
          <!-- BEGIN: Directory & Files -->
          <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
            
            <div
              v-for="(faker, fakerKey) in attachments"
              :key="fakerKey"
              class="
                intro-y
                col-span-6
                sm:col-span-4
                md:col-span-3
                2xl:col-span-2
              "
            >
              <div
                class="
                  file
                  box
                  rounded-md
                  px-5
                  pt-8
                  pb-5
                  px-3
                  sm:px-5
                  relative
                  zoom-in
                "
                @click.self="show_sidebar = true; selected_image = faker"
              >
                <div class="absolute left-0 top-0 mt-3 ml-3">
                  <input
                    class="form-check-input border border-slate-500"
                    type="checkbox"
                    :checked="false"
                  />
                </div>
                <a
                  v-if="false"
                  href=""
                  class="w-3/5 file__icon file__icon--empty-directory mx-auto"
                ></a>
                <a
                  v-else-if="true"
                  href="javascript:;"
                  class="w-3/5 file__icon file__icon--image mx-auto"
                >
                  <div class="file__icon--image__preview image-fit">
                    <img
                      alt="Midone Tailwind HTML Admin Template"
                      :src="faker.url"
                    />
                  </div>
                </a>
                <a
                  v-else
                  href="javascript:;"
                  class="w-3/5 file__icon file__icon--file mx-auto"
                >
                  <div class="file__icon__file-name">
                    {{ faker.files[0].type }}
                  </div>
                </a>
                <a
                  href="javascript:;"
                  class="block font-medium mt-4 text-center truncate"
                  >{{
                    faker.name
                  }}</a
                >
                <div class="text-slate-500 text-xs text-center mt-0.5" v-if="faker.size">
                  {{ (faker.size / 1024).toFixed(1) }} KB
                </div>
                <Dropdown class="absolute top-0 right-0 mr-2 mt-3 ml-auto">
                  <DropdownToggle
                    tag="a"
                    class="w-5 h-5 block"
                    href="javascript:;"
                  >
                    <MoreVerticalIcon class="w-5 h-5 text-slate-500" />
                  </DropdownToggle>
                  <DropdownMenu class="w-40">
                    <DropdownContent>
                      <DropdownItem>
                        <UsersIcon class="w-4 h-4 mr-2" /> Share File
                      </DropdownItem>
                      <DropdownItem>
                        <TrashIcon class="w-4 h-4 mr-2" /> Delete
                      </DropdownItem>
                    </DropdownContent>
                  </DropdownMenu>
                </Dropdown>
              </div>
            </div>
          </div>
          <!-- END: Directory & Files -->
          <!-- BEGIN: Pagination -->
          <div
            class="
              intro-y
              flex flex-wrap
              sm:flex-row sm:flex-nowrap
              items-center
              mt-6
            "
          >
            <nav class="w-full text-center sm:mr-auto" v-if="last_page > 1 && last_page > page">
              <button class="btn btn-default" @click="page++; getAttachments()">Load More <LoadingIcon icon="puff" /></button>
            </nav>
          </div>
          <!-- END: Pagination -->
        </div>

        <div class="col-span-3 border-l px-4" v-if="show_sidebar && selected_image">
          <form>
            <img :src="selected_image.url" class="rounded-md shadow" style="width: 150px;" />

            <div class="mt-3">
              <label class="form-label">Title</label>
              <input type="text" @focusout="saveImageDetails()" v-model="selected_image.name" placeholder="Title" class="form-control" />
            </div>

            <div class="mt-3">
              <label class="form-label">Alt</label>
              <input type="text" @focusout="saveImageDetails()" v-model="selected_image.alt" placeholder="Alt" class="form-control" />
            </div>

            <div class="mt-3 mb-3">
              <label class="form-label">Description</label>
              <textarea @focusout="saveImageDetails()" v-model="selected_image.description" placeholder="Description" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary mr-3" @click.prevent="insertImage(selected_image)">Insert</button>
            <button class="btn btn-default" @click.prevent="selected_image = {}; show_sidebar = false">Cancel</button>
          </form>
        </div>
      </div>
    </ModalBody>
  </Modal>
  <!-- END: Modal Content -->
</template>

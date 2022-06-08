<template>
  <div
    ref="fileUploadRef"
    v-file-upload-directive="{ props, emit }"
    class="dropzone"
  >
    <div class="dz-message">
      <slot></slot>
    </div>
  </div>
  <div class="flex mt-5">
    <button class="btn btn-primary mr-4" @click="dropzone.processQueue()">Upload</button>
    <button class="btn" @click="$emit('hidezone')">Cancel</button>
  </div>
</template>

<script setup>
import { inject, ref, onMounted } from "vue";
import { init } from "./index";

const vFileUploadDirective = {
  mounted(el, { value }) {
    dropzone.value = init(el, value.props);
    dropzone.value.on('addedfile', (file) => {
      console.log(file)
    })
    dropzone.value.on('success', (file, response) => {
      emit('successful', {file, response})
    })
  },
};

const props = defineProps({
  options: {
    type: Object,
    default: () => ({}),
  },
  refKey: {
    type: String,
    default: null,
  },
});

const dropzone = ref();

const emit = defineEmits();

const fileUploadRef = ref();
const bindInstance = () => {
  if (props.refKey) {
    const bind = inject(`bind[${props.refKey}]`);
    if (bind) {
      bind(fileUploadRef.value);
    }
  }
};

onMounted(() => {
  bindInstance();
});
</script>

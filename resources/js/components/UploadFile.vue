<template>
  <vue-dropzone
    id="dropzone"
    :options="dropzoneOptions"
    v-on:vdropzone-success="handleAddNewImage"
    :useCustomSlot="true"
    ref="myVueDropzone"
  >
    <div class="dropzone-custom-content">
      <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
      <div class="subtitle">...or click to select a file from your computer</div>
    </div>
  </vue-dropzone>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "app",
  components: {
    vueDropzone: vue2Dropzone
  },
  data: function() {
    return {
      dropzoneOptions: {
        url: "/api/upload-media",
        thumbnailWidth: 200,
        addRemoveLinks: true
      }
    };
  },
  methods: {
    handleAddNewImage(file, response) {
      this.$store.commit("uploadedImage", { image: response });
      setTimeout(() => {
        this.$refs.myVueDropzone.removeFile(file);
      }, 2000);
    }
  }
};
</script>
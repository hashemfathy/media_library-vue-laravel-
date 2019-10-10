<template>
  <div id="app">
    <b-button v-b-modal.modal-xl variant="primary">xl modal</b-button>
    <b-modal id="modal-xl" size="xl" title="Media">
      <media-library></media-library>
    </b-modal>
  </div>
</template>

<script>
import MediaLibrary from "./MediaLibrary";
export default {
  components: {
    MediaLibrary
  }
};
</script>

<style>
</style>
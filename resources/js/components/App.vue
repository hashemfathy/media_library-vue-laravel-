<template>
  <div id="app">
    <b-button v-b-modal.modal-xl variant="primary">xl modal</b-button>
    <b-modal id="modal-xl" size="xl" title="Media">
      <upload-file></upload-file>
      <main-content></main-content>
    </b-modal>
  </div>
</template>

<script>
import UploadFile from "./UploadFile";
import MainContent from "./MainContent";
export default {
  name: "app",
  components: {
    UploadFile,
    MainContent
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
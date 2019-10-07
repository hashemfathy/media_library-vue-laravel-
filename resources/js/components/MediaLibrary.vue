<template>
  <div>
      <upload-file></upload-file>
      <main-content></main-content>
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
</style>
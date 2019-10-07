<template>
  <div class="container content">
    <div class="row">
      <div class="col-9 files-list p-4 bg-dark">
        <files-list></files-list>
      </div>
      <div class="col-3 file-content">
        <show-file></show-file>
      </div>
    </div>
  </div>
</template>

<script>
import ShowFile from "./main/ShowFile";
import FilesList from "./main/FilesList";
export default {
  components: {
    ShowFile,
    FilesList
  }
};
</script>

<style  scoped>
.content {
  width: 100%;
  height: 100vh;
  background-color: #f1f1f1;
  margin-top: 10px;
  border: 2px solid #ddd;
}
.file-content {
  min-height: 100px;
  border-left: 1px solid #ddd;
  background-color: rgb(175, 169, 169);
}
.files-list {
  min-height: 100px;
  border-left: 1px solid #ddd;}
</style>
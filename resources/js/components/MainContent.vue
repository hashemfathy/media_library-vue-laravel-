<template>
  <div>
    <search></search>
    <div class="container content">
      <div class="row">
        <div class="col-9 files-list p-4 bg-light">
          <files-list></files-list>
        </div>
        <div class="col-3 file-content">
          <show-file></show-file>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Search from "./Search";
import ShowFile from "./main/ShowFile";
import FilesList from "./main/FilesList";
export default {
  components: {
    Search,
    ShowFile,
    FilesList
  }
};
</script>

<style  scoped>
.content {
  width: 100%;
  background-color: #f1f1f1;
  margin-top: 10px;
  border: 2px solid #ddd;
}
.file-content {
  min-height: 100px;
  border-left: 1px solid #ddd;
  background-color: #fff;
  padding: 0;
}
.files-list {
  border-left: 1px solid #ddd;
}
</style>
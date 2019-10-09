<template>
  <div>
    <b-container>
      <div>
        <b-tabs content-class="mt-3">
          <b-tab title="Grid" active @click="activeGrid()">
              <b-row class="scrolled">
                <b-col
                  class="mb-2"
                  cols="3"
                  style="position:relative"
                  v-for="image in images"
                  :key="image.data.id"
                  @click="showImage(image)"
                >
                  <span class="selected" v-if="showedImage && image.data.id === showedImage.data.id"></span>
                  <b-img thumbnail fluid :src="image.url" class="card-img" :alt="image.data.name"></b-img>
                  <input v-if="showChickbox==true" type="checkbox" class="checkbox" :value="image.data.id" v-model="selected" />
                </b-col>
              </b-row>
              <infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
                <div slot="no-more"></div>
              </infinite-loading>
          </b-tab>
          <b-tab title="list" @click="disableGrid()">
              <b-table-simple responsive>
                <b-thead>
                  <b-tr>
                    <b-th><h6><b>select</b></h6></b-th>
                    <b-th sticky-column style="width:20%;"><h6><b>Media</b></h6></b-th>
                    <b-th><h6><b>title</b></h6></b-th>
                    <b-th><h6><b>size</b></h6></b-th>
                    <b-th><h6><b>type</b></h6></b-th>
                    <b-th><h6><b>uploaded </b></h6></b-th>
                  </b-tr>
                </b-thead>
                <b-tbody>
                  <b-tr v-for="image in images" :key="image.data.id" @click="showImage(image)" class="scrolled">
                    <b-th>
                      <label class="form-checkbox">
                        <input type="checkbox" :value="image.data.id" v-model="selected">
                        <i class="form-icon"></i>
                      </label>
                    </b-th>
                    <b-img sticky-column :src="image.url" :alt="image.data.name"></b-img>
                    <b-th><h6>{{image.data.name}}</h6></b-th>
                    <b-th><h6>{{image.data.size/1000}}Kb</h6></b-th>
                    <b-th><h6>{{image.data.mime_type}}</h6></b-th>
                    <b-th><h6>{{image.data.custom_properties.user?image.data.custom_properties.user.name:null}}</h6></b-th>
                  </b-tr>
                 
                </b-tbody>
              </b-table-simple>
              <infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
                <div slot="no-more"></div>
              </infinite-loading>
          </b-tab>
           <template v-slot:tabs-end >
            <b-button v-if="selected[0]" variant="danger" @click="deleteImg()">Delete selected</b-button>
            <b-button v-if="grid==true" variant="primary" @click="showChickboxes()">Bulk select</b-button>
          </template>
        </b-tabs>
      </div>
    </b-container>
    
  </div>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters, mapMutations } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

export default {
  components: {
    InfiniteLoading
  },
  data(){
    return{
      selected: [],
      grid:true,
      showChickbox:false
    }
  },
  computed: {
    ...mapGetters({
      images: "images",
      showedImage: "showedImage",
      meta: "meta"
    }),
    queryParams() {
      return {
        page: this.meta.current_page
      };
    }
  },
  methods: {
    ...mapActions({
      getImages: "getImages",
      deleteImage: "deleteImage",

    }),
    ...mapMutations({
      updateMeta: "updateMeta"
    }),
    showImage(image) {
      this.$store.commit("showImage", { image });
    },
    async infiniteHandler($state) {
      if (this.meta.current_page <= this.meta.last_page) {
        try {
          const response = await this.getImages({
            queryParams: this.queryParams
          });
          this.updateMeta({
            meta: {
              ...this.meta,
              last_page: response.data.meta.last_page
            }
          });
          $state.loaded();
          if (this.meta.current_page == response.data.meta.last_page) {
            $state.complete();
          } else {
            this.updateMeta({
              meta: {
                ...this.meta,
                current_page: response.data.meta.current_page + 1
              }
            });
          }
        } catch (error) {
          console.log("error", error);
        }
      }
    },
    disableGrid(){
      this.grid=false
    },
    activeGrid(){
      this.grid=true
    },
    showChickboxes(){
      this.showChickbox=!this.showChickbox
    },
    async deleteImg() {
      if (this.selected!=null) {
        for(let image in this.selected){
          // console.log(this.selected[image])
            this.deleteImage({
            imageId:this.selected[image]
          });
        }
      }
      this.selected=[];
    }
  }
};
</script>
<style scoped>
.scrolled {
  max-height: 110vh;
  overflow-y: scroll;
}
.selected {
  position: absolute;
  width: 30px;
  height: 30px;
  background-color: green;
  top: 10px;
  right: 0;
  border: 3px solid #fff;
  border-radius: 50%;
}
.checkbox{
  position: absolute;
    top: -3%;
    left: 10%;
    width: 17px;
}
</style>
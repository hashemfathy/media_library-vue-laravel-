<template>
  <div>
    <b-container>
      <div >
        <b-tabs>
          <b-tab title="Grid" active @click="activeGrid()">
            <div v-if="grid">
              <b-row class="scrolled">
                <b-col
                  class="mb-2"
                  cols="3"
                  style="position:relative"
                  v-for="(image,index) in images"
                  :key="index"
                  @click="showImage(image)"
                >
                  <span
                    class="selected"
                    v-if="showedImage && image.data.id === showedImage.data.id"
                  ></span>
                  <b-img
                    thumbnail
                    v-if="imageType(image)"
                    fluid
                    :src="image.url"
                    class="card-img"
                    :alt="image.data.name"
                  ></b-img>
                  <b-img
                    thumbnail
                    v-if="videoType(image)"
                    fluid
                    :src="videoIcon"
                    class="card-img"
                    :alt="image.data.name"
                  ></b-img>
                  <input
                    v-if="showChickbox==true"
                    type="checkbox"
                    class="checkbox"
                    :value="image.data.id"
                    v-model="selected"
                  />
                </b-col>
              </b-row>
              <infinite-loading
                @infinite="infiniteHandler"
                spinner="waveDots"
                ref="infiniteLoading"
              >
                <div slot="no-more"></div>
              </infinite-loading>
            </div>
          </b-tab>
          <b-tab title="list" @click="disableGrid()">
            <div v-if="!grid">
                <b-table-simple responsive>
                  <b-thead>
                    <b-tr>
                      <b-th class="th">
                        <h6>
                          <b>select</b>
                        </h6>
                      </b-th>
                      <b-th sticky-column class="th">
                        <h6>
                          <b>Media</b>
                        </h6>
                      </b-th>
                      <b-th class="th">
                        <h6>
                          <b>title</b>
                        </h6>
                      </b-th>
                      <b-th class="th">
                        <h6>
                          <b>size</b>
                        </h6>
                      </b-th>
                      <b-th class="th">
                        <h6>
                          <b>type</b>
                        </h6>
                      </b-th>
                      <b-th class="th">
                        <h6>
                          <b>uploaded by</b>
                        </h6>
                      </b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr
                      v-for="(image,index) in images"
                      :key="index"
                      @click="showImage(image)"
                      class="scrolled"
                    >
                      <b-th>
                        <label class="form-checkbox">
                          <input type="checkbox" :value="image.data.id" v-model="selected" />
                          <i class="form-icon"></i>
                        </label>
                      </b-th>
                      <b-img
                        sticky-column
                        v-if="imageType(image)"
                        :src="image.url"
                        :alt="image.data.name"
                        style="width:100%;margin:2px;"
                      ></b-img>
                      <b-img
                        sticky-column
                        v-if="videoType(image)"
                        :src="videoIcon"
                        :alt="image.data.name"
                      ></b-img>
                      <b-th>
                        <h6>{{image.data.name}}</h6>
                      </b-th>
                      <b-th>
                        <h6>{{image.data.size/1000}}Kb</h6>
                      </b-th>
                      <b-th>
                        <h6>{{image.data.mime_type}}</h6>
                      </b-th>
                      <b-th>
                        <h6>{{image.data.custom_properties.user?image.data.custom_properties.user.name:null}}</h6>
                      </b-th>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
                <infinite-loading
                  @infinite="infiniteHandler"
                  spinner="waveDots"
                  ref="infiniteLoading"
                >
                  <div slot="no-more"></div>
                </infinite-loading>
            </div>
          </b-tab>
          <template v-slot:tabs-end>
            <b-button  class="delete" v-if="selected[0]" variant="danger" @click="deleteImg()">Delete selected</b-button>
            <b-button class="bulk" v-if="grid==true" variant="primary" @click="showChickboxes()">Bulk select</b-button>
          </template>
        </b-tabs>
      </div>
    </b-container>
  </div>
</template>
<script>
import axios from "axios";
import videoIcon from "../../../../../assets/images/video.png";

import { mapActions, mapGetters, mapMutations } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

export default {
  components: {
    InfiniteLoading
  },
  data() {
    return {
      selected: [],
      grid: true,
      showChickbox: false,
      videoIcon: videoIcon
    };
  },
  computed: {
    ...mapGetters({
      images: "mediaLibrary/images",
      showedImage: "mediaLibrary/showedImage",
      meta: "mediaLibrary/meta",
      queryParams: "mediaLibrary/queryParams"
    })
  },
  methods: {
    ...mapActions({
      getImages: "mediaLibrary/getImages",
      deleteImage: "mediaLibrary/deleteImage"
    }),
    ...mapMutations({
      updateMeta: "mediaLibrary/updateMeta",
      showImageUpdate: "mediaLibrary/showImage",
      updateImages: "mediaLibrary/updateImages"
    }),
    imageType(image) {
      return image.data.mime_type.includes("image");
    },
    videoType(image) {
      return image.data.mime_type.includes("video");
    },
    showImage(image) {
      this.showImageUpdate({ image });
    },
    infiniteHandler($state) {
      if (this.meta.current_page <= this.meta.last_page) {
        this.getImages({
          queryParams: {
            page: this.meta.current_page,
            ...this.queryParams
          }
        }).then(response => {
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
        });
      }
    },
    resetDataForInfiniteLoading() {
      this.updateImages();
      this.showImageUpdate({ image: null });
      this.updateMeta({
        meta: {
          ...this.meta,
          current_page: 1
        }
      });
      this.infiniteHandler(this.$refs.infiniteLoading.stateChanger);
    },
    disableGrid() {
      this.grid = false;
      this.updateImages();
    },
    activeGrid() {
      this.grid = true;
      this.updateImages();
    },
    showChickboxes() {
      this.showChickbox = !this.showChickbox;
    },
    async deleteImg() {
      if (this.selected != null) {
        for (let image in this.selected) {
          this.deleteImage({
            imageId: this.selected[image]
          });
        }
      }
      this.selected = [];
    }
  },
  watch: {
    queryParams: {
      deep: true,
      handler(val) {
        this.resetDataForInfiniteLoading();
      }
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
.checkbox {
  position: absolute;
    top: 7%;
    left: 12%;
    width: 16px;
    transform: scale(1.5);
}
.th{
width:160px;
}
h6{
  text-align: center;
}
.bulk{
   position: absolute;
    right: 32px;
    margin: 3px;
}
.delete{
  position: absolute;
    right: 140px;
    margin: 3px;
}
</style>
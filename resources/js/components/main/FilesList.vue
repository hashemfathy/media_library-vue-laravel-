<template>
  <div>
    <b-container>
      <div>
        <b-tabs content-class="mt-3">
          <b-tab title="Grid" active>
            <b-row class="scrolled">
              <b-col
                class="mb-2"
                cols="3"
                style="position:relative"
                v-for="image in images"
                :key="image.id"
                @click="showImage(image)"
              >
                <span class="selected" v-if="showedImage && image.data.id === showedImage.data.id"></span>
                <b-img
                  thumbnail
                  fluid
                  v-if="imageType(image)"
                  :src="image.url"
                  class="card-img"
                  :alt="image.data.name"
                ></b-img>

                <i class="fa fa-user"></i>
                <b-img
                  thumbnail
                  fluid
                  v-if="videoType(image)"
                  :src="videoIcon"
                  class="card-img"
                  :alt="image.data.name"
                ></b-img>
              </b-col>
            </b-row>
            <infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
              <div slot="no-more"></div>
            </infinite-loading>
          </b-tab>
          <b-tab title="list">
            <b-table-simple responsive>
              <b-thead>
                <b-tr>
                  <b-th sticky-column style="width:20%;">
                    <h6>
                      <b>Media</b>
                    </h6>
                  </b-th>
                  <b-th>
                    <h6>
                      <b>title</b>
                    </h6>
                  </b-th>
                  <b-th>
                    <h6>
                      <b>size</b>
                    </h6>
                  </b-th>
                  <b-th>
                    <h6>
                      <b>type</b>
                    </h6>
                  </b-th>
                  <b-th>
                    <h6>
                      <b>uploaded</b>
                    </h6>
                  </b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr
                  v-for="image in images"
                  :key="image.id"
                  @click="showImage(image)"
                  class="scrolled"
                >
                  <b-img sticky-column :src="image.url" :alt="image.data.name"></b-img>
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
            <infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
              <div slot="no-more"></div>
            </infinite-loading>
          </b-tab>
        </b-tabs>
      </div>
    </b-container>
  </div>
</template>
<script>
import axios from "axios";
import videoIcon from "../../../assets/images/video.png";

import { mapActions, mapGetters, mapMutations } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

export default {
  components: {
    InfiniteLoading
  },
  data() {
    return {
      videoIcon: videoIcon
    };
  },
  computed: {
    ...mapGetters({
      images: "images",
      showedImage: "showedImage",
      meta: "meta",
      queryParams: "queryParams"
    })
  },
  methods: {
    ...mapActions({
      getImages: "getImages"
    }),
    ...mapMutations({
      updateMeta: "updateMeta"
    }),
    imageType(image) {
      return image.data.mime_type.includes("image");
    },
    videoType(image) {
      return image.data.mime_type.includes("video");
    },
    showImage(image) {
      this.$store.commit("showImage", { image });
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
      this.$store.state.images = [];
      this.$store.state.image = null;
      this.updateMeta({
        meta: {
          ...this.meta,
          current_page: 1
        }
      });
      this.infiniteHandler(this.$refs.infiniteLoading.stateChanger);
    }
  },
  watch: {
    queryParams: {
      deep: true,
      handler(val) {
        console.log("watch-queryParams");

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
</style>
<template>
  <div>
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
        <b-img thumbnail fluid :src="image.url" class="card-img" :alt="image.data.name"></b-img>
      </b-col>
    </b-row>
    <infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
      <div slot="no-more"></div>
    </infinite-loading>
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
      getImages: "getImages"
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
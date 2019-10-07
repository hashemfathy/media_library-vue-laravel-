<template>
  <b-row class="scrolled">
    <b-col class="mb-2" cols="3" v-for="image in images" :key="image.id" @click="showImage(image)">
      <b-img thumbnail fluid :src="image.url" class="card-img" alt="..."></b-img>
    </b-col>
  </b-row>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  async mounted() {
    await this.getImages({
      page: 1
    });
  },
  computed: {
    ...mapGetters({
      images: "images"
    })
  },
  methods: {
    ...mapActions({
      getImages: "getImages"
    }),

    showImage(image) {
      this.$store.commit("showImage", { image });
    }
  }
};
</script>
<style scoped>
.scrolled {
  max-height: 110vh;
  overflow-y: scroll;
}
</style>
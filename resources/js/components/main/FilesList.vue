<template>
  <div>
    <b-container>
      <div>
        <b-tabs content-class="mt-3">
          <b-tab title="Grid" active>
            <b-row >
              <b-col class="mb-2" cols="3" v-for="image in images" :key="image.id" @click="showImage(image)">
                <b-img  thumbnail fluid :src="image.url" class="card-img" alt="..."></b-img>
              </b-col>
            </b-row>
          </b-tab>
          <b-tab title="list">
              <b-table-simple responsive>
                <b-thead>
                  <b-tr>
                    <b-th sticky-column style="width:20%;"><h6><b>Media</b></h6></b-th>
                    <b-th><h6><b>title</b></h6></b-th>
                    <b-th><h6><b>size</b></h6></b-th>
                    <b-th><h6><b>type</b></h6></b-th>
                    <b-th><h6><b>uploaded </b></h6></b-th>
                  </b-tr>
                </b-thead>
                <b-tbody>
                  <b-tr v-for="image in images" :key="image.id" @click="showImage(image)">
                    <b-img sticky-column :src="image.url" :alt="image.data.name"></b-img>
                    <b-th><h6>{{image.data.name}}</h6></b-th>
                    <b-th><h6>{{image.data.size/1000}}Kb</h6></b-th>
                    <b-th><h6>{{image.data.mime_type}}</h6></b-th>
                    <b-th><h6>{{image.data.custom_properties.user?image.data.custom_properties.user.name:null}}</h6></b-th>
                  </b-tr>
                 
                </b-tbody>
              </b-table-simple>
          </b-tab>
        </b-tabs>
      </div>
    </b-container>
  </div>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
      return {
        
      }
    },
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
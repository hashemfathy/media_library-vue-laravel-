<template>
  <div class="file" v-if="image">
    <b-card
    :title="image.data.name"
    :img-src="image.url"
    :img-alt="image.data.name"
    img-top
    tag="article"
    style="max-width: 20rem;"
    class="mb-2"
  >
    <b-card-text>
        <p><b>Size: </b>{{image.data.size/1000}}Kb</p>
        <p><b>uploaded at: </b>{{image.data.created_at}}</p>
        <p v-if="image.data.custom_properties.user"><b>uploaded by: </b>{{image.data.custom_properties.user.name}}</p>
        <p><b>type: </b>{{image.data.mime_type}}</p>
        <p><b>Url: </b>{{image.url}}</p>
      <b-form>
        <b-form-group
          id="input-group-1"
          label="title"
          label-for="input-1"
          >
          <b-form-input
            id="input-1"
            v-model="form.title"
            type="text"
            name="title"
            :placeholder="image.data.name"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="input-group-2"
          label="description"
          label-for="input-2"
          >
          <b-form-textarea
            id="textarea"
            v-model="form.description"
            :placeholder="image.data.custom_properties.information?image.data.custom_properties.information.description:null"
            rows="3"
            name="description"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>
        <b-form-group
          id="input-group-3"
          label="caption"
          label-for="input-3"
          >
          <b-form-textarea
            id="textarea"
            v-model="form.caption"
            :placeholder="image.data.custom_properties.information?image.data.custom_properties.information.caption:null"
            rows="3"
            name="caption"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>
      </b-form>
    </b-card-text>

    <b-button variant="danger" @click="deleteImg">Delete</b-button>
  </b-card>
  </div>
</template>
<script>
import _ from "lodash";
import axios from "axios";
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      form: {
         title: null,
        description: null,
        caption: null
      }
    };
  },
  methods: {
    ...mapActions({
      deleteImage: "deleteImage",
      updateShowedImage: "updateShowedImage"
    }),
    deleteImg() {
      if (this.image) {
        this.deleteImage({
          imageId: this.image.data.id
        });
      }
    }
  },
  computed: {
    image() {
      return this.$store.getters.showedImage;
    },
    checkImageCustomProperties() {
      return this.image && this.image.data && this.image.data.custom_properties;
    }
  },
  watch: {
    image(newVal){
      this.form.title = newVal.data.name
      this.form.description = newVal.data.custom_properties.information ? newVal.data.custom_properties.information.description : null  
      this.form.caption = newVal.data.custom_properties.information ? newVal.data.custom_properties.information.caption : null
      
    },
    "form.title": _.debounce(function(newVal, oldVal) {
      this.updateShowedImage({
        imageId: this.image.data.id,
        information: this.form
      });
    }, 2000),

    "form.description": _.debounce(function(newVal, oldVal) {
      this.updateShowedImage({
        imageId: this.image.data.id,
        information: this.form
      });
    }, 2000),
    "form.caption": _.debounce(function(newVal, oldVal) {
      this.updateShowedImage({
        imageId: this.image.data.id,
        information: this.form
      });
    }, 2000)
  }
};
</script>
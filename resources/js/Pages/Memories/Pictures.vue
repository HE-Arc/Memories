<template>
  <Head title="Edit Pictures" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Edit Pictures</h2>
    </template>
    <Link :href="route('memories.show', memory.id)" class="btn btn-info"
      ><i class="fa fa-reply"></i
    ></Link>
    <br /><br />
    <h3>{{ memory.name }}</h3>
    <p>{{ memory.date }}</p>
    <ImagesUploader @updateData="updatePictures" :id="memory.id" />

    <div class="row form-group">
      <div class="col-md-3" v-for="(image, key) in this.images" :key="key">
        <div class="img-thumbnail">
          <img
            class="myImg img-responsive"
            :src="this.path + image.picture_name"
            :alt="image.picture_name"
          /><br /><br />
          <div class="row form-group">
            <span class="col-md-1"></span>
            <button @click="destroy(image.id)" class="btn btn-danger col-md-2">
              <i class="fa fa-trash"></i></button
            >&nbsp;
            <span class="col-md-4"></span>
            <button @click="shiftLeft(image.id)" class="btn btn-info col-md-2">
              <i class="fa fa-arrow-left"></i></button
            >&nbsp;
            <button @click="shiftRight(image.id)" class="btn btn-info col-md-2">
              <i class="fa fa-arrow-right"></i>
            </button>
            <span class="col-md-1"></span>
          </div>
        </div>
      </div>
    </div>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ImagesUploader from "@/Components/Form/ImagesUploader.vue";
import VueSimpleAlert from "vue3-simple-alert";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    ImagesUploader,
  },
  props: ["memory", "img", "src"],
  data() {
    return {
      path: "",
      images: null,
      delete_state: null,
    };
  },
  mounted() {
    if (this.img) {
      this.images = this.img;
    }
    if (this.src) {
      this.path = this.src;
    }
  },
  methods: {
    updatePictures(data) {
      this.path = data.path;
      this.images = data.images;
    },
    destroy(id) {
      VueSimpleAlert.confirm("Are you sure?")
        .then(async () => {
          await axios.delete(route("memorypictures.destroy", id));
          this.images = this.images.filter((image) => image.id !== id);
        })
        .catch(() => {});
    },
    shiftLeft(id) {
      var idx = this.images.findIndex((img) => img.id == id);
      if (idx > 0) {
        this.swap(idx, idx - 1);
      }
    },
    shiftRight(id) {
      var idx = this.images.findIndex((img) => img.id == id);
      if (idx < this.images.length - 1) {
        this.swap(idx, idx + 1);
      }
    },
    async swap(idx1, idx2) {
      await axios.post(route("memorypictures.order"), {
        id1: this.images[idx1].id,
        id2: this.images[idx2].id,
      });

      var tmp = this.images[idx1];
      this.images[idx1] = this.images[idx2];
      this.images[idx2] = tmp;
    },
  },
};
</script>
<style>
.myImg {
  height: 20em;
  width: 100%;
  object-fit: cover;
}
</style>

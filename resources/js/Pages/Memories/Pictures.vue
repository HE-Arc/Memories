<template>
  <Head title="Edit Pictures" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Edit Pictures</h2>
    </template>
    <Link :href="route('memories.show', memory.id)" class="btn btn-info"><i class="fa fa-reply"></i></Link>
    <br>
    <h3>{{memory.name}}</h3>
    <p>{{memory.date}}</p>
    <ImagesUploader @updateData="updatePictures" :id="memory.id"/>

    <div class="flex flex-wrap mt-8">
        <img v-for="(image, key) in this.images"
             :key="key"
             :src="this.path + image.picture_name"
             class="w-48 h-46 object-cover mr-4 mb-4 shadow rounded">
      </div>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ImagesUploader from "@/Components/Form/ImagesUploader.vue";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    ImagesUploader
  },
  props: ['memory',],
   data() {
    return {
      path: "",
      images: null
    }
  },
  methods:{
        updatePictures(data) {
        this.path = data.path;
        this.images = data.images;
        console.log(data);
    }

  }
};
</script>

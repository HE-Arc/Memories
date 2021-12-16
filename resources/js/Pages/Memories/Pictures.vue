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
    <ImagesUploader :id="memory.id"/>
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
  props: ['memory'],
  methods:{

  }
};
</script>

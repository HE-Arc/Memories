<template>
  <Head title="Show a new Memory" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Show a new Memory</h2>
    </template>

    <Link :href="route('memories.show', memory.id)" class="btn btn-info"><i class="fa fa-pencil-square-o"></i></Link>
    <button @click="destroy(memory.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>

    <h3>{{memory.name}}</h3>
    <p>{{memory.date}}</p>
    <div v-html="memory.description" />


  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
  },
  props: ['memory'],
  methods:{
       destroy(id) {
          Inertia.delete(route('memories.destroy', id));
      }
  }
};
</script>

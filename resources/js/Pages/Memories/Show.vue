<template>
  <Head title="Show a new Memory" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Show a new Memory</h2>
    </template>

    <Link :href="route('memories.index')" class="btn btn-info"><i class="fa fa-home"></i></Link>&nbsp;
    <span v-if="auth.user.id == memory.user_id">
        <Link :href="route('memories.edit', memory.id)" class="btn btn-success"><i class="fa fa-pencil-square-o"></i></Link>&nbsp;
        <Link :href="route('memorypictures.edit', memory.id)" class="btn btn-success"><i class="fa fa-image"></i></Link>&nbsp;
        <button @click="destroy(memory.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button><br><br>
    </span>
    <h1>{{memory.name}}</h1>
    <p>Author : {{auth.user.name}}</p>
    <p>Visited : {{this.parseDate(memory.visited_date)}}</p>
    <SlideShow v-if="memory.pictures" :pictures="this.memory.pictures" :user_id="this.auth.user.id" /><br>
    <div v-html="memory.description" />
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SlideShow from "@/Components/Form/SlideShow.vue";
import { Inertia } from '@inertiajs/inertia'


export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    SlideShow
  },
  props: ['memory','auth'],
  methods:{
       destroy(id) {
          Inertia.delete(route('memories.destroy', id));
      },
       parseDate: function (date) {
        return moment(date).format('YYYY-MM-DD');
        },
  }
};
</script>

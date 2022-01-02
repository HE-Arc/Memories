<template>
  <Head title="Show a Memory" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Show a Memory</h2>
    </template>

    <Link :href="route('memories.index')" class="btn btn-info"
      ><i class="fa fa-home"></i></Link
    >&nbsp;
    <span v-if="auth.user.id == memory.user_id">
      <Link :href="route('memories.edit', memory.id)" class="btn btn-success"
        ><i class="fa fa-pencil-square-o"></i></Link
      >&nbsp;
      <Link
        :href="route('memorypictures.edit', memory.id)"
        class="btn btn-success"
        ><i class="fa fa-image"></i></Link
      >&nbsp;
      <button @click="destroy(memory.id)" class="btn btn-danger">
        <i class="fa fa-trash"></i>
      </button> </span
    ><br /><br />
    <h1>{{ memory.name }}</h1>
    <p>Author : {{ memory.user.name }}</p>
    <p>Visited : {{ this.parseDate(memory.visited_date) }}</p>
    <p>Publishing : {{ memory.publishing }}</p>
    <SlideShow
      v-if="memory.pictures"
      :pictures="this.memory.pictures"
      :user_id="this.memory.user.id"
    /><br />
    <div id="confirm"></div>

    <div v-html="memory.description" />
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SlideShow from "@/Components/Form/SlideShow.vue";
import { Inertia } from "@inertiajs/inertia";
import VueSimpleAlert from "vue3-simple-alert";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    SlideShow,
  },
  props: ["memory", "auth"],
  methods: {
    destroy(id) {
      VueSimpleAlert.confirm("Are you sure?").then(() => {
        Inertia.delete(route("memories.destroy", id));
      }).catch(()=>{});
    },
    parseDate: function (date) {
      return moment(date).format("YYYY-MM-DD");
    },
  },
};
</script>

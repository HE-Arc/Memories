<template>
    <Head title="Memories"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Memories
            </h2>
        </template>

        <div class="mb-4">
            <h2>Mes Memories</h2>
            <Link :href="route('memories.create')" class="btn btn-outline-success mb-2">create a new memory</Link>
            <div class="row">
                <Card v-for="memory in memories" :key="memory.id" :name="memory.name" :id="memory.id" :picture="'/storage/' + id + '/' + memory.id + '/' + memory.pictures[0].picture_name"/>
            </div>
        </div>

        <div class="mb-4">
            <h2>Memories de mes amis</h2>
        </div>
    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import moment from 'moment'
import Card from '@/Pages/Memories/Tools/Card.vue'



export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    Card
  },
    props: [
      "memories","id"
  ],
  methods: {
      parseDate: function (date) {
        return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
  }
}
</script>
<style>

</style>

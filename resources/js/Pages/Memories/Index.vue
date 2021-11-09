<template>
    <Head title="Memories"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Memories
            </h2>
        </template>
        <!-- Page content here-->

        <h1>Memories</h1>

        <Link :href="route('memories.create')" class="btn btn-primary mb-2">create</Link>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">name</th>
                    <th>lat</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="memory in memories" :key="memory.id">
                    <td>{{ memory.name }}</td>
                    <td>{{memory.location.coordinates[0]}}</td>
                </tr>

            </tbody>
        </table>
    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
  },
    props: [
      "memories"
  ],
  methods: {
      destroy(id) {
          Inertia.delete(route('memories.destroy', id));
      }
  }
}
</script>

<template>
    <Head title="Memories"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Memories
            </h2>
        </template>
        <!-- Page content here-->


        <h1>Memories 2000</h1>

        <Link :href="route('memories.create')" class="btn btn-outline-success mb-2">create a new memory</Link>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Creation date</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="memory in memories" :key="memory.id">
                    <td>{{ memory.name }}</td>
                    <td>{{ parseDate(memory.created_at) }}</td>
                    <td class="text-center"><Link :href="route('memories.show', memory.id)" class="btn btn-info"><i class="fa fa-pencil-square-o"></i></Link>
                    <button @click="destroy(memory.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import moment from 'moment'


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
      },
      parseDate: function (date) {
        return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
  }
}
</script>

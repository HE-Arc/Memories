<template>
    <Head title="Memories"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Memories
            </h2>
        </template>

        <div class="mb-4">
            <h2>My Memories</h2>
            <Link :href="route('memories.create')" class="btn btn-outline-success mb-2">create a new memory</Link>
            <div class="row">
                <Card v-for="memory in memories.data" :key="memory.id" :user_id="auth.user.id" :memory="memory"/>
            </div><br>
            <Pagination class="mt-6" :links="memories.links" />
        </div>

        <div class="mb-4">
            <MemoriesMap :myMemories="memories"
                         :memoriesFriends="memoriesFriends"
                         :publicMemories="publicMemories"
                         :currentUser="auth.user"/>
        </div>
    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import moment from 'moment'
import Card from '@/Components/Form/CardMemory.vue'
import MemoriesMap from '@/Components/Form/MemoriesMap.vue'
import Pagination from '@/Components/Pagination.vue'



export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    Card,
    Pagination,
    MemoriesMap
  },
    props: [
      "memories","id","auth","memoriesFriends","publicMemories"
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

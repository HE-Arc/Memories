<template>
    <Head title="Amis"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Amis
            </h2>
        </template>
        <!-- Page content here-->

        <h2>Nouvelle demande d'ami</h2>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher...">
            <div class="input-group-append">
                <button class="btn btn-success" type="button">Ajouter</button>
            </div>
        </div>

        <h2>Mes amis</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="friendConfirmed in friendsConfirmed" :key="friendConfirmed.id">
                    <td>{{ friendConfirmed.name }}</td>
                    <button @click="destroy(friend.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </tr>
            </tbody>
        </table>

        <h2>Demande en attente</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="friendPending in friendsPending" :key="friendPending.id">
                    <td>{{ friendPending.name }}</td>
                    <button class="btn btn-success"><i class="fa fa-plus-square"></i></button>
                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
import FlashMessages from '@/Components/Tools/FlashMessages.vue'



export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    FlashMessages

  },
    props: [
      "friendsConfirmed",
      "friendsPending"
  ],
  methods: {

  }
}
</script>

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
        <form @submit.prevent="form.post(route('friends.store'))">
        <div class="form-group row">
          <div class="card">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-12">
                  <InputLabel
                    v-model="form.name"
                    :inputId="'name'"
                    :labelText="'name'"
                    :formError="form.errors.title"
                  />                  <ul class="list-group" v-if="results.length > 0 && form.name">
                    <li class="list-group-item list-group-item-action" v-for="result in results.slice(0,10)" :key="result.id">
                        <div @click="addValueToInput(result.title)" v-text="result.title"></div>
                    </li>
                  </ul>
                </div>

                <breeze-validation-errors class="mt-3" />

                <button
                  type="submit"
                  class="btn btn-outline-success mt-4"
                  :disabled="form.processing">
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
    </form>

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
                    <button @click="destroy(friendConfirmed.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
                    <button @click="update(friendPending.id)" class="btn btn-success"><i class="fa fa-plus-square"></i></button>
                    <button @click="destroy(friendPending.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </tr>
            </tbody>
        </table>

    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import InputLabel from "@/Components/Form/InputLabel.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    InputLabel,
    BreezeValidationErrors,
  },
    props: [
      "friendsConfirmed",
      "friendsPending"
  ],
  data() {
    return {
      form: useForm({
        name: null
      }),
      results: []
    };
  },
  watch: {
  'form.name': function (newVal, oldVal){
        this.searchMembers();
     },

},
  methods: {
      destroy(id) {
          Inertia.delete(route('friends.destroy', id));
      },
      update(id) {
          Inertia.put(route('friends.update', id));
      },
      searchMembers() {
        axios.get('friends/search', { params: { name: this.form.name } })
        .then(response => this.results = response.data)
        .catch(error => {});
      },
      addValueToInput(username) {
        this.form.name = username;
      },
  }
}
</script>

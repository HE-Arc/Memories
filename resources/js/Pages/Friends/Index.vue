<template>
    <Head title="Amis"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Amis
            </h2>
        </template>

        <h2>Nouvelle demande d'ami</h2>

        <form @submit.prevent="form.post(route('friends.store'))">
          <div class="mb-4">
          <div class="form-group row">
            <div class="card">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-12">
                    <InputLabel
                      v-model="form.name"
                      :inputId="'name'"
                      :labelText="'Name'"
                      :formError="form.errors.title"
                    />
                    <ul class="list-group" v-if="results.length > 0 && form.name">
                      <li class="list-group-item list-group-item-action" v-for="result in results.slice(0,10)" :key="result.id">
                          <a href="#" @click="addValueToInput(result.title)" v-text="result.title"></a>
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
        </div>
        </form>

        <div class="mb-4">
            <h2>Mes Amis</h2>
            <div class="row">
                <CardFriends v-for="friendConfirmed in friendsConfirmed" :key="friendConfirmed.id" :name="friendConfirmed.name" :id="friendConfirmed.id"/>
            </div>
        </div>

        <div class="mb-4">
          <h2>Demande en attente</h2>
          <div class="row">
                <CardFriends v-for="friendPending in friendsPending" :key="friendPending.id" :name="friendPending.name" :id="friendPending.id" :pending="true"/>
          </div>
        </div>

    </breeze-authenticated-layout>

</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import InputLabel from "@/Components/Form/InputLabel.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import CardFriends from '@/Pages/Memories/Tools/CardFriends.vue'

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    InputLabel,
    BreezeValidationErrors,
    CardFriends
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
<style>
a{
  text-decoration: none;
  color: black;
}
</style>

<template>
    <Head title="Friends"/>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Friends
            </h2>
        </template>

        <h2>Nouvelle demande d'ami</h2>

        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-8 col-lg-6">
                    <form @submit.prevent="form.post(route('friends.store'))" class="form-example">
                      <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <InputLabel
                                  v-model="form.name"
                                  :inputId="'name'"
                                  :labelText="'Name'"
                                  :formError="form.errors.title"/>
                                <ul class="list-group" v-if="results.length > 0 && form.name">
                                  <li class="list-group-item list-group-item-action" v-for="result in results.slice(0,10)" :key="result.id">
                                      <a class="custom-a" href="#" @click="addValueToInput(result.title)" v-text="result.title"></a>
                                  </li>
                                </ul>
                            </div>
                            <breeze-validation-errors class="mt-3"/>
                            <button type="submit" class="btn btn-success btn-sm btn-custom" :disabled="form.processing">Add</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h2>Mes Amis</h2>
            <CardFriends v-for="friendConfirmed in friendsConfirmed" :key="friendConfirmed.id" :name="friendConfirmed.name" :id="friendConfirmed.id"/>
        </div>

        <div class="mb-4">
          <h2>Demande en attente</h2>
          <CardFriends v-for="friendPending in friendsPending" :key="friendPending.id" :name="friendPending.name" :id="friendPending.id" :pending="true"/>
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

.custom-a{
  text-decoration: none;
  color: black;
}

</style>

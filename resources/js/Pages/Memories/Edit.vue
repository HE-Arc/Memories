<template>
  <Head title="Add a new Memory" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">Add a new Memory</h2>
    </template>

    <Link :href="route('memories.show', memory.id)" class="btn btn-info"><i class="fa fa-reply"></i></Link><br><br>

    <form @submit.prevent="form.put(route('memories.update',memory))">
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
                </div>
                <div class="form-row">
                  <div class="form-group col-12">
                    <InputLabel
                      v-model="form.visited_date"
                      :inputId="'visited_date'"
                      :labelText="'Visited date'"
                      :formError="form.errors.visited_date"
                      :inputType="'date'"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <br />
                  <div class="form-group col-12">
                    <label for="description">Description</label>
                    <vue-editor
                      v-model="form.description"
                      :id="'description'"
                      :editorToolbar="customToolbar"
                    ></vue-editor>
                  </div>
                </div>
                <div class="form-row">
                  <br />
                  <div class="form-group col-12">
                    <SelectPrivacy v-model="form.publishing" :selectId="'privacy'" />
                  </div>
                </div><br>
                <label>Choose a location :</label>
                <CustomMap v-model="form.latlng" :init="form.latlng"/>

                <breeze-validation-errors class="mt-3" />

                <button
                  type="submit"
                  class="btn btn-outline-success mt-4"
                  :disabled="form.processing"
                >
                  Update
                </button>
              </div>
            </div>
          </div>
        </div>
    </form>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/Form/InputLabel.vue";
import CustomMap from "@/Components/Form/CustomMap.vue";
import SelectPrivacy from "@/Components/Form/SelectPrivacy.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { VueEditor } from "vue3-editor";
import Label from '@/Components/Label.vue';
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    InputLabel,
    BreezeValidationErrors,
    VueEditor,
    SelectPrivacy,
    CustomMap,
    Label,
  },
  props: ['memory'],
  data() {
    return {
      form: useForm({
        name: this.memory.name,
       // visited_date: this.memory.visited_date,
        visited_date: moment(this.memory.visited_date).format('YYYY-MM-DD'),
        description: this.memory.description,
        publishing: this.memory.publishing,
        latlng: [this.memory.location.coordinates[1],this.memory.location.coordinates[0]],
      }),
      customToolbar: [
        [{ font: [] }],
        [{ header: [false, 1, 2, 3, 4, 5, 6] }],
        [{ size: ["small", false, "large", "huge"] }],
        ["bold", "italic", "underline", "strike"],
        [
          { align: "" },
          { align: "center" },
          { align: "right" },
          { align: "justify" },
        ],
        [{ header: 1 }, { header: 2 }],
        ["blockquote", "code-block"],
        [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
        [{ indent: "-1" }, { indent: "+1" }],
        [{ color: [] }, { background: [] }],
      ],
    };
  },
};
</script>

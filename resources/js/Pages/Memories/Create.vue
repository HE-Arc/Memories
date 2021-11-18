<template>
    <Head title="Add a new Memory" />

    <breeze-authenticated-layout>
        <template #header>
        <h2 class="h4 font-weight-bold">
            Add a new Memory
        </h2>
        </template>

        <Link :href="route('memories.index')" class="btn btn-primary mb-2">Retour</Link>

        <form @submit.prevent="form.post(route('memories.store'))">
            <div class="row">
                <div class="col-12 col-lg-6 offset-0 offset-lg-3">
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
                            <div class="form-row"><br>
                                <div class="form-group col-12">
                                    <label for="description">Description</label>
                                    <vue-editor v-model="content" :id="'description'" :editorToolbar="customToolbar"></vue-editor>
                                </div>
                            </div>
                            <div class="form-row"><br>
                                <div class="form-group col-12">
                                    <SelectPrivacy/>
                                </div>
                            </div>

                                <breeze-validation-errors class="mt-3" />

                                <button type="submit" class="btn btn-outline-success mt-4"
                                :disabled="form.processing">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, useForm, Link } from '@inertiajs/inertia-vue3'
import InputLabel from '@/Components/Form/InputLabel.vue'
import SelectPrivacy from '@/Components/Form/SelectPrivacy.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { VueEditor } from "vue3-editor";
export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        InputLabel,
        BreezeValidationErrors,
        VueEditor,
        SelectPrivacy
    },
    props: [],
    data() {
        return {
            form: useForm({
                name: null,
                date_visited: null,
                description: null,
                publishing: null,
            }),
            customToolbar: [
               [{ 'font': [] }],
               [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
               [{ 'size': ['small', false, 'large', 'huge'] }],
               ['bold', 'italic', 'underline', 'strike'],
               [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
               [{ 'header': 1 }, { 'header': 2 }],
               ['blockquote', 'code-block'],
               [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
               [{ 'indent': '-1'}, { 'indent': '+1' }],
               [{ 'color': [] }, { 'background': [] }],
            ]
        }
    },
}
</script>

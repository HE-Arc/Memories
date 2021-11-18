<template>
    <Head title="Ajouter un nouveau livre" />

    <breeze-authenticated-layout>
        <template #header>
        <h2 class="h4 font-weight-bold">
            Ajouter un nouveau memory
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
                                        :inputId="'inputName'"
                                        :labelText="'Name'"
                                        :formError="form.errors.name"
                                    />
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group col-6">
                                        <InputLabel
                                            v-model="form.visited_date"
                                            :inputId="'visited_date'"
                                            :labelText="'Visited date'"
                                            :formError="form.errors.visited_date"
                                            :type="date"
                                        />
                                    </div>
                                </div>

                                <breeze-validation-errors class="mt-3" />

                                <button type="submit" class="btn btn-primary mt-3" :disabled="form.processing">Envoyer</button>
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
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        InputLabel,
        BreezeValidationErrors,
    },
    props: ['authors'],
    data() {
        return {
            form: useForm({
                title: null,
                pages: null,
                quantity: null,
                author_id: null,
            })
        }
    },
}
</script>

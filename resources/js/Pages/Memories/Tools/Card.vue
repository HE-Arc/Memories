<template>
    <div class="col-md-4 col-sm-6">
        <Link :href="route('memories.create')" class="card">
            <div class="card-body">
                <h5 class="card-title">{{ name }}</h5>
            </div>
        </Link>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'


export default {
    props: ['name'],
    components: {
        Head,
        Link,
    }
}
</script>

<style>

</style>

<template>
    <div class="col-md-4">
        <Link :href="route('memories.show',id)" class="card">
            <div class="card-body">
                <h5 class="card-title">{{ name }}</h5>
            </div>
        </Link>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'


export default {
    props: ['name','id'],
    components: {
        Head,
        Link,
    }
}
</script>
<style>

.card{
    margin-top: 1rem;
    text-decoration: none;
    color: black;
}

</style>

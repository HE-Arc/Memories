<template>
    <div class="col-md-4">
        <Link :href="route('memories.show',id)" class="card">
            <div class="card-body">
                <img class="myImg  img-responsive" :src="picture" :alt="picture" >
                <h5 class="card-title">{{ name }}</h5>
            </div>
        </Link>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'


export default {
    props: ['name','id','picture'],
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
    text-align: center;
}
.myImg
{
    height: 10em;
    width: 100%;
    object-fit: cover;
}

</style>

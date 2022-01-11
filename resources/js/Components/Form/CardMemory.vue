<template>
    <div class="col-md-4">
        <Link :href="route('memories.show',memory.id)" class="card myCard">
            <div class="card-body">
                <img v-if="memory.pictures.length" class="myImg  img-responsive" :src="'/storage/' + user_id + '/' + memory.id + '/' + memory.pictures[0].picture_name" :alt="memory.pictures[0].picture_name" >
                <img v-else class="myImg  img-responsive" src="/storage/default.jpg" alt="default" >
                <h3 class="card-title">{{ memory.name }}</h3>
            </div>
        </Link>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'


export default {
    props: ['memory','user_id'],
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
.myCard
{
    text-align: center;
}
.card-title
{
    margin-top: 1rem;
}
.myImg
{
    height: 10em;
    width: 100%;
    object-fit: cover;
}

</style>

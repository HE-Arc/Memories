<template>
    <div class="row  soft-padding  margin-zero" >
        <div class="container border-solid-black" id="mapContainer"></div>
    </div>
</template>


<script>

import "leaflet/dist/leaflet.css"
import L from "leaflet"


export default {
    name: "LeafletMap",
    components: {
    },
    props: [],
    data() {
        return {
        map: null,
        }
      },
    mounted() {

        this.map = L.map("mapContainer");

        L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(this.map);


        this.map.locate({
            setView: true,
            maxZoom: 20,
            enableHighAccuracy: true
        })
    },
    onBeforeUnmount() {
        if (this.map) {
        this.map.remove();
        }
    },
    methods: {

    }
}
</script>

<style scoped>
    #mapContainer {
    width: 45vw;
    height: 45vh;
    }
</style>

<template>
  <div class="row soft-padding margin-zero">
    <div class="container border-solid-black" id="mapContainer"></div>
     <input
        :value="latlng"
        @input="$emit('update:latlng', $event.target.value)"
        :type="inputType"
        :id="inputId"

    >
  </div>
</template>


<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";

export default {
  name: "LeafletMap",
  components: {},
  props: ['latlng'],
  emits: ['update:latlng'],
  data() {
    return {
      map: null,
      marker: null,
      currentPosMarker: null,
      latlng: null,
      //https://github.com/pointhi/leaflet-color-markers
      greenIcon: new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      }),
      redIcon: new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      }),
    };
  },
  mounted() {

    this.map = L.map("mapContainer");


    L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(this.map);

    this.map.on('click', e => {
        this.latlng  = [e.latlng.lat,e.latlng.lng];

        if(this.marker == null)
        {
            this.marker = L.marker(this.latlng, {
                icon: this.greenIcon,
                }).addTo(this.map);
        }
        else
        {
            this.marker.setLatLng(this.latlng).update();
        }
    });

    this.map.locate({
      setView: true,
      maxZoom: 10,
      enableHighAccuracy: true,
    });

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        this.latlng = [position.coords.latitude,position.coords.longitude];
        this.currentPosMarker = L.marker(this.latlng, {
          icon: this.redIcon,
        }).addTo(this.map);
      });
    }
  },
  onBeforeUnmount() {
    if (this.map) {
      this.map.remove();
    }
  },
  methods: {
  },
};
</script>

<style scoped>
#mapContainer {
  width: 45vw;
  height: 45vh;
}
</style>

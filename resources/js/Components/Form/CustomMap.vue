<template>
  <div class="row soft-padding margin-zero">
    <div class="container border-solid-black" id="mapContainer"></div>
    <input :value="latlng" :type="inputType" :id="inputId" hidden />
  </div>
</template>


<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import LeafletSearch from "leaflet-search";

export default {
  name: "LeafletMap",
  components: {},
  props: ["modelValue","init"],
  emits: ["update:modelValue"],
  data() {
    return {
      map: null,
      marker: null,
      currentPosMarker: null,
      latlng: this.modelValue,
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

    this.map.addControl(
      new L.Control.Search({
        url: "https://nominatim.openstreetmap.org/search?format=json&q={s}",
        jsonpParam: "json_callback",
        propertyName: "display_name",
        propertyLoc: ["lat", "lon"],
        marker: L.circleMarker([0, 0], { radius: 30 }),
        autoCollapse: true,
        autoType: true,
        minLength: 2,
      })
    );

    L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(this.map);

    this.map.on("click", (e) => {
      this.latlng = [e.latlng.lat, e.latlng.lng];
      this.$emit("update:modelValue", this.latlng);

      if (this.marker == null) {
        this.marker = L.marker(this.latlng, {
          icon: this.greenIcon,
        }).addTo(this.map);
      } else {
        this.marker.setLatLng(this.latlng).update();
      }
    });


    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          this.latlng = [position.coords.latitude, position.coords.longitude];

          if(this.init == null)
          {
                this.$emit("update:modelValue", this.latlng);
          }
          this.currentPosMarker = L.marker(this.latlng, {
            icon: this.redIcon,
          }).addTo(this.map);
        });

       this.map.setView(this.latlng,10); //centre la carte sur le point

    }
    //cas update
   if(this.init)
   {
       console.log("toto");
       this.latlng = [this.init[0], this.init[1]];

       //set focus ?
        this.marker = L.marker(this.latlng, {
          icon: this.greenIcon,
        }).addTo(this.map);

        this.map.setView(this.latlng,10); //centre la carte sur le point

   }
  },
  onBeforeUnmount() {
    if (this.map) {
      this.map.remove();
    }
  },
  methods: {},
};
</script>

<style scoped>
#mapContainer {
  width: 45vw;
  height: 45vh;
}
@import "~leaflet-search/src/leaflet-search.css";
</style>

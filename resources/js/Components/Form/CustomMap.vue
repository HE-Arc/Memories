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
import 'leaflet.awesome-markers';

L.AwesomeMarkers.Icon.prototype.options.prefix = 'fa';

export default {
  name: "LeafletMap",
  components: {},
  props: ["modelValue", "init"],
  emits: ["update:modelValue"],
  data() {
    return {
      map: null,
      marker: null,
      currentPosMarker: null,
      latlng: null,
      homeMarker : new L.AwesomeMarkers.icon({
        icon: 'home',
        markerColor: 'red',
      }),
      clickMarker : new L.AwesomeMarkers.icon({
        icon: 'map-pin',
        markerColor: 'green',
      }),
    };
  },
  mounted() {
    this.buildMap();
    this.addClickListener();
    this.getLocation();
    this.checkUpdate();
  },
  onBeforeUnmount() {
    if (this.map) {
      this.map.remove();
    }
  },
  methods: {
    /*
     * build the map
     */
    buildMap() {
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
    },
    /*
     * add a click listener to choose the memory position
     */
    addClickListener() {
      this.map.on("click", (e) => {
        this.latlng = [e.latlng.lat, e.latlng.lng]; //get the position of the click
        this.$emit("update:modelValue", this.latlng); //update parent data
        if (this.marker == null) {
          //if the user hasn't had a previous position
          //add a green marker to indicate the position
          this.marker = L.marker(this.latlng, {
            icon: this.clickMarker,
          }).addTo(this.map);
        } else {
          this.marker.setLatLng(this.latlng).update(); //if the marker already exist update its pos
        }
      });
    },
    /*
     * get location and add a marker on the map
     */
    getLocation() {
      //center the map on the user position
      this.map.locate({
        setView: false,
        maxZoom: 10,
        enableHighAccuracy: true,
      });

      //if the user have the geolcation
      if (navigator.geolocation) {
          //find the curent position
        navigator.geolocation.getCurrentPosition((position) => {
          this.latlng = [position.coords.latitude, position.coords.longitude];
          if (this.init == null) {
            this.$emit("update:modelValue", this.latlng); //indicate to the parent the current pos
            this.map.setView(this.latlng, 10);
          }
          //add a red marker to indicate the current pos
          this.currentPosMarker = L.marker(this.latlng, {
            icon: this.homeMarker,
          }).addTo(this.map);
        });
      }
    },
    /*
     * check if the view is a update view
     */
    checkUpdate() {
      //if we got data
      if (this.init != null) {
        this.latlng = [this.init[0], this.init[1]]; //save the memory pos

        //add a green marker for the position
        this.marker = L.marker(this.latlng, {
          icon: this.clickMarker,
        }).addTo(this.map);

        //center the map on the marker
        this.map.setView(this.latlng, 10);
      }
    },
  },
};
</script>

<style scoped>
#mapContainer {
  width: 45vw;
  height: 45vh;
}
@import "~leaflet-search/src/leaflet-search.css";
@import "~leaflet.awesome-markers/dist/leaflet.awesome-markers.css";

</style>

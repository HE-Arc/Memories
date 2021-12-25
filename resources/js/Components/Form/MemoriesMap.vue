<template>
  <div class="row soft-padding margin-zero">
    <div class="container border-solid-black" id="mapContainer"></div>
  </div>
</template>


<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import LeafletSearch from "leaflet-search";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  name: "MemoriesMap",
  props: ["myMemories", "memoriesFriends", "publicMemories", "currentUser"],
  components: {
    Link,
  },

  data() {
    return {
      map: null,
      currentPosMarker: null,
      latlng: null,
      imgDefault:
        "<img class='miniImg' src='/storage/default.jpg' alt='default.jpg'/><br><br>",
      imgPath: "",
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
      violetIcon: new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      }),
      blackIcon: new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png",
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
    this.initMap();
    this.addMemoriesFriends();
    this.addPublicMemories();
    this.addMyMemories();
  },
  onBeforeUnmount() {
    if (this.map) {
      this.map.remove();
    }
  },
  methods: {
    initMap() {
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

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          this.latlng = [position.coords.latitude, position.coords.longitude];
          this.map.setView(this.latlng, 10); //centre la carte sur le point
          this.currentPosMarker = L.marker(this.latlng, {
            icon: this.redIcon,
          }).addTo(this.map);
        });
      }
    },
    visit(id) {
      Inertia.get(route("memories.show", id));
    },
    addMemoriesFriends() {
      //foreach friends
      this.memoriesFriends.forEach((friend) => {
        //foreach memory's friend
        friend.memories_and_pictures_protected.forEach((memory) => {
          this.drawMarker(memory, friend, this.violetIcon);
        });
      });
    },
    addPublicMemories() {
      //foreach memories
      this.publicMemories.forEach((memory) => {
        //add marker
        this.drawMarker(memory, memory.user, this.greenIcon);
      });
    },
    addMyMemories() {
      //foreach memories
      this.myMemories.data.forEach((memory) => {
        //add marker
        this.drawMarker(memory, this.currentUser, this.blackIcon);
      });
    },
    drawMarker(memory, user, icon) {
      //find position in memory
      var pos = [
        memory.location.coordinates[1],
        memory.location.coordinates[0],
      ];
      //create marker with popup
      var mark = L.marker(pos, {
        icon: icon,
      });

      if (memory.pictures.length > 0) {
        this.imgPath = `<img class='miniImg' src='/storage/${user.id}/${memory.id}/${memory.pictures[0].picture_name}' alt='${memory.pictures[0].picture_name}'/><br><br>`;
      } else {
        this.imgPath = this.imgDefault;
      }

      //add popup to marker
      mark.bindPopup(
        `<h5>${memory.name}</h5>
               <i>Author : ${user.name}</i><br>
               ${this.imgPath}
               <a class="btn btn-info" href="${route(
                 "memories.show",
                 memory.id
               )}">Show memory</a>
              `
      );

      //add marker to map
      mark.addTo(this.map);
    },
  },
};
</script>

<style>
.leaflet-popup-content-wrapper {
  width: 28em;
  height: 26em;
}
.leaflet-popup-content-wrapper a {
  text-decoration: none;
  color: white;
  display: block;
  margin-left: auto;
  margin-right: auto;
}
img.miniImg {
  height: 15em;
  width: 100%;
  object-fit: cover;
}
#mapContainer {
  width: 100vw;
  height: 45vh;
}
@import "~leaflet-search/src/leaflet-search.css";
</style>

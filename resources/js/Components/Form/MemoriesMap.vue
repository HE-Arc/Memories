<template>
  <div class="row soft-padding margin-zero">
    <div class="container border-solid-black" id="mapContainer"></div>
    <div class="container border-solid-black">
        Legend :
        Current position : &nbsp;<i class="fa fa-home"></i>&nbsp;,&nbsp;
        My memories : &nbsp;<i class="fa fa-user"></i>&nbsp;,&nbsp;
        Friends : &nbsp;<i class="fa fa-users"></i>&nbsp;,&nbsp;
        Public : &nbsp;<i class="fa fa-globe"></i>
     </div>

  </div>
</template>


<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import LeafletSearch from "leaflet-search";
import { Link } from "@inertiajs/inertia-vue3"
import 'leaflet.awesome-markers';

L.AwesomeMarkers.Icon.prototype.options.prefix = 'fa';


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
      myMarker: new L.AwesomeMarkers.icon({
        markerColor: 'black',
        icon : 'user'
      }),
        publicMarker: new L.AwesomeMarkers.icon({
        icon: 'globe',
        markerColor: 'blue',
      }),
      userFriendsMarker : new L.AwesomeMarkers.icon({
        icon: 'users',
        markerColor: 'green',
      }),
       homeMarker : new L.AwesomeMarkers.icon({
        icon: 'home',
        markerColor: 'red',
      }),
    };
  },
  mounted() {
    this.initMap(); //prepare the map
    this.addMemoriesFriends(); //add all friends memories in the map
    this.addPublicMemories(); //add all public memories in the map
    this.addMyMemories(); //add all user memories in the map
  },
  onBeforeUnmount() {
    if (this.map) {
      this.map.remove();
    }
  },
  methods: {
    initMap() {
      this.map = L.map("mapContainer");

      //add control to search a place on the map
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

      //if the user have geolocation
      if (navigator.geolocation) {
        //get the user curent position
        navigator.geolocation.getCurrentPosition((position) => {
          this.latlng = [position.coords.latitude, position.coords.longitude];
          this.map.setView(this.latlng, 10); //center the map on the current pos
          //add a homeMarker to identify the current position on the map
          this.currentPosMarker = L.marker(this.latlng, {
            icon: this.homeMarker,
          }).addTo(this.map);
        });
      }
    },
    /*
     *add all friends memories in the map
     */
    addMemoriesFriends() {
      //foreach friends
      this.memoriesFriends.forEach((friend) => {
        //foreach memory's friend
        friend.memories_and_pictures_protected.forEach((memory) => {
          //add a userFriendsMarker on the map
          this.drawMarker(memory, friend, this.userFriendsMarker);
        });
      });
    },
    /*
     *add all public memories in the map
     */
    addPublicMemories() {
      //foreach memories
      this.publicMemories.forEach((memory) => {
        //add publicMarker marker
        this.drawMarker(memory, memory.user, this.publicMarker);
      });
    },
    /*
     *add all user memories in the map
     */
    addMyMemories() {
      //foreach memories
      this.myMemories.data.forEach((memory) => {
        //add myMarker
        this.drawMarker(memory, this.currentUser, this.myMarker);
      });
    },
    /*
     * draw a marker on the map
     */
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

      //add image in picture if exist
      if (memory.pictures.length > 0) {
        this.imgPath = `<img class='miniImg' src='/storage/${user.id}/${memory.id}/${memory.pictures[0].picture_name}' alt='${memory.pictures[0].picture_name}'/><br><br>`;
      }
      //else default image
      else {
        this.imgPath = this.imgDefault;
      }

      //add popup to marker
      //memory name
      //user name
      //image
      //link to show memory
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
@import "~leaflet.awesome-markers/dist/leaflet.awesome-markers.css";
</style>

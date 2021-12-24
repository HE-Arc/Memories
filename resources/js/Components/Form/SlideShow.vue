<template>
  <div class="test" v-if="this.pictures.length" >
    <agile autoplay autoplaySpeed="5000" :initial-slide="0">
      <img  v-for="picture in this.pictures" :key="picture.id"
        class="slide"
        :src="'/storage/' + user_id + '/' + picture.memory_id + '/'  + picture.picture_name"
      >
    </agile>
  </div>
</template>

<script>
import { VueAgile } from "vue-agile";

export default {
  name: "Carousel",
  components: {
    agile: VueAgile,
  },
  props: ["pictures", "user_id"],
};
</script>

<style lang="scss">
//todo remove ?
@import url("https://unpkg.com/vue-agile@latest/dist/VueAgile.css");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css");

.agile {
  &__nav-button {
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 24px;
    height: 100%;
    position: absolute;
    top: 0;
    transition-duration: 0.3s;
    width: 80px;
    &:hover {
      background-color: rgba(black, 0.5);
      opacity: 1;
    }
    &--prev {
      left: 0;
    }
    &--next {
      right: 0;
    }
  }
  &__dots {
    bottom: 10px;
    left: 50%;
    position: absolute;
    transform: translateX(-50%);
  }
  &__dot {
    margin: 0 10px;
    button {
      background-color: transparent;
      border: 1px solid white;
      border-radius: 50%;
      cursor: pointer;
      display: block;
      height: 10px;
      font-size: 0;
      line-height: 0;
      margin: 0;
      padding: 0;
      transition-duration: 0.3s;
      width: 10px;
    }
    &--current,
    &:hover {
      button {
        background-color: white;
      }
    }
  }
}

// Slides styles
.slide {
  display: block;
  height: 60vh;
  object-fit: cover;
  width: 100%;
  border-color: black;
  border-width: 1px;

  border-top-style: solid;
  border-bottom-style: solid;
  -webkit-box-shadow: 0px 14px 29px 0px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 0px 14px 29px 0px rgba(0, 0, 0, 0.75);
  box-shadow: 0px 14px 29px 0px rgba(0, 0, 0, 0.75);
}
</style>

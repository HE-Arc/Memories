<template>
  <div v-if="this.success" class="alert alert-success">
    {{ this.success }}
     <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
  </div>
  <div v-if="this.danger" class="alert alert-danger">
    {{ this.danger }}
     <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
  </div>
  <div v-if="this.warning" class="alert alert-warning">
    {{ this.warning }}
     <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
  </div>
</template>

<script>
export default {
  props : ['flash'],
  data() {
    return {
      success: this.flash.success,
      warning: this.flash.warning,
      danger: this.flash.danger,

    };
  },
  methods: {
    hideFlashMessage() {
      this.success = null;
      this.warning = null;
      this.danger = null;
    },
  },
};
</script>
<style>
div.alert button.btn {
  position: absolute;
  right: 1rem;
  top: 0.5rem;
}
</style>

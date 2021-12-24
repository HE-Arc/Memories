<template>
<span v-if="this.hidden == false">
    <div v-if="$page.props.flash.success" class="alert alert-success">
        {{$page.props.flash.success}}
        <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
    </div>
    <div v-if="$page.props.flash.danger" class="alert alert-danger">
        {{$page.props.flash.danger}}
        <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
    </div>
    <div v-if="$page.props.flash.warning" class="alert alert-warning">
        {{$page.props.flash.warning}}
        <button @click="hideFlashMessage()" class="btn float-right align-middle"><i class="fa fa-close"></i></button>
    </div>
</span>
</template>

<script>
export default {
    data() {
        return {
            hidden: false
        };
    },
    methods: {
        hideFlashMessage() {
            console.log(flash.warning);
            //flash.warning = "";
        }
    },
}
</script>

<style>
div.alert button.btn {
    position: absolute;
    right: 1rem;
    top: 0.5rem;
}
</style>

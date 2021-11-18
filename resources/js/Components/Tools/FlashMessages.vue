<template>
    <div v-if="$page.props.flash.success" class="alert alert-success">
        <p>
            {{$page.props.flash.success}}
        </p>
    </div>
    <div v-if="$page.props.flash.danger" class="alert alert-danger">
        <p>
            {{$page.props.flash.danger}}
        </p>
    </div>
    <div v-if="$page.props.flash.warning" class="alert alert-success" role="alert">
        <strong>Alert!</strong>  {{$page.props.flash.warning}}
        <button class="btn float-right align-middle"><i class="fa fa-close"></i></button>
    </div>
</template>

<style>
div.alert button.btn {
    position: absolute;
    right: 1rem;
    top: 0.5rem;
}
</style>

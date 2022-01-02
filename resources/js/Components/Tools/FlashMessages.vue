<template>
    <div v-if="$page.props.flash.success" class="alert alert-success">
        {{$page.props.flash.success}}
    </div>
    <div v-if="$page.props.flash.danger" class="alert alert-danger">
        {{$page.props.flash.danger}}
    </div>
    <div v-if="$page.props.flash.warning" class="alert alert-warning">
        {{$page.props.flash.warning}}
    </div>
</template>

<script>
export default {

}
</script>

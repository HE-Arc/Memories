<template>
    <label :for="selectId">Privacy</label>
    <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)"
             :id="selectId" class="form-select" aria-label="Default select example">
    <option value="friends-only">Friends only</option>
    <option value="private">Private</option>
    <option value="public">Public</option>
    </select>
</template>

<script>
export default {
    props: ['modelValue','selectId'],
    emits: ['update:modelValue'],
}
</script>

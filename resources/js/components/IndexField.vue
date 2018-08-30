<template>
    <img v-if="url" :src="url" class="rounded-full w-8 h-8">
    <span v-else>&mdash;</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    computed: {
        url() {
            return this.field.value
        }
    }
}
</script>

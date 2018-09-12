<template>
    <panel-item :field="field">
        <div slot="value">
            <img v-if="url" :src="url" class="rounded" :style="{ width, height }">
            <span v-else>&mdash;</span>
        </div>
    </panel-item>
</template>

<script>
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],

        computed: {
            url() {
                return this.field.value
            },

            width() {
                return this.field.width || 'auto'
            },

            height() {
                return this.field.height || '12rem'
            }
        }
    }
</script>

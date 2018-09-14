<template>
    <div v-if="url" class="rounded-full w-8 h-8" :style="style"></div>
    <span v-else>&mdash;</span>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],

        computed: {
            url() {
                return this.field.value ? this.field.value.preview_url : null
            },

            style() {
                return {
                    backgroundImage: `url(${this.url})`,
                    backgroundRepeat: 'no-repeat',
                    backgroundPosition: '50%',
                    backgroundSize: 'cover',
                }
            },
        },
    }
</script>

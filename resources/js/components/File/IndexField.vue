<template>
    <span v-if="field.value">
        {{ field.value.name }}
    </span>

    <span v-else>&mdash;</span>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],
    }
</script>

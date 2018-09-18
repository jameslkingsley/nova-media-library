<template>
    <panel-item :field="field">
        <div slot="value">
            <span v-if="field.value">{{ field.value.name }}</span>
            <span v-else>&mdash;</span>
        </div>
    </panel-item>
</template>

<script>
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
    }
</script>

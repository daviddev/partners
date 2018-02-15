<template>
    <div>
        <heading></heading>
        <router-view></router-view>
    </div>
</template>

<script>
    import Heading from './layouts/Heading.vue'

    export default {
        name: 'app',
        components: { Heading }
    }
</script>

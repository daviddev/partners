<template>
    <div>
        <heading></heading>
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
    import Heading from './layouts/Heading.vue'

    export default {
        name: 'app',
        components: { Heading }
    }
</script>

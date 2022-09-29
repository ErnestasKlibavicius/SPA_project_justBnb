<template>
    <div>
        <router-link :to="{ path: '/' }">Home</router-link>
        <router-link :to="{ path: '/about' }">about</router-link>
        <router-view></router-view>
    </div>
</template>


<script>
export default {

}
</script>

<style>

</style>
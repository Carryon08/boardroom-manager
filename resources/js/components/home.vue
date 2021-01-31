<template>
    <div>
        <router-link to="/">Go to Bar</router-link>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "home",

        methods:{
            drawBoardrooms(){
                this.$router.push('/');
            },
        },
    }
</script>

<style scoped>

</style>

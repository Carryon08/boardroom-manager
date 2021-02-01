<template>
    <div>
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

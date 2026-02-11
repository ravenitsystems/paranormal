<script setup>
import Layout from './components/Layout.vue';
</script>

<template>
    <Layout>
        <router-view v-slot="{ Component, route }">
            <div :key="route.name">
                <Component :is="Component" />
            </div>
        </router-view>
    </Layout>
</template>

<style scoped>

</style>

<script setup>
import {ref} from 'vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import TwitterLayout from '@/Layouts/TwitterLayout.vue';
import Tweet from "@/Components/Tweet.vue";
import {router} from '@inertiajs/vue3';
import Menuitem from '@/Components/Menuitem.vue'

defineProps(
    {
        tweets: Array,
        user: Object
    }
)

const logout = () => {
    router.post('logout');
};


</script>

<template>

    <Head title="Twitter"/>

    <TwitterLayout :user="user">
        <div class="text-white">
            <div class="flex" v-for="tweet in tweets" :key="tweet">
                <Tweet :tweet="tweet" :user="user"/>
            </div>
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>
    </TwitterLayout>

    <div class="flex absolute bottom-0 left-[350px] w-[250px]">
        <Menuitem iconString="Logout" @click="logout"/>
    </div>
</template>

<style>
body {
    background-color: black;
}
</style>

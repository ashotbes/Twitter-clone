<script setup>

import Menuitem from "@/Components/Menuitem.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import Feather from "vue-material-design-icons/Feather.vue";
import Twitter from "vue-material-design-icons/Twitter.vue";
import {Link, router} from "@inertiajs/vue3";
import Magnify from "vue-material-design-icons/Magnify.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import CalendarMonth from "vue-material-design-icons/CalendarMonth.vue";
import CakeVariant from "vue-material-design-icons/CakeVariant.vue";
import Tweet from "@/Components/Tweet.vue";
import CloseCircle from "vue-material-design-icons/CloseCircle.vue"
import ImageOutline from "vue-material-design-icons/ImageOutline.vue";
import {ref} from "vue";

defineProps({user: Object, tweets: Array});

let file = ref('')
let showUpload = ref('')
let uploadType = ref('')
let showModal = ref(false)
let updatedName = ref('');
let updatedPhoto = ref('');

const formatUserCreatedAt = (value) => {
    if (!value) return '';

    const date = new Date(value);
    const options = {year: 'numeric', month: 'long'};
    return date.toLocaleDateString('en-EN', options);
};

const getFile = (e) => {
    file.value = e.target.files[0]
    showUpload.value = URL.createObjectURL(e.target.files[0]);
    uploadType.value = file.value.name.split('.').pop();
}

const editData = (userId) => {
    let data = new FormData();

    if (updatedName.value) {
        data.append('updatedName', updatedName.value);
    }

    if (file.value) {
        data.append('file', file.value);
    }

    if (data.has('updatedName') || data.has('file')) {
        router.post(`/account/${userId}/update`, data);
        showModal = false;
    }
}


</script>

<template>
    <div class="account text-white" v-if="user">
        <div class="fixed w-full">
            <div class="max-w-[1400px] flex mx-auto">
                <div class="lg:w-3/12 w-[60px] h-[100vh] max-w-[350px] lg:px-4 lg:mx-auto">
                    <div class="p-2 px-3 mb-4">
                        <Twitter fillColor="#FFFFFF" :size="37"/>
                    </div>

                    <Link :href="route('tweets.index')">
                        <Menuitem iconString="Home"/>
                    </Link>
                    <Menuitem iconString="Explore"/>
                    <Menuitem iconString="Notifications"/>
                    <Menuitem iconString="Messages"/>
                    <Menuitem iconString="Profile"/>
                </div>

                <div class="lg:w-7/12 w-11/12 border-x border-gray-800 relative">

                    <div class=" bg-black bg-opacity-50 backdrop-blur-md z-10 absolute w-full">
                        <div class="border-gray-800 border-b w-full ">
                            <div class="w-full text-white text-[22px] font-extrabold p-4 flex items-center gap-4">
                                <Link :href="route('tweets.index')"
                                      class="hover:bg-gray-500 hover:bg-opacity-30 rounded-full hover:h-full">
                                    <ArrowLeft/>
                                </Link>
                                Hello, {{ user.name }}!
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#333639] h-1/6 mt-16 relative">
                        <img class="h-full w-full"
                             src="https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg?size=626&ext=jpg&ga=GA1.1.44546679.1699401600&semt=sph"
                             alt="">
                        <div class="absolute bottom-0 left-[10px] rounded-full">
                            <img class="rounded-full p-2 w-[120px]" :src="`/storage/${user.image}`" alt="">
                        </div>
                    </div>
                    <div class="mt-3 px-5 flex justify-between items-center">
                        <span class="text-3xl font-bold">{{ user.name }}</span>
                        <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none
                        hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-bold text-lg rounded-full px-5 py-2.5 mr-2
                         dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                        dark:focus:ring-gray-700 w-1/3" @click="showModal = true">
                            Edit profile
                        </button>
                    </div>
                    <span class="px-5">{{ user.handle }}</span>

                    <div class="gap-6 flex flex">
                        <div class="mt-2 px-5 flex gap-2 items-center">
                            <CakeVariant/>
                            <span class="text-lg">Date of birth: Some data</span>
                        </div>

                        <div class="mt-2 px-5 flex gap-2 items-center">
                            <CalendarMonth/>
                            <span class="text-lg">Account created at: {{
                                    formatUserCreatedAt(user.created_at)
                                }} y.</span>
                        </div>
                    </div>

                    <div
                        class="flex mt-7 px-4 w-[100px] h-[60px] text-white text-[17px] font-extrabold
                        hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                        <div class="inline-block text-center border-b-4 border-b-[#1C9CEF] h-[60px]">
                            <div class="my-auto mt-4">Tweets</div>
                        </div>
                    </div>


                    <div class="flex mt-2" v-for="tweet in tweets" :key="tweet">
                        <Tweet v-if="tweet.user_id == user.id" :tweet="tweet" :user="user"/>
                    </div>

                </div>


                <div class="lg:block hidden lg:w-4/12 h-screen border-l border-gray-800 pl-4">
                    <div class="w-full p-1 mt-2 px-4 lg:flex items-center rounded-full hidden bg-[#212327]">
                        <Magnify fillColor="#5e5c5c" :size="25"/>
                        <input
                            class="
                            appearance-none
                            w-full
                            border-0
                            py-2
                            bg-[#212327]
                            text-gray-100
                            placeholder-gray-500
                            leading-tight
                            focus:ring-0
                        "
                            type="text"
                            placeholder="Search Twitter"
                        >
                    </div>

                    <div class="w-full mt-4 rounded-lg lg:block hidden bg-[#212327]">
                        <div class="w-full p-4 text-white font-extrabold mb-6 text-[20px]">What's happening</div>

                        <div class="h-[80px] hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                            <div class="flex p-3 justify-between h-[80px] py-3">
                                <div>
                                    <div class="text-[14px] text-gray-400">Tennis Tournament LIVE</div>
                                    <div class="w-full text-white font-extrabold mb-6 text-[17px]">Australian Open 2023
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                            <div class="flex p-3 justify-between">
                                <div>
                                    <div class="text-[14px] text-gray-400">Trending in United Kingdom</div>
                                    <div class="w-full text-white font-extrabold text-[17px]">Doomsday Clock</div>
                                    <div class="text-[14px] text-gray-400">5,923 Tweets</div>
                                </div>
                                <DotsHorizontal fillColor="#5e5c5c"/>
                            </div>
                        </div>

                        <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                            <div class="flex p-3 justify-between">
                                <div>
                                    <div class="text-[14px] text-gray-400">Sports · Trending</div>
                                    <div class="w-full text-white font-extrabold text-[17px]">Poro</div>
                                    <div class="text-[14px] text-gray-400">12,432 Tweets</div>
                                </div>
                                <DotsHorizontal fillColor="#5e5c5c"/>
                            </div>
                        </div>

                        <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                            <div class="flex p-3 justify-between">
                                <div>
                                    <div class="text-[14px] text-gray-400">Politics · Trending</div>
                                    <div class="w-full text-white font-extrabold text-[17px]">Sunak</div>
                                    <div class="text-[14px] text-gray-400">98,745 Tweets</div>
                                </div>
                                <DotsHorizontal fillColor="#5e5c5c"/>
                            </div>
                        </div>


                        <div class="hover:bg-gray-800 rounded-b-xl cursor-pointer transition duration-200 ease-in-out">
                            <div class="text-blue-500 p-4">Show more</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-wrapper" v-if="showModal">
        <div class="modal">
            <div class="flex text-2xl items-center justify-between">
                <CloseCircle class="cursor-pointer" @click="showModal = !showModal"/>
                <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none
                        hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-bold text-lg rounded-full px-5 py-2.5 mr-2
                         dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600
                        dark:focus:ring-gray-700" @click="editData(user.id)">
                    Save
                </button>
            </div>
            <div class="text-2xl mt-3">
                <h1>Image</h1>
                <img class="rounded-full mt-3 w-[120px]" :src="/storage/ + user.image" alt="">
                <div class="hover:bg-gray-800 inline-block p-2 rounded-full cursor-pointer ">
                    <label for="fileUpload" class="cursor-pointer">
                        <ImageOutline fillColor="#1C9CEF" :size="25" />
                    </label>
                    <input type="file" id="fileUpload" class="hidden" name="file" @change="getFile">
                </div>
            </div>
            <div class="mt-3 relative">
                <Label for="Name" class="text-lg">Name
                    <input type="text" v-model="updatedName" name="updatedName" class="bg-black text-white text-lg w-full rounded-2xl mt-1">
                    <span v-if="!updatedName" class="absolute left-0 bottom-2 px-3 text-xl">{{user.name}}</span>
                </Label>
            </div>
        </div>
    </div>
</template>

<style scoped>
* {
    color: white;
}

.account {
    background-color: black;
    height: 100vh;
    color: white;
}

.modal-wrapper {
    background-color: rgba(91, 112, 131, 0.4);
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
}

.modal {
    border-radius: 15px;
    background-color: black;
    height: 600px;
    width: 600px;
    padding: 20px;
}

</style>

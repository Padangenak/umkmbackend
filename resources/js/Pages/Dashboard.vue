<template>
    <div class="flex">
        <div class="w-2/12">
            <div class="w-full"></div>
            <Sidebar :auth="props.auth" />
            <SidebarPhone :auth="props.auth" />
        </div>
        <div class="w-10/12">
            <div class="py-32 px-10">
                <p>Selamat Datang {{ props.auth.user.name }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronDown } from "@vicons/tabler";
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";

const props = defineProps({
    auth: Object
})
</script>

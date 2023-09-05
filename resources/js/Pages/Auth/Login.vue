<template>
    <div class="w-full h-screen bg-gray-100 flex justify-center items-center">
        <div class="max-md:w-9/12 md:w-3/12 text-center">
            <h1 class="py-5 text-xl font-semibold">Login Admin</h1>
            <div class="bg-white px-5 py-5 w-full rounded border">
                <!-- <pre>{{ $page.props.flash }}</pre> -->
                <div class="card flex justify-content-center mb-4" v-if="$page.props.flash.err != null">
                    <InlineMessage severity="error"
                        class="w-full">{{ $page.props.flash.err }}</InlineMessage
                    >
                </div>
                <form @submit.prevent="form.post('/login')">
                    <input
                        type="text"
                        class="border px-2 py-2 rounded w-full mb-3"
                        placeholder="Username"
                        v-model="form.username"
                    />
                    <small>{{ form.errors.username }}</small>
                    <!-- <InputError class="mt-2" :message="form.errors.username" /> -->
                    <input
                        type="password"
                        class="border px-2 py-2 rounded w-full mb-3"
                        placeholder="Password"
                        v-model="form.password"
                    />
                    <small>{{ form.errors.password }}</small>
                    <button
                        class="w-full border py-2 rounded bg-blue-400 text-white font-black"
                    >
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript" setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InlineMessage from "primevue/inlinemessage";

const props = defineProps({
    err: String,
});
const form = useForm({
    username: null,
    password: null,
});

</script>

<template>
    <div class="flex">
        <div class="md:w-2/12">
            <div class="w-full"></div>
            <Sidebar :auth="props.auth" />
            <SidebarPhone :auth="props.auth" />
        </div>
        <div class="max-md:w-full md:w-10/12">
            <div class="py-28 px-10">
                <p class="text-lg font-semibold" :class="{ 'mb-10': $page.props.flash.message == null }">Tentang Saya</p>
                <div
                    class="card flex flex-wrap align-items-center justify-content-center gap-3 mb-5 mb-5 w-full"
                    v-if="$page.props.flash.message != null"
                >
                    <Message severity="success" :closable="false" class="w-full"
                        >{{$page.props.flash.message}}</Message
                    >
                </div>
                <div class="flex max-md:flex-wrap justify-center">
                    <div>
                    <div 
                    class="w-64 h-64 bg-cover rounded-full max-md:mb-10" 
                    :style="{'background-image': `url(${imageURL})`}"
                    />
                </div>
                <div class="w-full px-10">
                    <form @submit.prevent="form.post(route('imChange'))">
                    <div class="mb-5">
                        <p>Nama Pengguna</p>
                        <input
                            type=""
                            v-model="form.name"
                            class="border px-3 py-2 rounded border-gray-300 w-full"
                            placeholder="Masukkan Nama"
                        />
                        <small class="text-red-600">{{
                            form.errors.name
                        }}</small>
                    </div>
                    <div class="mb-5">
                        <p class="mr-3">Nama Panggilan</p>
                        <small class="text-gray-400"
                            >(ini digunakan untuk login)</small
                        >

                        <input
                            type=""
                            v-model="form.username"
                            class="border px-3 py-2 rounded border-gray-300 w-full"
                            placeholder="Masukkan Nama Panggilan"
                        />
                        <small class="text-red-600">{{
                            form.errors.username
                        }}</small>
                    </div>
                    <div class="mb-5">
                        <p>Kata Sandi</p>
                        <small class="text-gray-400"
                            >(ini digunakan untuk login)</small
                        >

                        <input
                            type=""
                            v-model="form.password"
                            class="border px-3 py-2 rounded border-gray-300 w-full"
                            placeholder="Masukkan Kata Sandi"
                        />
                        <small class="text-red-600">{{
                            form.errors.password
                        }}</small>
                    </div>
                    <div class="mb-5">
                        <p>Nomor Telepon</p>
                        <input
                            type=""
                            v-model="form.phoneNumber"
                            class="border px-3 py-2 rounded border-gray-300 w-full"
                            placeholder="Masukkan Nomor Telepon"
                        />
                        <small class="text-red-600">{{
                            form.errors.phoneNumber
                        }}</small>
                    </div>
                    <div class="mb-5">
                        <p>Nama Toko</p>
                        <input
                            type=""
                            v-model="form.store"
                            class="border px-3 py-2 rounded border-gray-300 w-full"
                            placeholder="Masukkan Nama Toko"
                        />
                        <small class="text-red-600">{{
                            form.errors.store
                        }}</small>
                    </div>
                    <div class="">
                        <p>Alamat</p>
                        <div class="card mb-5">
                            <CascadeSelect
                                v-model="form.address"
                                :options="locationAPI"
                                optionLabel="name"
                                optionGroupLabel="name"
                                :optionGroupChildren="['regencies']"
                                placeholder="Pilih Alamat"
                                class="md:w-3/12 mb-5"
                            />
                            <br>
                            <small class="text-gray-400">Lokasi Sekarang :{{ props.auth.user.address }}</small>
                        </div>
                        <small class="text-red-600">{{
                            form.errors.address
                        }}</small>
                    </div>
                    <div class="">
                        <p>Peran Pengguna</p>
                        <div class="card flex justify-content-center">
                            <Dropdown
                                optionValue="role"
                                v-model="form.role"
                                :options="props.role"
                                optionLabel="role"
                                placeholder="Pilih Peran"
                                class="md:w-3/12 md:w-14rem"
                                disabled 
                            />
                        </div>
                        <small class="text-red-600">{{
                            form.errors.role
                        }}</small>
                    </div>
                    <div class="pt-5 mb-5">
                        <p>Foto</p>
                        <Message
                        :closable="false"
                        severity="error"
                        v-if="message"
                        >{{ message }}</Message
                    >
                        <div class="card justify-content-center">
                            <div class="relative w-fit">
                                <button
                                    class="hover:bg-gray-50 border border-purple-600 relative overflow-hidden cursor-pointer rounded text-purple-600 font-semibold"
                                    type="button"
                                >
                                    <input
                                        type="file"
                                        name=""
                                        class="absolute bg-blue-600 cursor-pointer w-full h-screen pl-40 opacity-0"
                                        @change="image"
                                        accept="image/*"
                                    />
                                    <span class="px-4 cursor-pointer"
                                        >Upload Gambar</span
                                    >
                                </button>
                            </div>
                            <br />
                            <div
                                class="w-52 h-52 bg-cover bg-center rounded-full"
                                :style="{
                                    'background-image': `url(${imageURL})`,
                                }"
                                v-if="imageURL != ''"
                            />
                        </div>
                    </div>
                    <div class="flex pt-5">
                        <Button label="Edit" outlined type="submit" />
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";
import CascadeSelect from "primevue/cascadeselect";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InlineMessage from "primevue/inlinemessage";
import Message from 'primevue/message';
import FileUpload from "primevue/fileupload";
import TreeSelect from 'primevue/treeselect';

const props = defineProps({
    auth: Object,
    role: Object
})
const roleSelect = ref(null);
const locationSelect = ref(null);

const locationAPI = ref([]);

async function localAPI() {
    let titleLocation = ref();
    await fetch("/api/provinces.json")
        .then((responce) => responce.json())
        .then((json) => locationAPI.value.push(...json));
}

localAPI();

const form = useForm({
    name: props.auth.user.name,
    username: props.auth.user.username,
    password: null,
    store: props.auth.user.store,
    address: null,
    role: props.auth.user.role.role,
    phoneNumber: props.auth.user.phone_number,
    attachment: null,
});
let imageURL = ref(props.auth.user.attachment.path + props.auth.user.attachment.filename);

let message = ref("")

function image(e) {
    let files = ref(e.target.files[0]);
    let split = files.value.name.split(".");
    switch (split[split.length - 1]) {
        case "jpg":
        case "png":
        case "jpeg":
            break;
        default:
            return (message.value = "File harus format .jpg, .png dan .jpeg");
    }
    if (files.value.size > 6500000) {
            return (message.value =
                    "File tidak boleh lebih dari 6.5MB");
        }
    imageURL.value = URL.createObjectURL(files.value);
    form.attachment = files.value;
}

watch(imageURL, ()=>{
    if (imageURL.value != "") {
        message.value = ""
    }
})
</script>

<template>
    <div class="flex">
        <div class="w-2/12">
            <div class="w-full"></div>
            <Sidebar :auth="props.auth" />
            <SidebarPhone :auth="props.auth" />
        </div>
        <div class="w-10/12">
            <Dialog
                v-model:visible="visible"
                modal
                header="Konfirmasi Delete"
                :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            >
                <form
                    @submit.prevent="
                        form.post(route('productCategoryDelete', [id]))
                    "
                    class="flex justify-center"
                >
                    <Button label="Delete" outlined type="submit" />
                </form>
            </Dialog>
            <Dialog
                v-model:visible="visible2"
                modal
                header="Header"
                :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            >
                <form
                    @submit.prevent="
                        form.post(route('productCategoryEdit', [id]))
                    "
                    class="flex justify-center"
                >
                    <input
                        type=""
                        v-model="form.category"
                        class="border px-3 py-2 rounded border-gray-300 w-full"
                        placeholder="Nama Produk"
                    />
                    <Button label="Edit" raised type="submit" />
                </form>
            </Dialog>
                        <Dialog
                v-model:visible="visibleadd"
                modal
                header="Header"
                :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            >
                <form
                    @submit.prevent="
                        form.post(route('productCategoryAdd'))
                    "
                    class="flex justify-center"
                >
                    <input
                        type=""
                        v-model="form.category"
                        class="border px-3 py-2 rounded border-gray-300 w-full"
                        placeholder="Nama Produk"
                    />
                    <Button label="Tambah" raised type="submit" />
                </form>
            </Dialog>
            <div class="py-32 px-10">
                <h1 class="text-lg font-semibold">List Categori Produk</h1>
                <div>
                <div
                    class="card flex flex-wrap align-items-center justify-content-center gap-3 mb-5"
                    v-if="$page.props.flash.message != null"
                >
                    <InlineMessage severity="success" @onload="asd($page.props.flash.data)">{{
                        $page.props.flash.message
                        
                    }}
                {{ datasUpdate($page.props.flash.data) }}</InlineMessage>
                </div>
                <div class="flex justify-end">
                    <Button label="Tambah" raised type="submit" @click="clickAdd" />
                </div>
                    <DataTable
                        :globalFilterFields="['category']"
                        v-model:filters="filters"
                        :value="categoris"
                        filterDisplay="row"
                        dataKey="id"
                        paginator
                        :rows="20"
                        class="z-0 max-md:w-full"
                        size="small"
                    >
                        <template #empty> No customers found. </template>
                        <template #loading>
                            Loading customers data. Please wait.
                        </template>
                        <Column field="name" header="Nama">
                            <template #body="slotProps">
                                <div class="flex flex-wrap line-clamp-2">
                                    <p class="w-40 line-clamp-2">
                                        {{ slotProps.data.category }}
                                    </p>
                                </div>
                            </template>
                        </Column>
                        <Column header="Aktifkan Pengguna">
                            <template #body="slotProps">
                                <div
                                    class="card flex justify-content-center gap-10"
                                >
                                    <Button
                                        label="Edit"
                                        @click="
                                            visible2F(
                                                slotProps.data.id,
                                                slotProps.data.category,
                                            )
                                        "
                                        raised
                                    />
                                    <Button
                                        label="Delete"
                                        @click="visibleF(slotProps.data.id)"
                                        raised
                                    />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronDown } from "@vicons/tabler";
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import { useForm, router, Link } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
import InlineMessage from "primevue/inlinemessage";

const props = defineProps({
    categoris: Object,
    auth: Object,
    flash: Object,
});
function datasUpdate(val){
    categoris.value = [...val]
}
function clickAdd(){
    visibleadd.value = !visibleadd.value
    form.category = null
}
let categoris = ref([...props.categoris]);
let visible = ref(false);
let visible2 = ref(false);
let visibleadd = ref(false);
let id = ref("");
// let data = ref("");

const form = useForm({
    category: null,
});

function visibleF(val) {
    visible.value = !visible.value;
    id.value = val;
}
function visible2F(val, val2) {
    visible2.value = !visible2.value;
    id.value = val;
    form.category = val2;
    // console.log(val)
}
</script>

<template>
	<div class="flex pb-52">
		<div class="md:w-2/12">
			<div class="w-full"></div>
			<Sidebar :auth="props.auth" />
			<SidebarPhone :auth="props.auth" />
		</div>
		<div class="max-md:w-full md:w-10/12">
			<div class="py-28 px-10">
				<p class="mb-5 text-lg font-semibold">Tambahkan Produk</p>
				<!-- <pre>{{$page.props.flash.message}}</pre> -->
				<div
					class="card flex flex-wrap align-items-center justify-content-center gap-3 mb-5"
					v-if="$page.props.flash.message != null"
				>
					<InlineMessage severity="success">{{
						$page.props.flash.message
					}}</InlineMessage>
				</div>
				<form @submit.prevent="form.post(route('productAddLoading'))">
					<div class="mb-5">
						<p>Nama Produk</p>
						<input
							type=""
							v-model="form.product"
							class="border px-3 py-2 rounded border-gray-300 w-full"
							placeholder="Nama Produk"
						/>
						<small class="text-red-600">{{ form.errors.product }}</small>
					</div>
					<div class="mb-5 indexbottom">
						<p>Tipe</p>
						<div class="card flex justify-content-center indexbottom">
							<Dropdown
								v-model="form.category"
								:options="props.categories"
								optionLabel="category"
								placeholder="Pilih Tipe"
								class="md:w-3/12 md:w-14rem indexbottom" 
							/>
						</div>
						<small class="text-red-600">{{ form.errors.type }}</small>
					</div>
					<div class="mb-5">
						<p>Harga</p>
						<input
							type=""
							v-model="form.price"
							class="border px-3 py-2 rounded border-gray-300 w-full"
							placeholder="Harga Produk"
							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');"
						/>
						<small class="text-red-600">{{ form.errors.price }}</small>
					</div>
					<div class="mb-5">
						<p>Diskon</p>
						<input
							type=""
							v-model="form.discon"
							class="border px-3 py-2 rounded border-gray-300 w-full"
							placeholder="Tulis 0-100"
							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');"
						/>
						<small class="text-red-600">{{ form.errors.discon }}</small>
					</div>
					<div class="mb-5">
						<p>Deskripsi</p>
						<div class="card flex justify-content-center">
							<!-- <span class="p-float-label"> -->
								<textarea
								v-model="form.description"
									rows="5"
									cols="150"
									autoResize
									class="w-full rounded border border-gray-300" style="resize:none"></textarea>
							<!-- </span> -->
						</div>
						<small class="text-red-600">{{ form.errors.description }}</small>
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
						<Button label="Lanjut" outlined type="submit" class="" />
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript" setup>
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";
import CascadeSelect from "primevue/cascadeselect";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import { ref, onMounted,watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InlineMessage from "primevue/inlinemessage";
import Textarea from "primevue/textarea";
import RadioButton from "primevue/radiobutton";
import Message from "primevue/message";

const type = ref([
	{ name: "Makanan/Satuan/pcs" },
	{ name: "Barang/Buah/Item" },
]);

const props = defineProps({
	auth: Object,
	categories: Object
})

const form = useForm({
	product: null,
	price: null,
	discon: null,
	stock: "Tersedia",
	description: null,
	category: null,
	attachment: null,
});
let imageURL = ref("");

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
<style scoped>
.indexbottom::v-deep{
	z-index:0;
	position: relative;
}
.indextop{
	z-index:50;
}
</style>
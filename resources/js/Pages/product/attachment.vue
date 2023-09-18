<template>
	<div class="flex pb-96	">
		<div class="md:w-2/12">
			<div class="w-full"></div>
			<Sidebar :auth="props.auth" />
			<SidebarPhone :auth="props.auth" />
		</div>
		<div class="max-md:w-full md:w-10/12">
			<div class="py-28 px-10">
				<Link :href="route('editProduct', [id])">
					<p class="mb-5 text-lg font-semibold text-purple-600 hover:text-purple-500 cursor-pointer w-fit">
					Kembali
				</p>
				</Link>
				<p class="mb-5 text-lg font-semibold">
					Tambahkan Lampiran Produk
				</p>
				<div class="card">
					<Message :closable="false"
						>Variasi produk adalah jenis lain yang di miliki oleh
						produk, contoh seperti cemilan rasa coklat, vanila atau
						yang sejenisnya dan juga untuk barang contoh warna
						merah, abu-abu atau sejenisnya
						</Message
					>
				</div>
				<div
					class="card flex flex-wrap align-items-center justify-content-center gap-3 mb-5"
					v-if="$page.props.flash.message != null"
				></div>
				<div class="mb-5 h-fit">
					<p>Variasi</p>
					<input
						type=""
						class="border px-3 py-2 rounded border-gray-300 w-full mb-3"
						placeholder="Variasi"
						v-model="variant"
					/>
					<Message
						:closable="false"
						severity="error"
						v-if="message"
						>{{ message }}</Message
					>
					<p>Gambar</p>
					<div class="h-52 w-full relative">
						<input
							type="file"
							name=""
							@change="imageSave"
							class="cursor-pointer w-full h-full absolute border opacity-0"
							accept="image/*"
							multiple
						/>
						<div
							class="h-full w-full rounded flex items-center justify-center border border-gray-300 mb-3"
						>
							<div class="text-center">
								<div class="flex justify-center">
									<CloudUpload class="w-20 text-gray-400" />
								</div>
								<div v-if="imgPending" class="text-gray-400">
									<p>Pending {{ imgPending }} Gambar</p>
								</div>
							</div>
						</div>
						<p class="font-semibold my-3" v-if="imgPending">Pending {{ imgPending }} Gambar</p>
						<p class="font-semibold my-3" v-if="image.length != 0">Gambar yang tersimpan</p>
						<div
							class="flex grid max-md:grid-cols-2 md:grid-cols-6 justify-center items-left gap-5 mb-3"
						>
							<div v-for="(i, index) in image">
								<!-- <pre>{{ i }}</pre> -->
								<div
									:style="{
										'background-image': `url(${i.path+i.filename})`,
									}"
									class="bg-cover h-40 w-full bg-center rounded"
									@click="imageDelete(i)"
								>
									<div
										class="w-full h-full rounded hover:bg-gray-600 hover:after:content-['Hapus'] flex justify-center items-center cursor-pointer font-black text-white hover:bg-opacity-70 transition"
									></div>
								</div>
							</div>
						</div>
						<div class="flex">
							<Button label="Simpan" @click="upload()" class="mr-3" :disabled="buttonDisabled" outlined />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="fixed bottom-[10%] left-[50%] right-[50%]" v-if="pending">
			<div class="bg-gray-300 py-3 px-5 w-fit bg-opacity-90 rounded-full flex gap-3">
				<Dots class="w-5" />
				<p>Pending</p>
			</div>
		</div>
	</div>
	<!-- <pre>{{image}}</pre> -->
</template>
<script type="text/javascript" setup>
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";
import Button from "primevue/button";
import { ref, onMounted } from "vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import Message from "primevue/message";
import { CloudUpload, Dots } from "@vicons/tabler";
// import { CloudUpload } from "@vicons/tabler";
const props = defineProps({
	attachment: Object,
	ziggy: Object,
	auth: Object,
});

let id = ref(props.ziggy.location.split("/")[4]);
let variantId = ref(props.ziggy.location.split("/")[7]);
const pending = ref(false);

let attachment = ref(props.attachment);

const type = ref([
	{ name: "Makanan/Satuan/pcs" },
	{ name: "Barang/Buah/Item" },
]);

const img = ref([]);
const message = ref(null);
let formData = new FormData();
let variant = ref(props.attachment.variant);
let image = ref([...props.attachment.attachment]);

let imgPending = ref(false);
let buttonDisabled = ref(false);

function imageSave(e) {
	const files = ref([...e.target.files]);
	for (let i in files.value) {
		// let arr = e.target.files[i].name.split(".");
		let arr = ref(files.value[i]);
		
		let arrLength = ref(arr.value.name.split("."));
		switch (arrLength.value[arrLength.value.length - 1]) {
			case "jpg":
			case "png":
			case "jpeg":
				break;
			default:
				return (message.value =
					"File harus format .jpg, .png dan .jpeg");
		}
		if (arr.value.size > 6500000) {
			return (message.value =
					"File tidak boleh lebih dari 6.5MB");
		}
	}
	if ((files.value.length + image.value.length) <= 6) {
		img.value = [];
		imgPending.value = files.value.length;
		for (let i in files.value) {
			formData.append(`image[${i}]`, files.value[i]);
			img.value.push(URL.createObjectURL(files.value[i]));
		}
	} else {
		message.value = image.value.length < 6 ? `Hanya bisa memilih ${6 - (image.value.length)} gambar lagi` : `Gambar sudah batas maksimal, hapus gambar agar bisa upload gambar`;
	}
}
function upload() {
	pending.value = true;
	formData.append("variant", variant.value);
	axios.post(route("attachmentUpload", [id.value, variantId.value]), formData, {
		headers: {
			"Content-Type": "multipart/form-data",
		},
	})
	.then((val)=>{
		message.value = false
		pending.value = false;
		variant.value = val.data.variant
		image.value = [...val.data.attachment]
		imgPending.value = false
	});
	formData = new FormData()
}
function imageDelete(e){
	axios.post(route("imageDelete", [id.value, variantId.value]), {
		params: e
	})
	.then((val)=>{
		image.value = [...val.data.attachment]
	});
}
let form = useForm({});
</script>

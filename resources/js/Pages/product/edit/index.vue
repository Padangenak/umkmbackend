<template>
	<div class="flex pb-52">
		<div
			class="fixed w-full h-screen bg-black z-[99999] flex items-center justify-center bg-opacity-60"
			v-if="alert"
		>
			<div class="rounded-lg bg-gray-50 px-10 py-6 text-center">
				<p class="text-lg font-semibold mb-5">
					Yakin ingin menghapus varian ini
				</p>
				<div class="flex justify-center">
					<Button
						label="Tidak"
						class="mr-5 w-20 text-center"
						@click="alert = false"
						outline
					>
						Tidak
					</Button>
					<Button
						class="text-center"
						type="submit"
						@click="variantDelete"
						:disabled="pending"
					>
						{{ pending ? "Menghapus" : "Hapus" }}
					</Button>
				</div>
			</div>
			<div
				class="w-full h-screen absolute z-[-1]"
				@click="alert = false"
			></div>
		</div>
		<div
			class="fixed w-full h-screen bg-black z-[99999] flex items-center justify-center bg-opacity-60"
			v-if="newVariantModalActive"
		>
			<div class="rounded-lg bg-gray-50 px-10 py-6 text-center">
				<p class="text-lg font-semibold mb-3">
					Masukkan varian dari produk ini
				</p>
				<div>
					<input
						type=""
						name=""
						class="border px-3 w-full rounded mb-2 py-1 border-gray-300"
						placeholder="Nama Varian"
						v-model="newVariantValue"
					/>
				</div>
				<div class="flex justify-end">
					<div class="card flex justify-content-center">
						<Button
							type="submit"
							@click="newVariant"
							:disabled="pending"
						>
							<p class="font-bold">
								{{ pending ? "Membuat" : "Buat" }}
							</p>
						</Button>
					</div>
				</div>
			</div>
			<div
				class="w-full h-screen absolute z-[-1]"
				@click="newVariantModalActive = false"
			></div>
		</div>
		<div class="md:w-2/12">
			<div class="w-full"></div>
			<Sidebar :auth="props.auth" />
			<SidebarPhone :auth="props.auth" />
		</div>
		<div class="max-md:w-full md:w-10/12">
			<div class="pt-28 pb-10 px-10">
				<div class="card" v-if="variant.length == 0">
					<Message :closable="false"
						>Tambahkan Varian Untuk Produk ini</Message
					>
				</div>
				<!-- <pre>{{ props.product }}</pre> -->
				<p class="mb-5 text-lg font-semibold">Edit Produk</p>
				<!-- <pre>{{$page.props.flash.message}}</pre> -->
				<div
					class="card flex flex-wrap align-items-center justify-content-center gap-3 mb-5"
					v-if="$page.props.flash.message != null"
				>
					<InlineMessage severity="success">{{
						$page.props.flash.message
					}}</InlineMessage>
				</div>
				<form @submit.prevent="form.post(route('editProductId', [id]))">
					<div class="mb-5">
						<p>Nama Produk</p>
						<input
							type=""
							v-model="form.product"
							class="border px-3 py-2 rounded border-gray-300 w-full"
							placeholder="Nama Produk"
						/>
						<small class="text-red-600">{{
							form.errors.product
						}}</small>
					</div>
					<div class="mb-5">
						<p>Tipe</p>
						<div class="card flex justify-content-center">
							<Dropdown
								v-model="form.type"
								:options="type"
								optionLabel="name"
								optionValue="name"
								placeholder="Pilih Tipe"
								class="md:w-3/12 md:w-14rem"
							/>
						</div>
						<small class="text-red-600">{{
							form.errors.type
						}}</small>
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
						<small class="text-red-600">{{
							form.errors.price
						}}</small>
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
						<small class="text-red-600">{{
							form.errors.discon
						}}</small>
					</div>
					<div class="mb-5">
						<p>Deskripsi</p>
						<div class="card flex justify-content-center">
							<span class="p-float-label">
								<Textarea
									v-model="form.description"
									rows="5"
									cols="150"
									autoResize
									class="w-full"
								/>
							</span>
						</div>
						<small class="text-red-600">{{
							form.errors.description
						}}</small>
					</div>
					<div class="mb-5">
						<p>Aktif</p>
						<div class="card flex justify-content-center">
									<SelectButton
										v-model="form.active"
										:options="options"
										aria-labelledby="basic"
										@change="active(slotProps.data.id)"
									/>
								</div>
						<small class="text-red-600">{{
							form.errors.active
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
						<Button label="Ubah" outlined type="submit" />
					</div>
				</form>
			</div>
			<div class="px-10">
				<p class="text-lg font-semibold py-3">Varian produk</p>
				<Button
					class="mb-5 font-bold"
					@click="newVariantModalActive = true"
				>
					<p class="font-bold">Buat Varian Baru Untuk Produk ini</p>
				</Button>
				<div class="card">
					<DataTable
						:value="variant"
						paginator
						:rows="20"
						class="z-0 max-md:w-full"
						size="small"
					>
						<Column field="variant" header="Varian"></Column>
						<Column header="Gambar" class="max-md:hidden">
							<template #body="slotProps">
								<div class="flex">
									<div
										v-for="(i, index) in slotProps.data
											.attachment"
										:style="{
											'background-image': `url(${
												i.path + i.filename
											})`,
										}"
										class="w-10 h-10 bg-cover bg-center"
									></div>
								</div>
							</template>
						</Column>
						<Column field="Edit">
							<template #body="slotProps">
								<div>
									<!-- <pre>{{slotProps.data}}</pre> -->
									<Link
										:href="
											route('attachmentproduct', [
												props.product,
												slotProps.data.id,
											])
										"
									>
										<Button label="Edit" />
									</Link>
								</div>
							</template>
						</Column>
						<Column field="Delete">
							<template #body="slotProps">
								<div>
									<Button
										label="Delete"
										@click="
											alertButton(
												props.product,
												slotProps.data.id,
											)
										"
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
<script type="text/javascript" setup>
import Sidebar from "@/Components/sidebar/index.vue";
import SidebarPhone from "@/Components/sidebar/sidebarPhone.vue";
import CascadeSelect from "primevue/cascadeselect";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InlineMessage from "primevue/inlinemessage";
import Textarea from "primevue/textarea";
import RadioButton from "primevue/radiobutton";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import { Link, router } from "@inertiajs/vue3";
import Message from "primevue/message";
import SelectButton from "primevue/selectbutton";

const props = defineProps({
	product: Object,
	ziggy: Object,
	auth: Object,
});

let id = ref(props.ziggy.location.split("/")[4]);

let variant = ref([...props.product.variant]);

const type = ref([
	{ name: "Makanan/Satuan/pcs" },
	{ name: "Barang/Buah/Item" },
]);

const form = useForm({
	product: props.product.product,
	price: props.product.price,
	discon: props.product.discon,
	stock: props.product.stock,
	description: props.product.description,
	type: props.product.type,
	attachment: null,
	active: props.product.active,
});

const variantDelete = function () {
	pending.value = true;
	axios
		.post(
			route("variantDelete", [
				dataAlert.value.product,
				dataAlert.value.id,
			]),
		)
		.then((e) => (variant.value = [...e.data.variant]))
		.then(() => (pending.value = false))
		.then(() => (alert.value = false));
};

const alert = ref(false);
let dataAlert = ref();
let pending = ref(false);

function alertButton(product, id) {
	dataAlert.value = { product: product, id: id };
	alert.value = true;
}

let newVariantModalActive = ref(false);
let newVariantValue = ref("");
function newVariant() {
	pending.value = true;
	axios
		.post(route("newVariant", [id.value]), {
			params: {
				value: newVariantValue.value,
			},
		})
		.then((e) => (variant.value = [...e.data.variant]))
		.then(() => (pending.value = false))
		.then(() => (newVariantModalActive.value = false));
}
watch(newVariantModalActive, () => {
	if (newVariantModalActive.value == false) {
		newVariantValue.value = "";
	}
});
let imageURL = ref(props.product.attachment.path+props.product.attachment.filename);

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
const options = ref(["Off", "On"]);

</script>

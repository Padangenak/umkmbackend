<template>
	<div class="flex pb-20">
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
						@click="productDelete"
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
		<div class="md:w-2/12">
			<!-- <div class="w-full"></div> -->
			<Sidebar :auth="props.auth"  />
			<SidebarPhone :auth="props.auth" />
		</div>
		<div class="w-full">
			<div class="py-28 max-md:px-8 md:px-28">
				<p class="font-semibold text-lg mb-5 select-none">Produk Saya</p>

				<div class="card text-center">
					<DataTable
						:globalFilterFields="['name']"
						v-model:filters="filters"
						:value="product"
						filterDisplay="row"
						dataKey="id"
						tableStyle=""
						paginator
						:rows="20"
						class="z-0 max-md:w-full"
						size="small"
					>
						<template #header>
							<div class="flex justify-content-end">
								<span class="p-input-icon-left">
									<i class="pi pi-search" />
									<input
										v-model="filters.product.value"
										placeholder="Keyword Search"
										class=""
									/>
								</span>
							</div>
						</template>
						<template #empty> No customers found. </template>
						<template #loading>
							Loading customers data. Please wait.
						</template>
						<Column field="product" header="Produk">
							<template #body="slotProps">
								<div class="flex flex-wrap line-clamp-2">
									<p class="w-32 line-clamp-2">
										{{ slotProps.data.product }}
									</p>
								</div>
							</template>
						</Column>
						<Column header="Tipe" class="max-md:hidden">
							<template #body="slotProps">
								<div class="flex flex-wrap">
									{{ typeSplit(slotProps.data.type) }}
								</div>
							</template>
						</Column>
						<Column field="price" header="Harga" class="max-md:hidden">
							<template #body="slotProps">
								<div class="flex flex-wrap">
									<p class="truncate w-24">
										{{ rupiah(slotProps.data.price) }}
									</p>
								</div>
							</template>
						</Column>
						<Column header="Diskon" class="max-md:hidden">
							<template #body="slotProps">
								<div
									class="flex flex-wrap text-center flex justify-center"
								>
									{{ slotProps.data.discon }}%
								</div>
							</template>
						</Column>
						<Column header="variant" class="max-md:hidden">
							<template #body="slotProps">
								<div class="flex flex-wrap">
									{{ slotProps.data.variant.length }}
								</div>
							</template>
						</Column>
						<Column header="Active" class="max-md:hidden">
							<template #body="slotProps">
								<div class="card flex justify-content-center max-md:w-36">
									<SelectButton
										v-model="slotProps.data.active"
										:options="options"
										aria-labelledby="basic"
										@change="active(slotProps.data.id)"
									/>
								</div>
							</template>
						</Column>
						<Column header="Edit">
							<template #body="slotProps">
								<div>
									<!-- <pre>{{slotProps.data}}</pre> -->
									<Link
										:href="
											route('editProduct', [
												slotProps.data.id,
											])
										"
									>
										<Button label="Edit" />
									</Link>
								</div>
							</template>
						</Column>
						<Column header="Delete">
							<template #body="slotProps">
								<div>
									<!-- <pre>{{slotProps.data}}</pre> -->
									<!-- 									<Link
										:href="
											route('editProduct', [
												slotProps.data.id,
											])
										"
									> -->
									<Button
										label="Delete"
										@click="alertButton(slotProps.data.id)"
									/>
									<!-- </Link> -->
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
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import SelectButton from "primevue/selectbutton";
import { FilterMatchMode } from "primevue/api";

const props = defineProps({
	product: Object,
	auth: Object,
});
let product = ref([...props.product]);

const value = ref("On");
const options = ref(["Off", "On"]);

function active(id) {
	axios.post(route("activeProductLoading", [id])).then((val) => {
		product.value = val.data;
	});
}
function typeSplit(e) {
	let split = e.split("/");
	return split[0];
}
const rupiah = (number) => {
	return new Intl.NumberFormat("id-ID", {
		style: "currency",
		currency: "IDR",
	}).format(number);
};

const filters = ref({
	global: { value: null, matchMode: FilterMatchMode.CONTAINS },
	product: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const alert = ref(false)
const pending = ref(false)
const alertData = ref({ id: null })
const alertButton = (val)=>{
	alertData.value.id = val;
	alert.value = true;
}
const productDelete = async()=>{
	pending.value = true;
	axios.post(route('productDelete', [alertData.value.id]))
	.then((val)=>product.value = [...val.data])
	.then(()=>alert.value = false)
	.then(()=>pending.value = false);
}
</script>

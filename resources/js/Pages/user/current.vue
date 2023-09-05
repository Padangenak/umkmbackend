<template>
	<div class="flex">
		<div class="md:w-2/12">
			<div class="w-full"></div>
			<Sidebar :auth="props.auth" />
			<SidebarPhone :auth="props.auth" />
		</div>
		<div class="max-md:w-full md:w-full">
			<div class="py-28 max-md:px-8 md:px-28">
				<p class="font-semibold text-lg mb-5">Pengguna Sekarang</p>
				<div class="card text-center">
					<DataTable
						:globalFilterFields="['name']"
						v-model:filters="filters"
						:value="user"
						filterDisplay="row"
						dataKey="id"
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
										v-model="filters.name.value"
										placeholder="Keyword Search"
										class="font-semibold rounded"
									/>
								</span>
							</div>
						</template>
						<template #empty> No customers found. </template>
						<template #loading> Loading customers data. Please wait. </template>
						<Column field="name" header="Nama">
														<template #body="slotProps">
								<div class="flex flex-wrap line-clamp-2">
									<p class="w-40 line-clamp-2">
										{{ slotProps.data.name }}
									</p>
								</div>
							</template>
						</Column>
						<Column field="store" header="Nama Toko" class="max-md:hidden"></Column>
						<Column field="username" header="Nama Panggilan" class="max-md:hidden"></Column>
						<Column field="address" header="Alamat" class="max-md:hidden"></Column>
						<Column field="role.role" header="Peran" class="max-md:hidden"></Column>
						<Column header="Aktifkan Pengguna">
							<template #body="slotProps">
								<div class="card flex justify-content-center">
									<SelectButton
										v-model="slotProps.data.active"
										:options="options"
										aria-labelledby="basic"
										@change="active(slotProps.data.id)"
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
import { ref } from "vue";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import SelectButton from "primevue/selectbutton";
import { FilterMatchMode } from "primevue/api";

const filters = ref({
	global: { value: null, matchMode: FilterMatchMode.CONTAINS },
	name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});
const props = defineProps({
	user: Object,
	auth: Object,
});
let user = ref([...props.user]);
const value = ref("On");
const options = ref(["Off", "On"]);
function active(id) {
	axios.post(route("currentLoading", [id])).then((val) => {
		user.value = val.data;
	});
}
</script>

<template>
<!-- 	<div
		class="h-screen w-full fixed w-2/12"
		v-show="falseShield"
		@click="activeFalse"
	></div> -->
	<div class="relative z-[50] max-md:hidden">
		<div
			class="w-full py-2 flex items-center max-md:flex-row justify-between px-10 fixed bg-purple-500 text-white shadow z-[1]"
		>
			<div class="max-md:hidden flex gap-10 items-center">
				<p class="py-2 text-xl font-black text-white cursor-pointer">Hujan. Admin</p>
			</div>
			<p
				class="py-2 text-xl font-black text-white md:hidden max-md:basis-1/3 select-none"
			>
				Admin
			</p>

			<div class="max-md:basis-1/3">
				<div
					class="flex items-center max-md:justify-end md:justify-center cursor-pointer select-none"
					@click="profile = !profile"
				>
					<div
						class="w-10 h-10 bg-cover bg-center rounded-full md:mr-3"
						:style="{
							'background-image': `url(${props.auth.user.attachment.path}${props.auth.user.attachment.filename})`,
						}"
					/>
					<p class="max-md:hidden">{{ props.auth.user.name }}</p>
					<CaretSortDown class="w-4 block" />
				</div>
				<div
					class="fixed bg-purple-500 md:rounded max-md:rounded-bl mt-2 select-none max-md:right-0 "
					v-if="profile"
				>
					<Link :href="route('im')">
						<p class="py-2 px-4 hover:bg-purple-400 cursor-pointer text-left">
							Tentang Saya
						</p>
					</Link>
					<form @submit.prevent="form.post(route('logout'))">
						<button
							class="py-2 px-4 hover:bg-purple-400 cursor-pointer w-full text-left"
						>
							Keluar
						</button>
					</form>
				</div>
			</div>
		</div>
		<div class="w-2/12 select-none z-50">
			<div
				class="w-2/12 max-md:w-fit h-screen fixed bg-purple-500 text-white shadow font-semibold"
			>
				<div class="mt-20">
					<Link :href="route('dashboard')">
						<div
							class="cursor-pointer py-4 mt-10 md:px-5 max-md:px-3 hover:bg-purple-400 flex justify-between items-center"
						>
							<div class="flex">
								<Dashboard class="w-5 mr-2 font-black" />
								<p class="max-md:hidden">Dashboard</p>
							</div>
						</div>
					</Link>
					<div
						class="w-full cursor-pointer max-md:flex z-[99999999999999]"
						v-if="props.auth.user.role_id == 1"
					>
						<div
							class="flex justify-between items-center py-4 md:px-5 max-md:px-3 hover:bg-purple-400"
							@click="user = !user"
						>
							<div class="flex">
								<User class="w-5 mr-2 font-black" />
								<p class="max-md:hidden">Pengguna</p>
							</div>
							<div>
								<ChevronDown class="w-4" />
							</div>
						</div>
						<transition>
							<div
								v-show="user"
								class="z-[99999999999999] transition"
							>
								<div class="max-md:hidden">
									<Link :href="route('current')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<Users class="w-5 mr-2" />
											<p>Pengguna Sekarang</p>
										</div>
									</Link>
									<Link :href="route('addUser')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<UserPlus class="w-5 mr-2" />
											<p>Tambah Pengguna</p>
										</div>
									</Link>
								</div>
								<div
									class="md:hidden bg-purple-500 fixed z-[99999999999999]"
									style="z-index: 99999999999999"
								>
									<Link :href="route('current')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<Users class="w-5 mr-2" />
											<p>Pengguna Sekarang</p>
										</div>
									</Link>
									<Link :href="route('addUser')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<UserPlus class="w-5 mr-2" />
											<p>Tambah Pengguna</p>
										</div>
									</Link>
								</div>
							</div>
						</transition>
					</div>
					<div class="w-full cursor-pointer max-md:flex z-50">
						<div
							class="flex justify-between items-center py-4 md:px-5 max-md:px-3 hover:bg-purple-400"
							@click="product = !product"
						>
							<div class="flex">
								<Box class="w-5 mr-2" />
								<p class="max-md:hidden">Produk</p>
							</div>
							<div>
								<ChevronDown class="w-4" />
							</div>
						</div>
						<transition>
							<div v-show="product" class="transition">
								<div class="max-md:hidden transition">
									<Link :href="route('currentProduct')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxModel class="w-5 mr-3" />
											<p>Produk Saya</p>
										</div>
									</Link>
									<Link :href="route('addProduct')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxMultiple class="w-5 mr-3" />
											<p>Tambah Produk</p>
										</div>
									</Link>
									<Link :href="route('productCategory')" v-if="props.auth.user.role_id == 1">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxMultiple class="w-5 mr-3" />
											<p>Kategori Produk</p>
										</div>
									</Link>
								</div>
								<div
									class="md:hidden fixed bg-purple-500 z-[50] transition"
								>
									<Link :href="route('currentProduct')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxModel class="w-5 mr-3" />
											<p>Produk Saya</p>
										</div>
									</Link>
									<Link :href="route('addProduct')">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxMultiple class="w-5 mr-3" />
											<p>Tambah Produk</p>
										</div>
									</Link>

									<Link :href="route('productCategory')" v-if="props.auth.user.role_id == 1">
										<div
											class="px-10 py-4 hover:bg-purple-400 flex"
										>
											<BoxMultiple class="w-5 mr-3" />
											<p>Kategori Produk</p>
										</div>
									</Link>
								</div>
							</div>
						</transition>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript" setup>
import { ref, watch } from "vue";
import { Dashboard, CaretSortDown, CaretSortUp, Close } from "@vicons/carbon";
import { ChevronDown, Menu2 } from "@vicons/tabler";
// import { Link, router } from "@inertiajs/inertia-vue3";
import { Link, router, useForm } from "@inertiajs/vue3";
import {
	User,
	UserPlus,
	Users,
	Box,
	BoxMultiple,
	BoxModel,
} from "@vicons/tabler";

const props = defineProps({
	auth: Object,
});

let user = ref(false);
let product = ref(false);
let profile = ref(false);
let sidebar = ref(true);

watch(product, () => {
	if (product.value) {
		falseShield.value = true;
		user.value = false;
		profile.value = false;
	}
});
watch(user, () => {
	if (user.value) {
		falseShield.value = true;
		product.value = false;
		profile.value = false;
	}
});
watch(profile, () => {
	if (profile.value) {
		falseShield.value = true;
		product.value = false;
		user.value = false;
	}
});
function activeFalse() {
	user.value = false;
	product.value = false;
	falseShield.value = false;
	profile.value = false;
}

let falseShield = ref(false);
const form = useForm({});
</script>
<style scoped>
.v-enter-active,
.v-leave-active {
	transition: opacity 0.2s ease;
}

.v-enter-from,
.v-leave-to {
	opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
	transition: opacity 0s ease;
}

.fade-enter-from,
.fade-leave-to {
	opacity: 0;
}
</style>

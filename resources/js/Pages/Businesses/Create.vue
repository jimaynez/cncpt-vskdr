<template>
<div>
	<!-- HEADER -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('businesses')">Businesses</inertia-link>
		<span class="text-indigo-400 font-medium">/</span> Create
	</h1>

	<!-- FORM.CREATE -->
	<div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
	<form @submit.prevent="store">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">

			<text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
			<select-input v-model="form.category_id" :error="form.errors.category_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Category">
				<option :value="null" />
				<option v-for="category in core_categories" :key="category.id" :value="category.id">{{ category.name_long }}</option>
			</select-input>

			<select-input v-model="form.type_id" :error="form.errors.type_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Type">
				<option :value="null" />
				<option v-for="type in core_types" :key="type.id" :value="type.id">{{ type.name_long }}</option>
			</select-input>

			<number-input v-model="form.latitude" :error="form.errors.latitude" class="pr-6 pb-8 w-full lg:w-1/2" label="Latitude" />
			<number-input v-model="form.longitude" :error="form.errors.longitude" class="pr-6 pb-8 w-full lg:w-1/2" label="Longitude" />
		</div>

		<!-- BUTTON.SUBMIT -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
			<loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Business</loading-button>
		</div>
	</form>
	</div>
</div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import NumberInput from '@/Shared/NumberInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
	metaInfo: { title: 'Create Business' },
	
	components: {
		LoadingButton,
		SelectInput,
		TextInput,
		NumberInput
	},
	
	layout: Layout,
	
	props: {
		core_categories: Array,
		core_types: Array,
	},
	
	remember: 'form',
	
	data() {
		return {
			form: this.$inertia.form({
				category_id: null,
				type_id: null,
				title: null,
				latitude: null,
				longitude: null,
			}),
		}
	},
	
	methods: {
		store() {
			this.form.post(this.route('businesses.store'))
		},
	},
}
</script>

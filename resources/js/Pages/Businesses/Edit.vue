<template>
<div>
	<!-- BREADCRUMBS -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('businesses')">Businesses</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ form.title }} 
	</h1>

	<!-- MSG.TRASHED -->
	<trashed-message v-if="business.deleted_at" class="mb-6" @restore="restore">
		This business has been deleted.
	</trashed-message>

	<!-- FORM.EDIT -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="update">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<!-- INPUT.TITLE-->
			<text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/3" label="Title" />

			<!-- SELECT.CATEGORY -->
			<select-input v-model="form.category_id" :error="form.errors.category_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Category">
				<option :value="null" />
				<option v-for="category in core_categories" :key="category.id" :value="category.id">{{ category.name_long }}</option>
			</select-input>

			<!-- SELECT.TYPE -->
			<select-input v-model="form.type_id" :error="form.errors.type_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Type">
				<option :value="null" />
				<option v-for="type in core_types" :key="type.id" :value="type.id">{{ type.name_long }}</option>
			</select-input>

			<!-- INPUT LAT,LNG -->
			<number-input v-model="form.latitude" :error="form.errors.latitude" class="pr-6 pb-8 w-full lg:w-1/2" label="Latitude" />
			<number-input v-model="form.longitude" :error="form.errors.longitude" class="pr-6 pb-8 w-full lg:w-1/2" label="Longitude" />
		</div>

		<!-- BUTTON.DELETE, BUTTON.SUBMIT -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
			<button v-if="!business.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete business</button>
			<loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update business</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
	metaInfo() {
		return {
			title: `${this.form.title}`,
		}
	},

	components: {
		LoadingButton,
		SelectInput,
		TextInput,
		NumberInput,
		TrashedMessage,
	},

	layout: Layout,

	props: {
		business: Object,
		core_categories: Array,
		core_types: Array,
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				category_id: this.business.category_id,
				type_id: this.business.type_id,
				title: this.business.title,
				latitude: this.business.LocationLat,
				longitude: this.business.LocationLng,
			}),
		}
	},

	methods: {
		update() {
			this.form.put(this.route('businesses.update', this.business.id))
		},
		destroy() {
			if (confirm('Are you sure you want to delete this business?')) {
				this.$inertia.delete(this.route('businesses.destroy', this.business.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this business?')) {
				this.$inertia.put(this.route('businesses.restore', this.business.id))
			}
		},
	},
}
</script>

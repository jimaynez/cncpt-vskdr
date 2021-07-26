<template>
<div>
	<!-- BREADCRUMBS -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('businesses')">Businesses</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ this.business.title }} 
	</h1>

	<!-- MSG.TRASHED -->
	<trashed-message v-if="business.deleted_at" class="mb-6" @restore="restore">
	This business has been deleted.
	</trashed-message>

	<!-- FORM.ANALYSE -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="analyse">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<!-- TITLE.INPUT {!DISABLED} -->
			<text-input v-model="this.business.title" :disabled="this.business.title" class="pr-6 pb-8 w-full lg:w-1/3" label="Title" />
			
			<!-- SELECT.CATEGORY {!DISABLED} -->
			<select-input v-model="this.business.category_id" :disabled="this.business.category_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Category">
				<option :value="null" />
				<option v-for="category in core_categories" :key="category.id" :value="category.id">{{ category.name_long }}</option>
			</select-input>

			<!-- SELECT.TYPE {!DISABLED} -->
			<select-input v-model="this.business.type_id" :disabled="this.business.type_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Type">
				<option :value="null" />
				<option v-for="type in core_types" :key="type.id" :value="type.id">{{ type.name_long }}</option>
			</select-input>

			<!-- INPUT LAT,LNG {!DISABLED} -->
			<text-input v-model="this.business.LocationLat" :disabled="this.business.LocationLat" class="pr-6 pb-8 w-full lg:w-1/3" label="Latitude" />
			<text-input v-model="this.business.LocationLng" :disabled="this.business.LocationLng" class="pr-6 pb-8 w-full lg:w-1/3" label="Longitude" />

			<!-- SELECT.RADIUS -->
			<text-input v-model="this.radius" :disabled="this.radius" class="pr-6 pb-8 w-full lg:w-1/3" label="Radius" />
		</div>

		<!-- BUTTON.RUN -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
			<loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Save Result</loading-button>
		</div>
	</form>
	</div>
</div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
	metaInfo() {
		return {
			title: `${this.business.title}`,
		}
	},

	components: {
		LoadingButton,
		SelectInput,
		TextInput,
		TrashedMessage,
	},

	layout: Layout,

	props: {
		business: Object,
		core_categories: Array,
		core_types: Array,
		radius: Number,
		report_metrics: Object,
		
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				radius: this.radius,
				considered_businesses: this.report_metrics.considered_businesses,
				proximal_businesses: this.report_metrics.proximal_businesses,
				category_compatibility_score: this.report_metrics.category_compatibility_score,
				type_compatibility_score: this.report_metrics.type_compatibility_score,
				distinct_categories: this.report_metrics.distinct_categories,
				distinct_types: this.report_metrics.distinct_types,
			}),
		}
	},

	methods: {
		analyse() {
			this.form.post(this.route('analyserdata.store', this.business.id))
		},
	},
}
</script>

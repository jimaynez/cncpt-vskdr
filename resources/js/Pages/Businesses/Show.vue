<template>
<div>
	<!-- BREADCRUMBS -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('businesses')">Businesses</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ this.business.title }} 
	</h1>

	<!-- FORM.ANALYSE -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="analyse">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">

			<!-- BUSINESS TITLE, CATEGORY, TYPE -->
			<text-input v-model="this.business.title" :disabled="this.business.title" class="pr-6 pb-8 w-full lg:w-1/3" label="Title" />
			<text-input v-model="this.business.category.name_long" :disabled="this.business.category.name_long" class="pr-6 pb-8 w-full lg:w-1/3" label="Category" />
			<text-input v-model="this.business.type.name_long" :disabled="this.business.type.name_long" class="pr-6 pb-8 w-full lg:w-1/3" label="Type" />

			<!-- LAT, LNG, RADIUS -->
			<text-input v-model="this.business.LocationLat" :disabled="this.business.LocationLat" class="pr-6 pb-8 w-full lg:w-1/3" label="Latitude" />
			<text-input v-model="this.business.LocationLng" :disabled="this.business.LocationLng" class="pr-6 pb-8 w-full lg:w-1/3" label="Longitude" />
			<select-input v-model="form.radius" class="pr-6 pb-8 w-full lg:w-1/3" label="Radius">
				<option :value="0" disabled>Select Radius</option>
				<option :value="50">50</option>
				<option :value="100">100</option>
				<option :value="250">250</option>
				<option :value="500">500</option>
			</select-input>
		</div>

		<!-- ANALYSE BUTTON -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
			<loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Analyse business</loading-button>
		</div>
	</form>
	</div>

	<!-- RESULTS SUBSECTION -->
	<h2 class="mt-12 font-bold text-1xl">Results</h2>
	<div class="mt-6 bg-white rounded shadow overflow-x-auto">
	<table class="w-full whitespace-nowrap">
		<tr class="text-left font-bold">
			<th class="px-6 pt-6 pb-4">Result ID</th>
			<th class="px-6 pt-6 pb-4">Created At</th>
			<th class="px-6 pt-6 pb-4" colspan="2">Updated At</th>
		</tr>
		<tr v-for="analyserdatum in business.analyserdata" :key="analyserdatum.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('businesses')">
					{{ analyserdatum.business_id }}-{{ analyserdatum.id }}
					<icon v-if="analyserdatum.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ analyserdatum.created_at }}
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ analyserdatum.updated_at }}
				</inertia-link>
			</td>
			<td class="border-t w-px">
				<inertia-link class="px-4 flex items-center" :href="route('businesses')" tabindex="-1">
					<icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
				</inertia-link>
			</td>
		</tr>

		<!-- IF CONTACTS.EMPTY -->
		<tr v-if="business.analyserdata.length === 0">
			<td class="border-t px-6 py-4" colspan="4">No results found.</td>
		</tr>
	</table>
	</div>



	<!-- RESULTS SUBSECTION -->
	<h2 class="mt-12 font-bold text-1xl">Latest Result</h2>
	<div class="mt-6 bg-white rounded shadow overflow-x-auto">
	<table class="w-full whitespace-nowrap">
		<tr class="text-left font-bold">
			<th class="pl-4 pr-0 pt-6 pb-4">Result ID</th>
			<th class="px-0 pt-6 pb-4">Radius</th>
			<th class="px-0 pt-6 pb-4">#BSN</th>
			<th class="px-0 pt-6 pb-4">CCS</th>
			<th class="px-0 pt-6 pb-4">TCS</th>
			<th class="px-0 pt-6 pb-4">dC</th>
			<th class="px-0 pt-6 pb-4">dT</th>
		</tr>
		<tr v-for="latestdatum in business.latestdata" :key="latestdatum.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
			<td class="border-t">
				<inertia-link class="pl-4 pr-0 flex items-center focus:text-indigo-500" :href="route('businesses')">
					{{ latestdatum.business_id }}-{{ latestdatum.id }}
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.radius }} metres
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.number_of_businesses }}
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.category_compatibility_score }}
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.type_compatibility_score }}
				</inertia-link>
			</td>

			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.distinct_categories }}
				</inertia-link>
			</td>

			<td class="border-t">
				<inertia-link class="px-0 py-4 flex items-center" :href="route('businesses')" tabindex="-1">
					{{ latestdatum.distinct_types }}
				</inertia-link>
			</td>
		</tr>

		<!-- IF CONTACTS.EMPTY -->
		<tr v-if="business.latestdata.length === 0">
			<td class="border-t px-6 py-4" colspan="4">No results found.</td>
		</tr>
	</table>
	</div>
</div>
</template>

<script>
import Icon from '@/Shared/Icon'
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
		Icon,
		LoadingButton,
		SelectInput,
		TextInput,
		TrashedMessage,
	},

	layout: Layout,

	props: {
		business: Object,
		radius: Number,
		lastdata: Object,
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				radius: this.radius,
			}),
		}
	},

	methods: {
		analyse() {
			this.form.post(this.route('businesses.analyse', this.business.id))
		},
	},
}
</script>

<template>
<div>
	<!-- HEADER -->
	<h1 class="mb-8 font-bold text-2xl">Organisations</h1>

	<!-- TOPLINE CLASS -->
	<div class="mb-6 flex justify-between items-center">
		<search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
			<label class="block text-gray-700">Trashed:</label>
			<select v-model="form.trashed" class="mt-1 w-full form-select">
				<option :value="null" />
				<option value="with">With Trashed</option>
				<option value="only">Only Trashed</option>
			</select>
		</search-filter>
		<inertia-link class="btn-indigo" :href="route('organisations.create')">
			<span>Create</span>
			<span class="hidden md:inline">Organisation</span>
		</inertia-link>
	</div>

	<!-- INDEX.TABLE -->
	<div class="bg-white rounded-md shadow overflow-x-auto">
	<table class="w-full whitespace-nowrap">
		<tr class="text-left font-bold">
			<th class="px-6 pt-6 pb-4">Name</th>
			<th class="px-6 pt-6 pb-4">City</th>
			<th class="px-6 pt-6 pb-4">State</th>
			<th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
		</tr>
		<tr v-for="organisation in organisations.data" :key="organisation.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('organisations.edit', organisation.id)">
					{{ organisation.name }}
					<icon v-if="organisation.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
				</inertia-link>
			</td>

			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('organisations.edit', organisation.id)" tabindex="-1">
					{{ organisation.city }}
				</inertia-link>
			</td>

			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('organisations.edit', organisation.id)" tabindex="-1">
					{{ organisation.state }}
				</inertia-link>
			</td>

			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('organisations.edit', organisation.id)" tabindex="-1">
					{{ organisation.phone }}
				</inertia-link>
			</td>

			<td class="border-t w-px">
				<inertia-link class="px-4 flex items-center" :href="route('organisations.edit', organisation.id)" tabindex="-1">
					<icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
				</inertia-link>
			</td>
		</tr>

		<!-- IF ORGANISATIONS.EMPTY -->
		<tr v-if="organisations.data.length === 0">
			<td class="border-t px-6 py-4" colspan="4">No organisations found.</td>
		</tr>
	</table>
	</div>
	<pagination class="mt-6" :links="organisations.links" />
</div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
	metaInfo: { title: 'Organisations' },

	components: {
		Icon,
		Pagination,
		SearchFilter,
	},

	layout: Layout,

	props: {
		filters: Object,
		organisations: Object,
	},

	data() {
		return {
			form: {
				search: this.filters.search,
				trashed: this.filters.trashed,
			},
		}
	},

	watch: {
		form: {
			deep: true,
			handler: throttle(function() {
				this.$inertia.get(this.route('organisations'), pickBy(this.form), { preserveState: true })
			}, 150),
		},
	},

	methods: {
			reset() {
			this.form = mapValues(this.form, () => null)
		},
	},
}
</script>

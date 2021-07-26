<template>
  <div>
	<!-- HEADER -->
  <h1 class="mb-8 font-bold text-2xl">Businesses</h1>

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
      <inertia-link class="btn-indigo" :href="route('businesses.create')">
        <span>Create</span>
        <span class="hidden md:inline">Business</span>
      </inertia-link>
    </div>

	 <!-- TABLE.INDEX -->
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Title</th>
          <th class="px-6 pt-6 pb-4">Category</th>
          <th class="px-6 pt-6 pb-4">Type</th>
          <th class="px-6 pt-6 pb-4">Coordinates</th>
          <th class="px-6 pt-6 pb-4">Analyse</th>
        </tr>
        <tr v-for="business in businesses.data" :key="business.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('businesses.edit', business.id)">
              {{ business.title }}
              <icon v-if="business.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('businesses.edit', business.id)" tabindex="-1">
              <div v-if="business.category">
                {{ business.category.name_long }}
              </div>
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('businesses.edit', business.id)" tabindex="-1">
              <div v-if="business.type">
                {{ business.type.name_long }}
              </div>
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('businesses.edit', business.id)" tabindex="-1">
              {{ business.coordinates }}
            </inertia-link>
          </td>

          <!-- ANALYSER -->
          <td class="border-t w-px pr-3">
            <inertia-link class="btn-indigo px-2.5" :href="route('businesses.show', business.id)">
              <span>Run</span>
              <span class="hidden md:inline">Analyser</span>
            </inertia-link>
          </td>
        </tr>

		  <!-- BUSINESSES.EMPTY -->
        <tr v-if="businesses.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No businesses found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="businesses.links" />
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
  metaInfo: { title: 'Businesses' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    businesses: Object,
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
        this.$inertia.get(this.route('businesses'), pickBy(this.form), { preserveState: true })
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

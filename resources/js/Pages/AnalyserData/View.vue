<template>
<div>
	<!-- BREADCRUMBS -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('businesses')">Rad</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ analyserdata.radius }} 
	</h1>

	<!-- FORM.EDIT -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="update">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<!-- INPUT.TITLE-->
			<text-input v-model="analyserdata.radius" class="pr-6 pb-8 w-full lg:w-1/3" label="Rad" />
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
			title: `${this.analyserdata.radius}`,
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
		business: Array,
      analyserdata: Object,
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				//
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

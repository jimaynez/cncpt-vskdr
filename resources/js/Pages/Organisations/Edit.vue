<template>
<div>
	<!-- BREADCRUMB -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('organisations')">Organisations</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ form.name }}
	</h1>

	<!-- MSG.TRASHED -->
	<trashed-message v-if="organisation.deleted_at" class="mb-6" @restore="restore">
		This organisation has been deleted.
	</trashed-message>

	<!-- FORM.EDIT -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="update">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
			<text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />

			<text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
			<text-input v-model="form.address" :error="form.errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />

			<text-input v-model="form.city" :error="form.errors.city" class="pr-6 pb-8 w-full lg:w-1/2" label="City" />
			<text-input v-model="form.state" :error="form.errors.sstate" class="pr-6 pb-8 w-full lg:w-1/2" label="Province/State" />

			<select-input v-model="form.country" :error="form.errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
				<option :value="null" />
				<option value="ES">Spain</option>
				<option value="US">United States</option>
			</select-input>
			<text-input v-model="form.postal_code" :error="form.errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" />
		</div>

		<!-- BUTTON.DELETE, BUTTON.SUBMIT -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
			<button v-if="!organisation.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Organisation</button>
			<loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Organisation</loading-button>
		</div>
	</form>
	</div>

	<!-- CONTACTS SUBSECTION -->
	<h2 class="mt-12 font-bold text-2xl">Contacts</h2>
	<div class="mt-6 bg-white rounded shadow overflow-x-auto">
	<table class="w-full whitespace-nowrap">
		<tr class="text-left font-bold">
			<th class="px-6 pt-6 pb-4">Name</th>
			<th class="px-6 pt-6 pb-4">Email</th>
			<th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
		</tr>
		<tr v-for="contact in organisation.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
					{{ contact.name }}
					<icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
					{{ contact.email }}
				</inertia-link>
			</td>
			<td class="border-t">
				<inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
					{{ contact.phone }}
				</inertia-link>
			</td>
			<td class="border-t w-px">
				<inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
					<icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
				</inertia-link>
			</td>
		</tr>

		<!-- IF CONTACTS.EMPTY -->
		<tr v-if="organisation.contacts.length === 0">
			<td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
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
		return { title: this.form.name }
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
		organisation: Object,
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				name: this.organisation.name,
				email: this.organisation.email,
				phone: this.organisation.phone,
				address: this.organisation.address,
				city: this.organisation.city,
				state: this.organisation.state,
				country: this.organisation.country,
				postal_code: this.organisation.postal_code,
			}),
			}
	},


	methods: {
		update() {
			this.form.put(this.route('organisations.update', this.organisation.id))
		},
		destroy() {
			if (confirm('Are you sure you want to delete this organisation?')) {
				this.$inertia.delete(this.route('organisations.destroy', this.organisation.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this organisation?')) {
				this.$inertia.put(this.route('organisations.restore', this.organisation.id))
			}
		},
	},
}
</script>

<template>
<div>
	<!-- BREADCRUMBS -->
	<h1 class="mb-8 font-bold text-2xl">
		<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contacts')">Contacts</inertia-link>
		<span class="text-indigo-400 font-medium">/</span>
		{{ form.first_name }} {{ form.last_name }}
	</h1>

	<!-- MSG.TRASHED -->
	<trashed-message v-if="contact.deleted_at" class="mb-6" @restore="restore">
		This contact has been deleted.
	</trashed-message>

	<!-- FORM.UPDATE -->
	<div class="bg-white rounded-md shadow overflow-hidden">
	<form @submit.prevent="update">
		<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
			<text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
			<text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Last name" />
			<select-input v-model="form.organisation_id" :error="form.errors.organisation_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Organisation">
			<option :value="null" />
			<option v-for="organisation in organisations" :key="organisation.id" :value="organisation.id">{{ organisation.name }}</option>
			</select-input>
			<text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
			<text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
		</div>

		<!-- BUTTON.DELETE, BUTTON.SUBMIT -->
		<div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
			<button v-if="!contact.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
			<loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Contact</loading-button>
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
			title: `${this.form.first_name} ${this.form.last_name}`,
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
		contact: Object,
		organisations: Array,
	},

	remember: 'form',

	data() {
		return {
			form: this.$inertia.form({
				first_name: this.contact.first_name,
				last_name: this.contact.last_name,
				organisation_id: this.contact.organisation_id,
				email: this.contact.email,
				phone: this.contact.phone,
			}),
		}
	},

	methods: {
		update() {
			this.form.put(this.route('contacts.update', this.contact.id))
		},
		destroy() {
			if (confirm('Are you sure you want to delete this contact?')) {
				this.$inertia.delete(this.route('contacts.destroy', this.contact.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this contact?')) {
				this.$inertia.put(this.route('contacts.restore', this.contact.id))
			}
		},
	},
}
</script>

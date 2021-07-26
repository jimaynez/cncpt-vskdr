<template>
<div>
	<!-- HEADER TITLE -->
	<h1 class="mb-8 font-bold text-2xl">
		Dashboard
	</h1>

	<!-- TEXT -->
	<div class="rounded-md overflow-hidden">
		Welcome.
	</div>
	<br>
	<div class=" rounded-md overflow-hidden">
		There's nothing here, yet. Feel free to imagine what you think a dashboard should contain.
	</div>
</div>
</template>

<script>
import Layout from '@/Shared/Layout'

	export default {
	metaInfo() {
		return {
			title: `Welcome`,
		}
	},
	components: {
		//
	},
	layout: Layout,
	props: {
		
	},
}
</script>

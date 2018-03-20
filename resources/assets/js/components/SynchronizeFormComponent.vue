<template>
	<div class="form text-center">
		<button 
			class="btn btn-primary synchronize-btn" 
			@click="submit"
			:disabled="syncing">{{ !syncing ? 'Synchronize' : 'Synchronizing ...' }}</button>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				url: '/synchronize',
				syncing: false
			}
		},

		methods: {
			submit() {

				this.syncing = true;

				axios.post(this.url).then(res => {
					alert('Synchronized!');
					this.syncing = false;
				}).catch(err => {
					alert('Something went wrong synchronizing..');
					this.syncing = false;
				});
			}
		}
	}
</script>
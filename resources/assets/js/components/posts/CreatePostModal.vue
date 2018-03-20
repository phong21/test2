<template>
	<div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">{{ post ? 'Edit Post' : 'Create Post' }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label class="col-form-label">Title</label>
	            <input type="text" class="form-control" v-model="form.title">
	          </div>
	          <div class="form-group">
	            <label class="col-form-label">Body:</label>
	            <textarea class="form-control" v-model="form.body"></textarea>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" @click="submit" :disabled="processing">{{ post ? 'Edit' : 'Create' }}</button>
	      </div>
	    </div>
	  </div>
</div>
</template>

<script>
	export default {
		props: ['post'],

		data() {
			return {
				form: {
					title: '',
					body: '',

				},

				processing: false
			}
		},

		mounted() {
			this.setupModalEvents();
		},

		methods: {
			setupModalEvents() {
				let $modal = $('#createPostModal');

				$modal.on('hidden.bs.modal', this.clear);
				$modal.on('shown.bs.modal', (e) => {
					if (this.post) {
						this.form.title = this.post.title;
						this.form.body = this.post.body
					}
				});
			},

			submit() {
				this.processing = true;

				let url = this.post ? `/posts/${this.post.id}`: '/posts',
					method = this.post ? 'put' : 'post';

				axios[method](url, this.form).then(res => {
					this.processing = false;
					this.clear();
					$('#createPostModal').modal('hide');

					!this.post ? this.$emit('post-created', res.data) : this.$emit('post-updated', res.data);

				}).catch(err => this.processing = false);
			},

			clear() {
				this.form.title = '';
				this.form.body = '';
			}
		}
	}
</script>
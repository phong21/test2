<template>
	<div class="modal fade" id="createCommentModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Comment</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label for="recipient-name" class="col-form-label">Email</label>
	            <input type="email" class="form-control" v-model="form.email">
	          </div>
	          <div class="form-group">
	            <label class="col-form-label">Name</label>
	            <input type="text" class="form-control" v-model="form.name">
	          </div>
	          <div class="form-group">
	            <label class="col-form-label">Body:</label>
	            <textarea class="form-control" v-model="form.body"></textarea>
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" @click="submit" :disabled="processing">Add</button>
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
					name: '',
					email: '',
					body: ''
				},

				processing: false
			}
		},

		mounted() {
			this.setupModalEvents();
		},

		methods: {

			setupModalEvents() {
				let $modal = $('#createCommentModal');

				$modal.on('hidden.bs.modal', this.clear);
			},

			submit() {
				let params = {
					name: this.form.name,
					body: this.form.body,
					email: this.form.email,
					postId: this.post.id
				};

				this.processing = true;
				axios.post('/comments', params).then(res => {
					this.$emit('comment-added', res.data, this.post);

					this.processing = false;

					this.clear();
					
					$('#createCommentModal').modal('hide');
				});
			},

			clear() {
				this.form.name = '';
				this.form.email = '';
				this.form.body = '';
			}
		}
	}
</script>
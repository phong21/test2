<template>
    <div>
        <h3 class="post-title mb-lg-4">{{ post.title }}</h3>

        <div class="post-content">{{ post.body }}</div>

        <div class="post-comments">
            <div class="mb-md-3">
                <h5 class="mb-lg-3 mt-lg-5">Comments</h5>
                <button class="btn btn-default" data-toggle="modal" data-target="#createCommentModal">Add Comment</button>
            </div>

            <div class="comments-body">
                <div class="card mb-md-2" v-for="comment in comments">
                    <div class="card-body">
                        <div class="card-title row">
                            <h5 class="col-md-10">{{ comment.name }} ({{ comment.email }})</h5>
                            <div class="col-md-2 text-right">
                                <button class="btn btn-danger" @click="deleteComment(comment)">Delete</button>
                            </div>
                        </div>
                        <p class="card-text">{{ comment.body }}</p>
                    </div>
                </div>
            </div>
        </div>

        <createCommentModal :post="post" @comment-added="getComments"></createCommentModal>
   </div>
</template>
<script>
    export default {
        props: ['post'],

        components: {
            createCommentModal: require('../comments/CreateCommentModal.vue')
        },

        data() {
            return {
                comments: []
            }
        },

        created() {
            this.getComments();
        },

        methods: {
            getComments() {
                axios.get(`/posts/${this.post.id}/comments`).then(res => {
                    console.log(res)
                    this.comments = res.data;
                });
            },

            deleteComment(comment) {
                if (confirm('Are you sure you want to remove this comment?')) {
                    axios.delete(`/comments/${comment.id}`).then(res => {
                        this.getComments();
                    });
                }
            }
        }
    }
</script>
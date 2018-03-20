<template>
    <div class="card">
        <div class="card-header">
            <span>{{ viewingPost ? '' : 'Posts' }}</span>
            <button class="btn btn-success float-right" @click="createPost" v-if="!viewingPost">Create</button>
            <button class="btn btn-success float-right" @click="exitPost" v-else>Back</button>
        </div>

        <div class="card-body">
            <div class="col-md-12" v-if="!viewingPost">
                <div class="card mb-lg-3" v-for="post in posts">
                    <div class="card-body">
                        <h4 class="card-title">{{  post.title }}</h4>
                        <div class="card-text">{{ post.body }}</div>
                        <div class="post-action py-4 text-right">
                            <button class="btn btn-primary" @click="viewPost(post)">View</button>
                            <button class="btn default" @click="editPost(post)">Edit</button>
                            <button class="btn btn-danger" @click="deletePost(post)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <viewPostComponent :post="viewingPost"></viewPostComponent>
            </div>
        </div>

        <createPostModal :post="editingPost" @post-created="addPost" @post-updated="updatePost"></createPostModal>
    </div>
</template>

<script>
    export default {

        components: {
            viewPostComponent: require('./ViewPostComponent.vue'),
            createPostModal: require('./CreatePostModal.vue')
        },

        data() {
            return {
                posts: [],
                viewingPost: null,
                editingPost: null
            }
        },

        mounted() {
            this.getPosts();
        },

        methods: {

            addPost(post) {
                this.posts.unshift(post);
            },

            updatePost(post) {
                let index = this.posts.findIndex(p => {
                    return post.id == p.id;
                });

                Vue.set(this.posts, index, post);
            },

            getPosts() {
                axios.get('/posts').then(res => {
                    this.posts = res.data;
                });
            },

            viewPost(post) {
                axios.get(`/posts/${post.id}`).then(res => {
                    this.viewingPost = res.data;
                });
            },

            deletePost(post) {
                if (confirm('Are you sure you want to delete this post?')) {
                    axios.delete(`/posts/${post.id}`).then(res => {
                        let index = this.posts.findIndex((post) => {
                            return post.id === post.id;
                        })

                        this.posts.splice(index, 1);
                    });
                }
            },

            createPost() {
                this.editingPost = null;

                $('#createPostModal').modal('show');
            },

            editPost(post) {
                this.editingPost = post;

                $('#createPostModal').modal('show');
            },

            exitPost() {
                this.viewingPost = null;
            }
        }
    }
</script>

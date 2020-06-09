<template>
    <div class="container px-5 pt-2 d-none">
        <button type="button" class="ml-2 mb-1 close" aria-label="Close" @click="hideViewSearch">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="row">
            <div class="col-8 offset-2">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <h1>Profiles from Users</h1>
                <div v-if="users !== null && users.length > 0" class="row">
                    <div v-for="(user, n) in users" class="col-6 py-2">
                        <div class="col-12 row">
                            <div class="col-4 p-0">
                                <img v-bind:src="getPathImgProfile(user.profile.image)" class="w-100 rounded-circle"
                                     alt="">
                            </div>
                            <div class="col-8">
                                <div class="pt-2 d-flex align-items-start">
                                    <a v-bind:href="getPathProfile(user.id)">
                                        <h5 class="text-dark font-weight-bold" v-text="user.name"></h5>
                                    </a>
                                </div>
                                <span><b>@</b></span>
                                <span class="text-dark" v-text="user.username"></span>
                                <span v-if="user.id === +me" class="btn btn-outline-dark me">ME</span>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 v-else class="pl-4 py-3 font-weight-bold text-muted">No Any Profile Match with this Search</h4>
                <hr>
                <h1>Some Posts</h1>
                <div v-if="posts !== null && posts.length > 0" class="row">
                    <div v-for="(post, n) in posts" class="col-6 py-1 mb-3">
                        <div class="post-img-container">
                            <img v-bind:src="getPathImgPost(post.image)" class="w-100 rounded post-img" alt="">
                        </div>
                        <div class="d-flex pt-2">
                            <p class="m-0 pl-2">
                                <span><b>@</b></span>
                                <span class="text-dark" v-text="post.user.username"></span>
                                <a v-bind:href="getPathPost(post.id)" class="font-weight-bold text-dark pl-1">
                                    <span v-text="post.caption"></span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <h4 v-else class="pl-4 py-3 font-weight-bold text-muted">No Any Post Match with this Search</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-8 offset-2">
                <hr>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ViewSearch",
        mounted() {
            setInterval(() => {
                this.users = JSON.parse(sessionStorage.getItem('users'));
                this.posts = JSON.parse(sessionStorage.getItem('posts'));
                this.me = sessionStorage.getItem('me');
            }, 100);
        },
        data: function () {
            return {
                users: null,
                posts: null,
                me: null,
            }
        },
        methods: {
            getUsers() {
                if (this.users === null)
                    return JSON.parse(sessionStorage.getItem('users'));
                else
                    return this.users;
            },
            getPosts() {
                if (this.posts === null)
                    return JSON.parse(sessionStorage.getItem('posts'));
                else
                    return this.posts;
            },
            getPathImgProfile(image) {
                let path = (image === null) ? 'uploads/wXgHlUZxP82XAx5MWiEUhLP6DWdoZg956HH8gvbJ.png' : image;
                return '/storage/' + path;
            },
            getPathImgPost(image) {
                return '/storage/' + image;
            },
            getPathProfile(id) {
                return '/profile/' + id;
            },
            getPathPost(id) {
                return '/post/' + id;
            },
            hideViewSearch() {
                $('#search-container').addClass('d-none');
                $('#main-container').removeClass('d-none');
                $('#searchInput').val('');
                sessionStorage.clear();
            },
        }
    }
</script>

<style scoped>
    a {
        transform: none;
        text-decoration: none;
    }

    .close, .close span {
        outline: none;
    }

    .me {
        padding: 1px 4px !important;
        font-size: 10px
    }

    .post-img-container {
        height: 185px;
        overflow: hidden;
    }

    .post-img {
        max-height: 185px;
    }
</style>

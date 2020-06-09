<template>
    <div class="cur-pointer">
        <i :class="linkClass" @click="likePost"></i>
    </div>
</template>

<script>
    export default {
        name: "LikeLink",
        props: ['postId', 'likes'],
        data: function () {
            return {
                status: this.likes
            }
        },
        methods: {
            likePost() {
                axios.post('/like/' + this.postId).then(response => {
                    if (response.status === 200) {
                        this.status = !this.status;
                        let countLikeTag = $('#like-count-' + this.postId + ' b');
                        let countLike = +countLikeTag.html();
                        this.status ? countLikeTag.html(countLike + 1) : countLikeTag.html(countLike - 1)
                    }
                }).catch(error => {
                    if (error.response.status === 401)
                        window.location = '/login';
                });
            }
        },
        computed: {
            linkClass() {
                return (this.status) ? 'text-danger fa fa-1x fa-heart pl-1 pt-1' : 'fa fa-1x fa-heart-o pl-1 pt-1';
            }
        }
    }
</script>

<style scoped>
    .cur-pointer {
        cursor: pointer;
    }
</style>

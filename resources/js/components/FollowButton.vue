<template>
    <div>
        <button class="btn btn-outline-primary" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        name: "FollowButton",
        props: ['userId', 'follows'],
        data: function () {
            return {
                status: this.follows,
            }
        },
        methods: {
            followUser() {
                axios.post('/follow/' + this.userId).then(response => {
                    if (response.status === 200) {
                        this.status = !this.status;
                    }
                }).catch(error => {
                    if (error.response.status === 401)
                        window.location = '/login';
                });
            }
        },
        computed: {
            buttonText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>

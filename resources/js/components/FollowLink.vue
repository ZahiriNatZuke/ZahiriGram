<template>
    <a href="#" target="_blank" class="text-primary pl-2 pb-1 font-weight-bold text-uppercase" @click="followUser"
       v-text="linkText"></a>
</template>

<script>
    export default {
        name: "FollowLink",
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
            linkText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>

<style scoped>
    a {
        font-size: 14px;
        color: #1b2142;
        letter-spacing: .1rem;
    }
</style>

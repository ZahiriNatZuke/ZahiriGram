<template>
    <div>
        <div class="toast">
            <div class="toast-header d-flex justify-content-between">
                <strong :class="tagClass" v-text="title"></strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body font-weight-bold" v-text="message"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Toast",
        data: function () {
            return {
                tagClass: sessionStorage.getItem('class'),
                message: sessionStorage.getItem('message'),
                title: sessionStorage.getItem('title')
            }
        },
        watch: {
            tagClass: function () {
                console.log('tagClass');
                this.debouncedGetData();
            },
            message: function () {
                console.log('message');
                this.debouncedGetData();
            },
            title: function () {
                console.log('title');
                this.debouncedGetData();
            }
        },
        created() {
            this.debouncedGetData = _.debounce(this.getData, 500);
        },
        methods: {
            getData() {
                this.tagClass = sessionStorage.getItem('class');
                this.message = sessionStorage.getItem('message');
                this.title = sessionStorage.getItem('title');
            }
        }
    }
</script>

<style scoped>
    .toast {
        position: fixed;
        bottom: 30px;
        right: 10px;
        width: 300px;
    }

    button.close {
        outline: none;
    }
</style>

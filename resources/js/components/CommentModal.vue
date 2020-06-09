<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-center pb-2">
                        <h1>Post Comment</h1>
                    </div>
                    <div class="form-group">
                        <textarea name="body" :id="id" rows="3" type="text" autofocus
                                  style="resize: none" class="form-control customized-scroll" required></textarea>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"
                                    @click="sendComment">
                                Send Comment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const Swal = require('sweetalert2');
    export default {
        name: "CommentModal",
        props: ['postId', 'user', 'userId'],
        data: function () {
            return {
                id: 'body-' + this.postId,
                toast: 'toast-' + this.postId
            }
        },
        methods: {
            async sendComment() {
                let message;
                let status;
                let tagClass;
                let comment;
                await axios.default.post('/comment/' + this.postId, {
                    body: document.getElementById('body-' + this.postId).value
                }).then((response) => {
                    message = response['data'].message;
                    status = response['data'].status;
                    if (response['data'].status === 'success') {
                        comment = response['data'].comment;
                    }
                }).catch((error) => {
                    console.log(error);
                    message = 'Error Sending Comment';
                    status = 'error';
                }).finally(() => {
                    document.getElementById('body-' + this.postId).value = '';
                    tagClass = (status === 'success') ? 'text-success' : 'text-danger';
                });
                await setTimeout(() => {
                    Swal.fire({
                        title: '<p class="' + tagClass + ' font-weight-bolder"> Comment Notification </p>',
                        html: '<p class="text-dark font-weight-light">' + message + '</p>',
                        position: 'bottom-end',
                        timer: 1200,
                        toast: true,
                        showConfirmButton: false,
                        icon: null
                    });
                }, 500);
                if (status === 'success')
                    setTimeout(() => {
                        if (document.getElementById('list-post-' + this.postId).getElementsByTagName('li').length === 0)
                            document.getElementById('list-post-' + this.postId).style.display = '';

                        if (document.getElementById('list-post-' + this.postId).getElementsByTagName('li').length === 5)
                            document.getElementById('list-post-' + this.postId).lastElementChild.remove();

                        document.getElementById('post-count-' + this.postId).firstElementChild.textContent = '' + (+document.getElementById('post-count-' + this.postId).firstElementChild.textContent + 1);

                        let html = '<li id="post-' + this.postId + '-comment-new-' + comment.id + '" class="d-flex">\n' +
                            '                                <p class="m-0">\n' +
                            '                                    <span class="font-weight-normal">' + comment.body + '</span>\n' +
                            '                                    <span class="text-muted font-weight-bold px-1"> //</span>\n' +
                            '                                    <span class="text-muted">' + comment.created_at.split(' ')[0] + '\n' +
                            '                                    </span>\n' +
                            '                                    <span class="font-weight-normal pl-1" style="font-size: 13px">\n' +
                            '                                    <a class="text-dark"\n' +
                            '                                       href="/profile/' + this.userId + '">\n' +
                            '                                        <b style="font-size: 12px">@</b>' + this.user + '</a>\n' +
                            '                                </span>\n' +
                            '                                </p>\n' +
                            '                            </li>';
                        document.getElementById('list-post-' + this.postId).insertAdjacentHTML('afterbegin', html);
                    }, 1000);
            }
        }
    }
</script>

<style scoped>

</style>

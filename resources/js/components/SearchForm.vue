<template>
    <form class="form-inline pt-3">
        <input id="searchInput" class="form-control mr-sm-2" type="search" aria-label="Search" required
               style="width: 300px">
        <button class="btn btn-outline-dark my-2 my-sm-0" @click="sendSearchQuery" type="submit"
                onclick="event.preventDefault();">
            Search
        </button>
    </form>
</template>

<script>
    export default {
        name: "SearchForm",
        methods: {
            async sendSearchQuery() {
                let query = $('#searchInput').val();
                if (query !== '')
                    await axios.default.get('/post/search/' + query).then(response => {
                        sessionStorage.setItem('users', JSON.stringify(response['data'].users));
                        sessionStorage.setItem('posts', JSON.stringify(response['data'].posts));
                        sessionStorage.setItem('me', response['data'].me);
                    }).catch(error => {
                        console.log(error);
                    }).finally(() => {
                        if (sessionStorage.getItem('users') || sessionStorage.getItem('posts')) {
                            $('#main-container').css('display', 'none');
                            $('#search-container').css('display', '');
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>

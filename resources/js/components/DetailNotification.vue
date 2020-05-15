<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">{{title}}</div>
            <div class="card-body">
                {{content}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DetailNotification',
        data: () => ({
            title: '',
            content: ''
        }),
        created() {
            this.$api.GET(this.$route.fullPath)
                .then(result => {
                    if(result.code == 200) {
                        this.title = result.data.title;
                        this.content = result.data.content;
                    }
                })
        }
    }
</script>

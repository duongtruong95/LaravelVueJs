<template>
    <div>
        <h4>Hello <b class="text-danger">{{email}}</b>, This is Home page</h4>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        computed: {
            email() {
                return this.$store.state.user.email;
            }
        }
    }
</script>

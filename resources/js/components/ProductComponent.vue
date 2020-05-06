<template>
    <div>
        <h4>Hello <b class="text-danger">{{email}}</b>, This is Product page</h4>
    </div>
</template>

<script>
    export default {
        name: 'Product',
        computed: {
            email() {
                return this.$store.state.user.email;
            }
        }
    }
</script>

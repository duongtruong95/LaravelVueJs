<template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            <form>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" v-model="email" class="form-control " name="email" value="" required autocomplete="email" autofocus>

                                        <span class="invalid-feedback" role="alert">
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" v-model="password" class="form-control " name="password" required autocomplete="current-password">

                                        <span class="invalid-feedback" role="alert">
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                            <label class="form-check-label" for="remember">Remember
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="button" class="btn btn-primary" @click.prevent="login">
                                            Login
                                        </button>
                                        <a class="btn btn-link" href="">
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="alert alert-danger" v-if="checkError">
                                    <strong>Sorry!</strong> The email address or password is incorrect.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: 'Login',
        data: () => ({
            email: '',
            password: '',
            checkError: false
        }),
        methods: {
            login() {
               this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                }).then(() => {
                   this.$router.push({path: '/dashboard'});
               }).catch(err => {
                   this.checkError = true;
               })
            }
        }
    }
</script>

<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $t('register') }}</div>
                <div class="card-body">
                    <ul class="alert alert-danger pl-5" v-if="errors.length">
                        <li v-for="error in errors">{{ $t(error) }}</li>
                    </ul>
                    <form method="POST" @submit="checkForm">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ $t('username') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" v-model="username" class="form-control" name="name" value="" autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ $t('email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" v-model="email" class="form-control" name="email" value=""  autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ $t('password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" v-model="password" class="form-control " name="password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ $t('confirm password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" v-model="password_confirmation" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $t('register') }}
                                </button>
                            </div>
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
        name: 'Register',
        data: () => ({
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: []
        }),
        methods: {
            register() {
                axios.post('/register', {
                    name: this.username,
                    email: this.email,
                    password: this.password,
                }).then(() => {
                    this.$router.push( {name: 'login', params: {message: 'created_successfully'}});
                }).catch((err) => {
                    console.log(err);
                })
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.email) {
                    this.errors.push('email_require');
                } else if (!this.validEmail(this.email)) {
                    this.errors.push('email_valid_format');
                }
                if (!this.username) {
                    this.errors.push('username_require');
                }
                if (!this.password) {
                    this.errors.push('password_require');
                }
                if (this.password_confirmation != this.password) {
                    this.errors.push('confirm_password_dont_match');
                }
                if (!this.errors.length) {
                    this.register();
                }

                e.preventDefault();
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $t('login') }}</div>
                    <div class="card-body">
                        <ul class="alert alert-danger pl-5" v-if="errors.length">
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                        <div class="alert alert-success" role="alert" v-if="this.$route.params.message">
                            {{this.$route.params.message}}
                        </div>
                        <form @submit="checkForm" method="POST">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{$t("email")}}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" v-model="email" class="form-control " name="email"
                                           value="" autocomplete="email" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{$t("password")}}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control "
                                           name="password" autocomplete="current-password">

                                    <span class="invalid-feedback" role="alert">
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t('login') }}
                                    </button>
                                    <a class="btn btn-link" href="">
                                    </a>
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
        name: 'Login',
        data: () => ({
            email: '',
            password: '',
            errors: []
        }),
        methods: {
            login() {
                this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                }).then(() => {
                    this.$router.push({path: '/'});
                }).catch((err) => {
                    if (err.response.status) {
                        if (err.response.status == 422) {
                            this.errors.push('The Email address or Password is incorrect.');
                        } else {
                            console.log(err.response.data.error);
                        }
                    }
                })
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.email) {
                    this.errors.push('Email required.');
                } else if (!this.validEmail(this.email)) {
                    this.errors.push('Email Address in invalid format.');
                }
                if (!this.password) {
                    this.errors.push("Password required.");
                }
                if (!this.errors.length) {
                    this.login();
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

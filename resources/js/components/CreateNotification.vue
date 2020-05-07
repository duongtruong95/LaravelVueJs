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
                        <div class="alert alert-success" role="alert" v-if="messageSuccess">
                            Thêm bài đăng thành công!
                        </div>
                        <form method="POST" @submit="checkForm">

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ $t('title')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" v-model="title" class="form-control" name="title"
                                           value="" autocomplete="title" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label text-md-right">{{ $t('content')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="content" type="text" v-model="content" class="form-control"
                                           name="content" value="" autocomplete="content">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t('create') }}
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
        name: 'CreateNotification',
        data: () => ({
            title: '',
            content: '',
            messageSuccess: false,
            errors: []
        }),
        methods: {
            createnOTI() {
                axios.post('/sendMail',
                    {
                        title: this.title,
                        content: this.content
                    },
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            "Authorization": `Bearer ${this.$store.state.user.token}`
                        },
                    }
                ).then(() => {
                    this.title = '';
                    this.content = '';
                    this.messageSuccess = true;
                }).catch((err) => {
                    console.log(err);
                })
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.title) {
                    this.errors.push('email_require');
                }
                if (!this.content) {
                    this.errors.push('username_require');
                }
                if (!this.errors.length) {
                    this.createnOTI();
                }

                e.preventDefault();
            }
        }
    }
</script>

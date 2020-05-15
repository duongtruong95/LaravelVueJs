<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$t("list")}} {{$t("users")}}</div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert" v-if="this.messageSuccess">
                            {{$t("created_successfully")}}
                        </div>
                        <div class="form-group float-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                {{$t("create")}}
                            </button>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user, index in users">
                                        <td class="text-center">{{ pagination.from + index }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td class="text-center">{{ user.level }}</td>
                                        <td>{{ user.created_at }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">
                                                Open modal
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <paginate v-bind:pagination="pagination" v-on:click.native="getUsers(pagination.current_page)" :offset="4"></paginate>
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal" >
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <form method="POST" @submit="checkForm">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ $t('register') }} {{ $t('users') }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <ul class="alert alert-danger pl-5" v-if="errors.length">
                                                        <li v-for="error in errors">{{ $t(error) }}</li>
                                                    </ul>

                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{
                                                            $t('username') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text" v-model="arrUser.name"
                                                                   class="form-control" name="name" value=""
                                                                   autocomplete="name" autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="email"
                                                               class="col-md-4 col-form-label text-md-right">{{
                                                            $t('email') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="text" v-model="arrUser.email"
                                                                   class="form-control" name="email" value=""
                                                                   autocomplete="email">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="password"
                                                               class="col-md-4 col-form-label text-md-right">{{
                                                            $t('password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password" type="password" v-model="arrUser.password"
                                                                   class="form-control " name="password"
                                                                   autocomplete="new-password">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="password-confirm"
                                                               class="col-md-4 col-form-label text-md-right">{{
                                                            $t('confirm password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password-confirm" type="password"
                                                                   v-model="password_confirmation" class="form-control"
                                                                   name="password_confirmation"
                                                                   autocomplete="new-password">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="exampleFormControlSelect1"
                                                               class="col-md-4 col-form-label text-md-right">Role</label>
                                                        <div class="col-md-6">
                                                            <select class="form-control" v-model="arrUser.level">
                                                                <option v-for="role in optionRoles" :value="role.value">
                                                                    {{role.text}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ $t('register') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Paginate from '../Paginate';
    export default {
        name: 'User',
        data: () => ({
            users: [],
            errors: [],
            optionRoles: [
                {
                    text: 'Admin',
                    value: 1
                },
                {
                    text: 'User',
                    value: 0
                }
            ],
            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
                last_page: 1,
            },
            arrUser: {
                name: '',
                email: '',
                password: '',
                level: 1,
            },
            offset: 1,
            password_confirmation: '',
            messageSuccess: false
        }),
        components: {
            Paginate
        },
        created() {
            this.getUsers(this.pagination.current_page);
        },
        methods: {
            register() {
                this.$api.POST('/admin/users', this.arrUser).then(() => {
                    this.messageSuccess = true;
                    $('#myModal').modal('hide');
                    $(document.body).removeClass('modal-open');
                    $('.modal-backdrop').remove();
                })
            },
            checkForm: function (e) {
                this.errors = [];

                if (!this.arrUser.email) {
                    this.errors.push('email_require');
                } else if (!this.validEmail(this.arrUser.email)) {
                    this.errors.push('email_valid_format');
                }
                if (!this.arrUser.name) {
                    this.errors.push('username_require');
                }
                if (!this.arrUser.password) {
                    this.errors.push('password_require');
                }
                if (this.password_confirmation != this.arrUser.password) {
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
            },
            getUsers: function (page) {
                this.$api.GET('/admin/users?page=' + page).then((result) => {
                    this.users = result.data.data;
                    this.pagination = result.data.pagination;
                })
            }
        }

    }
</script>

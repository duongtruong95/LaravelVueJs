<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$t("list")}} {{$t("users")}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <h2>Tiêu đề: {{notification}}</h2>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Trang Thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user, index in users" >
                                        <td class="text-center">{{ pagination.from + index }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td class="text-center" v-bind:class="{ 'text-danger': !user.isRead }">{{ user.isRead ? "Đã đọc" : "Chưa đọc" }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <paginate v-bind:pagination="pagination" v-on:click.native="getUsers(pagination.current_page)" :offset="4"></paginate>
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
        name: 'UserNotification',
        data: () => ({
            users: [],
            notification: [],
            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
                last_page: 1,
            },
            offset: 1,
        }),
        components: {
            Paginate
        },
        created() {
            this.getUsers(this.pagination.current_page);
        },
        methods: {
            getUsers: function (page) {
                this.$api.GET(this.$route.fullPath + '?page=' + page).then((result) => {
                    let data = result.data.data;
                    console.log(data);
                    this.users =data.users;
                    this.notification = data.notification;
                    this.pagination = result.data.pagination;
                })
            }
        }
    }
</script>

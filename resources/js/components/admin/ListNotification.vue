<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$t("list")}} {{$t("notification")}}</div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert" v-if="this.$route.params.message">
                            {{$t(this.$route.params.message)}}
                        </div>
                        <div class="form-group float-right">
                            <router-link :to="{name: 'createNotification'}" class="btn btn-success">{{$t("create")}}
                            </router-link>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="notification, index in notifications">
                                        <td class="text-center">{{ pagination.from + index }}</td>
                                        <td>{{ notification.title }}</td>
                                        <td>{{ notification.content }}</td>
                                        <td>{{ notification.created_by }}</td>
                                        <td>{{ notification.created_at }}</td>
                                        <td class="text-center">
                                            <router-link :to="{path: '/notification/' + notification.id}">
                                                <button type="button" class="btn btn-outline-info">
                                                    Detail Notification
                                                </button>
                                            </router-link>
                                            <router-link :to="{path: '/admin/notification-user/' + notification.id}">
                                                <button type="button" class="btn btn-outline-info">
                                                    Detail User
                                                </button>
                                            </router-link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <paginate v-bind:pagination="pagination" v-on:click.native="getNotifications(pagination.current_page)" :offset="4"></paginate>
                                <!-- Modal -->
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
        name: 'ListNotification',
        data: () => ({
            stt: 0,
            notifications: [],
            usersNotifications: [],
            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
                last_page: 1,
            },
            offset: 1
        }),
        components: {
            Paginate
        },
        created() {
            this.getNotifications(this.pagination.current_page);
        },
        methods: {
            getNotifications: function (page) {
                this.$api.GET('notifications?page=' + page).then((result) => {
                    this.notifications = result.data.data;
                    this.pagination = result.data.pagination;
                })
            }
        }

    }
</script>

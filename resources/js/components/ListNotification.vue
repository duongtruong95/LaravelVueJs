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
                                            <button type="button" class="btn btn-outline-info" data-toggle="modal"
                                                    data-target="#myModal" @click="getUserNotification(notification.id)">
                                                Detail User 213213
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <paginate v-bind:pagination="pagination" v-on:click.native="getNotifications(pagination.current_page)" :offset="4"></paginate>
                                <!-- Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail {{$t("notification")}}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h1 class="text-center">Total User: <span class="text-danger">{{usersNotifications.total}}</span></h1>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="bg-success text-center">Read</h3>
                                                        <ul class="list-group list-group-flush" v-for="usersRead, index in usersNotifications.usersRead">
                                                            <li class="list-group-item">{{index+ 1}}. {{usersRead.email}}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3 class="bg-danger text-center">Unread</h3>
                                                        <ul class="list-group list-group-flush" v-for="usersUnread, index in usersNotifications.usersUnread">
                                                            <li class="list-group-item">{{index+ 1}}. {{usersUnread.email}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    Close
                                                </button>
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
            getUserNotification: function (id) {
                this.$api.GET('/notification/' + id).then((result) => {
                    this.usersNotifications = result.data;
                })
            },
            getNotifications: function (page) {
                this.$api.GET('/notifications?page=' + page).then((result) => {
                    this.notifications = result.data.data;
                    this.pagination = result.data.pagination;
                })
            }
        }

    }
</script>
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
                                        <th>Send By</th>
                                        <th>Send At</th>
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
                                            <button type="button" class="btn btn-outline-info" data-toggle="modal"
                                                    data-target="#myModal" @click="getDetailNotification(notification.id)">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <paginate v-bind:pagination="pagination" v-on:click.native="getNotifications(pagination.current_page)" :offset="4"></paginate>
                                <!-- Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail {{$t("notification")}}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h1 class="text-center">Total User: <span class="text-danger">{{usersNotifications.total}}</span></h1>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="bg-success text-center">Read</h3>
                                                        <ul class="list-group list-group-flush" v-for="usersRead, index in usersNotifications.usersRead">
                                                            <li class="list-group-item">{{index+ 1}}. {{usersRead.email}}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3 class="bg-danger text-center">Unread</h3>
                                                        <ul class="list-group list-group-flush" v-for="usersUnread, index in usersNotifications.usersUnread">
                                                            <li class="list-group-item">{{index+ 1}}. {{usersUnread.email}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    Close
                                                </button>
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
    </div>
</template>

<script>
    import Paginate from './Paginate';
    export default {
        name: 'UserListNotification',
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
            getDetailNotification: function (id) {
                this.$router.push({path: '/notification/' + id});
            },
            getNotifications: function (page) {
                this.$api.GET('/notifications?page=' + page).then((result) => {
                    this.notifications = result.data.data;
                    this.pagination = result.data.pagination;
                })
            }
        }

    }
</script>

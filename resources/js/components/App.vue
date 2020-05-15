<template>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item" v-if="isLogged">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'index'}]"
                                :to="{name: 'index'}">
                                {{$t("home")}}
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="isLogged && isAdmin">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'users'}]"
                                :to="{name: 'users'}">
                                {{$t("users")}}
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="isLogged && !isAdmin">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'userListNotification'}]"
                                :to="{name: 'userListNotification'}">
                                {{$t('notification')}}
                            </router-link>
                        </li>
                        <li class="nav-item" :class="[{active: $route.name === 'createNotification' || $route.name === 'listNotification'}]" v-if="isLogged && isAdmin">
                                <b-dropdown id="dropdown-left" :text="$t('notification')" variant="muted" class="m-0">
                                    <b-dropdown-item :class="[{active: $route.name === 'createNotification'}]" :to="{name: 'createNotification'}">{{$t("create")}}</b-dropdown-item>
                                    <b-dropdown-item :class="[{active: $route.name === 'listNotification'}]" :to="{name: 'listNotification'}">{{$t("list")}}</b-dropdown-item>
                                </b-dropdown>
                        </li>
                        <li class="nav-item" v-if="!isLogged">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'login'}]"
                                :to="{name: 'login'}">
                                {{$t("login")}}
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="!isLogged">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'register'}]"
                                :to="{name: 'register'}">
                                {{$t("register")}}
                            </router-link>
                        </li>
                        <li class="nav-item" v-else>
                            <a
                                class="nav-link cursor-p"
                                @click="logout()">
                                {{$t("logout")}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <select v-model="language" @change="changeLanguage" class="form-control">
                                <option v-for="lang in optionLangs" :value="lang.value">{{lang.text}}</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
    import firebase from "firebase";
    export default {
        name: 'App',
        data: () => ({
            optionLangs: [
                {
                    text: 'Vietnamese',
                    value: 'vn'
                },
                {
                    text: 'English',
                    value: 'en'
                },
                {
                    text: '日本',
                    value: 'jp'
                },
            ],
            language: ''
        }),
        created() {
            let config = {
                apiKey: "AIzaSyBkBQr8hRPB16A6rcC5NLMZUZScM9slDzY",
                authDomain: "rpj-vue.firebaseapp.com",
                databaseURL: "https://rpj-vue.firebaseio.com",
                projectId: "rpj-vue",
                storageBucket: "rpj-vue.appspot.com",
                messagingSenderId: "23595975905",
                appId: "1:23595975905:web:09463c9af3d73da648a3a0",
                measurementId: "G-48R63J06Y6"
            };
            firebase.initializeApp(config);
            const messaging = firebase.messaging();
            messaging
                .requestPermission()
                .then(() => firebase.messaging().getToken())
                .then((token) => {
                    console.log(token) // Receiver Token to use in the notification
                })
                .catch(function(err) {
                    console.log("Unable to get permission to notify.", err);
                });
            messaging.onMessage((payload) => {
                alert('Có thông báo mới123!!', payload);
                // ...
            });

            this.language = this.$store.state.lang;
            this.$store.dispatch('setLang', this.$store.state.lang);
        },
        computed: {
            isLogged() {
                return this.$store.state.isLogged;
            },
            isAdmin() {
                return this.$store.state.user.level;
            }
        },
        methods: {
            changeLanguage() {
                this.$store.dispatch('setLang', this.language);
            },
            logout() {
                this.$store.dispatch('logout');
            }
        }
    }
</script>

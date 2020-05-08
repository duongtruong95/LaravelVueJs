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
                                :class="[{active: $route.name === 'createNotification'}]"
                                :to="{name: 'createNotification'}">
                                {{$t("create_notification")}}
                            </router-link>
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

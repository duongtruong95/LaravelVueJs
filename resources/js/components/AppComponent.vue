<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'index'}]"
                                :to="{name: 'index'}" v-if="isLogged || checkLogin">
                                Home
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'dashboard'}]"
                                :to="{name: 'dashboard'}" v-if="isLogged || checkLogin">
                                Dashboard
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'login'}]"
                                :to="{name: 'login'}" v-if="!isLogged && !checkLogin">
                                Login
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" @click="logout()" v-if="isLogged || checkLogin">
                                Logout
                            </button>
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
        created() {
            this.checkLogin = localStorage.getItem('user');
        },
        computed: {
            isLogged () {
                return this.$store.state.isLogged;
            }
        },
        methods: {
            logout () {
                this.$store.dispatch('logout');
            }
        }
    }
</script>

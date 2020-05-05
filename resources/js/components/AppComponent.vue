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
                                :to="{name: 'index'}">
                                Home
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                :class="[{active: $route.name === 'login'}]"
                                :to="{name: 'login'}">
                                Login
                            </router-link>
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
    }
</script>

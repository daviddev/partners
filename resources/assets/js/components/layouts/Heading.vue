<template>
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="/images/logo.png"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="/images/logo.png"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <router-link v-for="(item, index) in menuItems" :key="index" tag="li" :to="item.url">
                            <a>{{ item.name }}</a>
                        </router-link>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ user.name }} <span class="caret"></span>
                                </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/logout" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" :value="csrf_token">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        name: 'heading',
        data() {
            return {
                csrf_token,
                menuItems: [
                    {
                        name: 'Home',
                        url: '/'
                    },
                    {
                        name: 'Referrals',
                        url: '/referrals'
                    }
                ]
            }
        }
    }
</script>

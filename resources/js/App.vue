<template>
  <div class="container">
    <sidebar-menu :menu="menu" />
    <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data() {
            return {

                menu: [
                    {
                        href: '/',
                        title: 'Home',
                        icon: 'fa fa-home'
                    },
                    {
                        href: '/add',
                        title: 'Add Project',
                        icon: 'fa fa-plus-circle'
                    },
                ]
            }
        }
    }
</script>
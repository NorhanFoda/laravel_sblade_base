<template>
    <div class="main-navbar side-menu main-sidebar-sticky">
        <div class="sidemenu-logo">
            <a class="main-logo" href="">
                <img :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img desktop-logo" alt="logo"/>
                <img :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img icon-logo" alt="logo"/>
                <img :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img desktop-logo theme-logo" alt="logo"/>
                <img :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img icon-logo theme-logo" alt="logo"/>
            </a>
        </div>
        <div class="container main-sidemenu">
            <div class="main-sidebar-body">
                <ul class="nav">
                    <li :class="`nav-item ${this.$route.name === 'dashboard' ? 'active' : ''}`">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="las la-tv mx-1"></i>
                            <span class="sidemenu-label">{{ $t("sidebar.dashboard") }}</span>
                        </router-link>
                    </li>
                    <li :class="`nav-item ${this.$route.name === 'users' ? 'active' : ''}`"
                        v-if="hasPermission('read', 'User')">
                        <router-link to="/users" class="nav-link">
                            <i class="las la-users mx-1"></i>
                            <span class="sidemenu-label">{{$t("sidebar.users")}}</span>
                        </router-link>
                    </li>
                    <li :class="`nav-item ${this.$route.name === 'roles' ? 'active' : ''}`"
                        v-if="hasPermission('read', 'Role')">
                        <router-link to="/roles" class="nav-link">
                            <i class="las la-user-lock mx-1"></i>
                            <span class="sidemenu-label">{{ $t("sidebar.roles") }}</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "side-bar",
    mounted: function () {
        $(".main-navbar .subMenu").on("click", function (e) {
            e.preventDefault();
            $(this).parent().toggleClass("show");
            $(this).parent().siblings().removeClass("show");
        });
    },
};
</script>

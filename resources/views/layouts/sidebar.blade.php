<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <x-sidebar.header />

    <hr class="horizontal light mt-0 mb-2" />

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <x-sidebar.item href="{{ route('home') }}" icon="dashboard" label="{{__('app.sidebar.dashboard')}}" />
            <x-sidebar.item href="{{ route('users.index') }}" icon="person" label="{{__('app.sidebar.users')}}" />
            {{-- <x-sidebar.item href="./pages/tables.html" icon="table_view" label="Tables" />
            <x-sidebar.item href="./pages/billing.html" icon="receipt_long" label="Billing" />
            <x-sidebar.item href="./pages/virtual-reality.html" icon="view_in_ar" label="Virtual Reality" />
            <x-sidebar.item href="./pages/rtl.html" icon="format_textdirection_r_to_l" label="RTL" />
            <x-sidebar.item href="./pages/notifications.html" icon="notifications" label="Notifications" />

            <x-sidebar.delimiter title="Account pages" />

            <x-sidebar.item href="./pages/profile.html" icon="person" label="Profile" />
            <x-sidebar.item href="./pages/sign-in.html" icon="login" label="Sign In" />
            <x-sidebar.item href="./pages/sign-up.html" icon="assignment" label="Sign Up" /> --}}

        </ul>
    </div>

    <x-sidebar.footer />

</aside>

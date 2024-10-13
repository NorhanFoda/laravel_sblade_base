<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 ms-3 bg-gradient-dark
        @if(app()->getLocale()=='ar') fixed-end rotate-caret @else fixed-start  @endif
    "
    id="sidenav-main">
        <x-sidebar.header/>

        <hr class="horizontal light mt-0 mb-2"/>

        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <x-sidebar.item href="{{ route('home') }}" icon="dashboard"
                                label="{{ __('messages.sidebar.dashboard') }}"
                                :activeList="['home']"/>
                @canany(['create-user', 'read-user', 'update-user', 'delete-user'])
                    <x-sidebar.item href="{{ route('users.index') }}" icon="person"
                                    label="{{ __('messages.sidebar.users') }}"
                                    :activeList="['users.index', 'users.create', 'users.edit']"/>
                @endcanany
                @canany(['create-role', 'read-role', 'update-role', 'delete-role'])
                    <x-sidebar.item href="{{ route('roles.index') }}" icon="person"
                                    label="{{ __('messages.sidebar.roles_and_permissions') }}"
                                    :activeList="['roles.index', 'roles.create', 'roles.edit']"/>
                @endcanany

                <li></li>
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

        <x-sidebar.footer/>

    </aside>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <x-sidebar.header/>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <x-sidebar.item href="{{ route('dashboard') }}" icon="fa-tachometer-alt" label="Dashboard"/>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <x-sidebar.title title="Interface"/>

    <!-- Nav Item - Pages Collapse Menu -->
    <x-sidebar.collaps collapsId="users" collapsLabel="Users">
        <x-slot name="collapsItems">
            <x-sidebar.collaps-item href="{{route('users.index')}}" label="All Users"/>
            <x-sidebar.collaps-item href="{{route('users.create')}}" label="Add User"/>
        </x-slot>
    </x-sidebar.collaps>

    <!-- Sidebar Toggler (Sidebar) -->
    <x-sidebar.toggle/>

    <!-- Sidebar Message -->
    <x-sidebar.footer/>

</ul>
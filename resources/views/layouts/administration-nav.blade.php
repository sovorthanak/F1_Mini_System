<x-app-layout>
    <div class="admin-nav">
        <div class="admin-nav-conrtainer">
            <a href="/administration/users">
                <button class="{{ Request::segment(2) == 'users' ? 'active' : '' }}">
                    Users
                </button>
            </a>  
            <a href="/administration/user-groups">
                <button class="{{ Request::segment(2) == 'user-groups' ? 'active' : '' }}">
                    User Groups
                </button>
            </a>  
            <a href="/administration/roles">
                <button class="{{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                    Roles
                </button>
            </a>
            <a href="/administration/permissions">
                <button class="{{ Request::segment(2) == 'permissions' ? 'active' : '' }}">
                    Permissions
                </button>
            </a>
            <a href="/administration/tariffs">
                <button class="{{ Request::segment(2) == 'tariffs' ? 'active' : '' }}">
                    Tariffs
                </button>
            </a>
            <a href="/administration/bandwidths">
                <button class="{{ Request::segment(2) == 'bandwidths' ? 'active' : '' }}">
                    Bandwidths
                </button>
            </a>
            <a href="/administration/locations">
                <button class="{{ Request::segment(2) == 'locations' ? 'active' : '' }}">
                    Locations
                </button>
            </a>
            <a href="/administration/ip-pools">
                <button class="{{ Request::segment(2) == 'ip-pools' ? 'active' : '' }}">
                    Ip Pools
                </button>
            </a>
        </div>
        <div class="har-line">

        </div>
    </div>



    <div>
        @yield('content')
    </div>

</x-app-layout>
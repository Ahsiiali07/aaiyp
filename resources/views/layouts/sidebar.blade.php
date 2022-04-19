<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('home*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{url('/home')}}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('users')}}">
                    <i class="nav-icon i-Conference"></i>
                    <span class="nav-text">Users</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('leaders*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('leaders')}}">
                    <i class="nav-icon i-Conference"></i>
                    <span class="nav-text">Leaders</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('category*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('categories')}}">
                    <i class="nav-icon i-Tag"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('group*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('groups')}}">
                    <i class="nav-icon i-Shop"></i>
                    <span class="nav-text">Groups</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('feeds*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('feeds')}}">
                    <i class="nav-icon i-Recycling-2"></i>
                    <span class="nav-text">Feeds</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('reported-feed*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{url('reported-feed')}}">
                    <i class="nav-icon i-Support"></i>
                    <span class="nav-text">Reported Feeds</span>
                </a>
                <div class="triangle"></div>
            </li>



            <li class="nav-item {{ request()->is('content-management*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('cms')}}">
                    <i class="nav-icon i-Gear-2"></i>
                    <span class="nav-text">Content Management</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('support*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{url('support')}}">
                    <i class="nav-icon i-Support"></i>
                    <span class="nav-text">Support</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->

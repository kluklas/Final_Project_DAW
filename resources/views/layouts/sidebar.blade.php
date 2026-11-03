@php
    $user = auth()->user();
@endphp
<div class="sidebar dark:bg-coal-600 bg-light border-r border-r-gray-200 dark:border-r-coal-100 fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0"
    data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false"
    id="sidebar">
    <div class="sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
        id="sidebar_header">
        <a href="{{route('dashboard')}}">
            <img class="default-logo max-h-[100px]" alt="logo LMV"
                src="{{asset('assets/media/reservas/logo_descriptor.png')}}" />
            <img class="small-logo max-h-[40px]" alt="logo LMV"
                src="{{asset('assets/media/reservas/logo_icono.png')}}" />
        </a>
        <button
            class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-200 dark:border-gray-300 bg-light text-gray-500 hover:text-gray-700 toggle absolute left-full top-2/4 -translate-x-2/4 -translate-y-2/4"
            data-toggle="body" data-toggle-class="sidebar-collapse" id="sidebar_toggle">
            <i class="ki-filled ki-black-left-line {{isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on" ? 'rotate-180' : ''}} toggle-active:rotate-180 transition-all duration-300">
            </i>
        </button>
    </div>
    <div class="sidebar-content flex flex-col justify-between grow shrink-0 py-5 pr-2" id="sidebar_content">
        <div class="scrollable-y-hover overflow-y-auto grow shrink-0 flex pl-2 lg:pl-5 pr-1 lg:pr-3"
            data-scrollable="true" data-scrollable-dependencies="#sidebar_header" data-scrollable-height="auto"
            data-scrollable-offset="0px" data-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <div class="menu flex flex-col grow gap-0.5" data-menu="true" data-menu-accordion-expand-all="false"
                id="sidebar_menu">
                <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"
                        class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] pl-[10px] pr-[10px] py-[6px]"
                        tabindex="0">
                        <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                            <i class="ki-filled ki-home text-lg"></i>
                        </span>
                        <span class="menu-title text-sm font-semibold text-gray-700 menu-item-active:text-primary menu-link-hover:!text-primary">
                            Dashboard
                        </span>
                    </a>
                </div>
                <!-- Only Admin -->
                @if ($user->hasRole('Admin'))
                <div class="menu-item {{  request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index')}}"
                        class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] pl-[10px] pr-[10px] py-[6px]"
                        tabindex="0">
                        <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                            <i class="ki-filled ki-user text-lg">
                            </i>
                        </span>
                        <span
                            class="menu-title text-sm font-semibold text-gray-700 menu-item-active:text-primary menu-link-hover:!text-primary">
                            Clientes
                        </span>
                    </a>
                </div>
                @endif
                <!-- Only Employee -->
            </div>
        </div>
    </div>
</div>
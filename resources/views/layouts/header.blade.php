<header class="header fixed top-0 z-10 left-0 right-0 flex items-stretch shrink-0 bg-[#fefefe] dark:bg-coal-500" data-sticky="true" data-sticky-class="shadow-sm dark:border-b dark:border-b-coal-100" data-sticky-name="header" id="header">
    <div class="container-fluid flex justify-between items-stretch lg:gap-4" id="header_container">
        <div class="flex gap-1 lg:hidden items-center -ml-1">
            <a class="shrink-0" href="{{ route('dashboard')}}">
                <img class="dark:hidden max-h-[50px] w-full"
                    src="{{asset('assets/media/codeon/logo_icono.png')}}"/>
                <img class="hidden dark:block max-h-[50px] w-full"
                    src="{{asset('assets/media/codeon/logo_icono.png')}}"/>
            </a>
            <div class="flex items-center">
                <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#sidebar">
                    <i class="ki-filled ki-menu">
                    </i>
                </button>
                <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#megamenu_wrapper">
                    <i class="ki-filled ki-burger-menu-2">
                    </i>
                </button>
            </div>
        </div>
        <div class="flex items-stretch" id="megamenu_container"></div>
        @php
            $user = auth()->user();
        @endphp
        <div class="flex items-center gap-2 lg:gap-3.5">
            <div class="menu" data-menu="true">
                <div class="menu-item" data-menu-item-offset="20px, 10px" data-menu-item-placement="bottom-end" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
                    <div class="menu-toggle btn btn-icon rounded-full">
                        @if($user && $user->avatar)
                            <img alt="avatar" class="size-9 rounded-full border-2 border-success shrink-0" src="{{ route('profile.avatar') }}"/>
                        @else
                            <div class="size-9 rounded-full inline-flex items-center justify-center text-xl font-semibold border border-primary-clarity bg-primary-light text-primary shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[250px]">
                        <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
                            <div class="flex items-center gap-2">
                                @if($user && $user->avatar)
                                    <img alt="avatar" class="size-9 rounded-full border-2 border-success" src="{{ route('profile.avatar') }}"/>
                                @else
                                    <div class="size-9 rounded-full inline-flex items-center justify-center text-xl font-semibold border border-primary-clarity bg-primary-light text-primary">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex flex-col gap-1.5">
									<span class="text-sm text-gray-800 font-semibold leading-none">{{$user->name}}</span>
                                    <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none" href="#">
                                        {{$user->email}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-separator"></div>
                        <div class="flex flex-col">
                            <div class="menu-item">
                                <a class="menu-link" href="{{route('profile.index')}}">
									<span class="menu-icon">
										<i class="ki-filled ki-profile-circle"></i>
									</span>
                                    <span class="menu-title">
										Mi Perfil
									</span>
                                </a>
                            </div>
                        </div>
                        <div class="menu-separator"></div>
                        <div class="flex flex-col">
                            <div class="menu-item mb-0.5">
                                <div class="menu-link">
									<span class="menu-icon">
										<i class="ki-filled ki-moon">
										</i>
									</span>
                                    <span class="menu-title">
										Modo oscuro
									</span>
                                    <label class="switch switch-sm">
                                        <input data-theme-state="dark" data-theme-toggle="true" name="check" type="checkbox" value="1"/>
                                    </label>
                                </div>
                            </div>
                            <div class="menu-item px-4 py-1.5">
                                <a class="button-ajax btn btn-sm btn-light justify-center" href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}">
                                    Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

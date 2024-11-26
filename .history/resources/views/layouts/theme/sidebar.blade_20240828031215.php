<div class="sidebar-wrapper sidebar-theme">
    <nav id="compactSidebar" class="sliderbar">
        <ul class="menu-categories sliderbar">
            <li class="menu active">
                <a href="#dashboard" data-active="true" class="menu-toggle">
                    <div class="base-menu" bis_skin_checked="1">
                        <div class="base-icons" bis_skin_checked="1">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <span>Administracion</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>
            <li class="menu active">
                <a href="#clientes" data-active="true" class="menu-toggle">
                    <div class="base-menu" bis_skin_checked="1">
                        <div class="base-icons" bis_skin_checked="1">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <span>Clientes</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>
            <li class="menu active">
                <a href="#sistema" data-active="true" class="menu-toggle">
                    <div class="base-menu" bis_skin_checked="1">
                        <div class="base-icons" bis_skin_checked="1">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <span>Sistema</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>
        </ul>
    </nav>

    <div id="compact_submenuSidebar" class="submenu-sidebar ps">

        <div class="submenu show" id="dashboard" bis_skin_checked="1">
            <ul class="submenu-list" data-parent-element="#dashboard">

                {{-- @role('Admin') --}}

                {{-- @endcan --}}
                <li class="active">
                    <a href="{{url('gruposM')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Grupos Musculares</span>
                        </div>
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('videos')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Videos</span>
                        </div>
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('tags')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Tags</span>
                        </div>
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('equipo')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Equipo de Entramiento</span>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
        <div class="submenu show" id="clientes" bis_skin_checked="1">
            <ul class="submenu-list" data-parent-element="#dashboard">

                {{-- @role('Admin') --}}
                <li class="active">
                    <a href="{{url('clientes')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <span>Clientes</span>
                        </div>
                    </a>
                </li>
                {{-- @endcan --}}
                <li class="active">
                    <a href="{{url('rp')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Rutinas perzonalizadas</span>
                        </div>
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('rutinas')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Rutinas Publicas</span>
                        </div>
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('categories')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Seguimientos</span>
                        </div>
                    </a>
                </li>


            </ul>
        </div>

        <div class="submenu show" id="sistema" bis_skin_checked="1">
            <ul class="submenu-list" data-parent-element="#dashboard">

                {{-- @role('Admin') --}}
                <li class="active">
                    <a href="{{url('users')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <span>Usuarios</span>
                        </div>
                    </a>
                </li>
                {{-- @endcan --}}
                <li class="active">
                    <a href="{{url('roles')}}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>Roles</span>
                        </div>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>
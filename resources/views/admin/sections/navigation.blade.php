<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title">
                <span>{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="../../../images/mongodb-vs-mysql.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <h2>MongoDB vs MySQL</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_0') }}</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_0_1') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_1') }}</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('users.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('companies.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Compañías
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Categorías
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pricelists.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Listas de precio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('entities.dashboard') }}">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            Entidades
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Productos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('documents.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Documentos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fiscalpos.dashboard') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Fiscalpos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home.models') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Otros modelos
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_2') }}</h3>

                <ul class="nav side-menu">
                    <li>
                        <a>
                            <i class="fa fa-list"></i>
                            {{ __('views.backend.section.navigation.menu_2_1') }}
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ route('log-viewer::dashboard') }}">
                                    {{ __('views.backend.section.navigation.menu_2_2') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('log-viewer::logs.list') }}">
                                    {{ __('views.backend.section.navigation.menu_2_3') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>

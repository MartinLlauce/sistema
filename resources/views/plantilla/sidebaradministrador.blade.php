<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand">
                        <h2 class="brand-text mb-0" style="color:#F8CD51;">Femec</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 success toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon success" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" navigation-header">
                    <span>Módulos</span>
                </li>
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Escuelas
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=2000">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Escuelas
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-book"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Talleres
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1500">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Talleres
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class=" nav-item">
                    <a>
                        <i class="feather icon-server"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Categorias
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=3000">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Categorias
                                </span>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class=" nav-item">
                    <a>
                        <i class="feather icon-user"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Alumnos
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=100">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Alumnos
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class=" nav-item">
                    <a>
                        <i class="feather icon-user"></i>
                        <span class="menu-title" data-i18n="Ecommerce">
                            Promotores
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @click="menu=1020">
                            <a>
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">
                                    Gestionar Promotores
                                </span>
                            </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>


<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a  
                class="nav-link @if (Session::get('page') == "dashboard") activeNavItem @endif" 
                href="{{ url('admin/dashboard') }}"
            >
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::guard('admin')->user()->type=="vendor")
            <li class="nav-item">
                <a 
                    class="nav-link @if (Session::get('page') == "update_personal-details" || Session::get('page') == "update_business-details" || Session::get('page') == "update_bank-details") activeNavItem @endif" 
                    data-toggle="collapse" 
                    href="#ui-vendors" 
                    aria-expanded="false" 
                    aria-controls="ui-vendors"
                >
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Vendor Details</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-vendors">
                    <ul class="nav flex-column sub-menu notActiveNavItem">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "update_personal-details")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/update-vendor-details/personal') }}"
                            >
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                id="sec"
                                @if (Session::get('page') == "update_business-details")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/update-vendor-details/business') }}"
                            >
                                Business Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "update_bank-details")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif
                                href="{{ url('admin/update-vendor-details/bank') }}"
                            >
                                Bank Details
                            </a>
                        </li>
                    </ul>
                </div>
            </li> 
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "products" || Session::get('page') == "coupons")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-catalogue" 
                    aria-expanded="false" 
                    aria-controls="ui-catalogue"
                >
                    {{-- <p>{{ Session::get('page') }}</p> --}}
                    <i class="icon-paper-stack menu-icon"></i>
                    <span class="menu-title">Catalogue<br> Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-catalogue">
                    <ul class="nav flex-column sub-menu notActiveNavItem">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "products")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/products') }}" 
                            >
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "coupons")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/coupons') }}" 
                            >
                                Coupons
                            </a>
                        </li>
                    </ul>
                </div>
            </li> 
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "orders")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-orders" 
                    aria-expanded="false" 
                    aria-controls="ui-orders">
                <i class="mdi mdi-credit-card-multiple menu-icon"></i>
                <span class="menu-title">Orders<br> Management</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-orders">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #0e0c9b !important;">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "orders")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/orders') }}" 
                            >
                                Orders
                            </a>
                        </li>
                    </ul>
                </div>
            </li>  
        @else
            <li class="nav-item">
                <a 
                    class="nav-link @if (Session::get('page') == "update_admin-password" || Session::get('page') == "update_admin-details")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-settings" 
                    aria-expanded="false" 
                    aria-controls="ui-settings"
                >
                    <i class="icon-cog menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-settings">
                    <ul class="nav flex-column sub-menu notActiveNavItem">
                        <li class="nav-item"> 
                            <a 
                                id="sec"
                                @if (Session::get('page') == "update_admin-password")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/update-admin-password') }}"
                            >
                                Update Password
                            </a>
                        </li>
                        <li class="nav-item"> 
                            <a 
                                id="sec"
                                @if (Session::get('page') == "update_admin-details")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/update-admin-details') }}"
                            >
                                Update Details
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link @if (Session::get('page') == "view_admins" || Session::get('page') == "view_subadmins" || Session::get('page') == "view_vendors" || Session::get('page') == "view_all")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-admin" 
                    aria-expanded="false" 
                    aria-controls="ui-admin"
                >
                    <i class="icon-star menu-icon"></i>
                    <span class="menu-title">Admins<br> Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-admin">
                    <ul class="nav flex-column sub-menu notActiveNavItem">
                        <li class="nav-item">
                            <a
                                id="sec"
                                @if (Session::get('page') == "view_admins")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/admins/admin') }}"
                            >
                                Admins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "view_subadmins")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/admins/subadmin') }}"
                            >
                                Subadmins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "view_vendors")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/admins/vendor') }}"
                            >
                                Vendors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                id="sec" 
                                @if (Session::get('page') == "view_all")
                                class="nav-link activeNavItem"
                                @else
                                class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/admins') }}"
                            >
                                All
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "sections" 
                                    || Session::get('page') == "categories" 
                                    || Session::get('page') == "brands" 
                                    || Session::get('page') == "products" 
                                    || Session::get('page') == "coupons"
                                    || Session::get('page') == "filters"
                                    || Session::get('page') == "filters_values"
                                    )
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-catalogue" 
                    aria-expanded="false" 
                    aria-controls="ui-catalogue"
                >
                    {{-- <p>{{ Session::get('page') }}</p> --}}
                    <i class="icon-paper-stack menu-icon"></i>
                    <span class="menu-title">Catalogue<br> Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-catalogue">
                    <ul class="nav flex-column sub-menu notActiveNavItem">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "sections")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif   
                                href="{{ url('admin/sections') }}"
                            >
                                Sections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"    
                                @if (Session::get('page') == "categories")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/categories') }}" 
                            >
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "brands")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/brands') }}" 
                            >
                                Brands
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "products")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/products') }}" 
                            >
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "coupons")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/coupons') }}" 
                            >
                                Coupons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "filters" || Session::get('page') == "filters_values")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/filters') }}" 
                            >
                                Filters
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "orders")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-orders" 
                    aria-expanded="false" 
                    aria-controls="ui-orders">
                <i class="mdi mdi-cash-multiple menu-icon"></i>
                <span class="menu-title">Orders<br> Management</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-orders">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #0e0c9b !important;">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "orders")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/orders') }}" 
                            >
                                Orders
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "users" || Session::get('page') == "subscribers")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-users" 
                    aria-expanded="false" 
                    aria-controls="ui-users">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Users<br> Management</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-users">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #0e0c9b !important;">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "users")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif 
                                href="{{ url('admin/users') }}" 
                            >
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                id="sec"
                                href="{{ url('admin/subscribers') }}" 
                                @if (Session::get('page') == "subscribers")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif
                            >
                                Subscribers
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a 
                    class="nav-link @if(Session::get('page') == "banners" || Session::get('page') == "add_edit_banner")
                        activeNavItem
                    @endif" 
                    data-toggle="collapse" 
                    href="#ui-banners" 
                    aria-expanded="false" 
                    aria-controls="ui-banners"
                >
                    <i class="mdi mdi-image-filter menu-icon"></i>
                    <span class="menu-title">Banners<br> Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-banners">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #0e0c9b !important;">
                        <li class="nav-item">
                            <a 
                                id="sec"
                                @if (Session::get('page') == "banners" || Session::get('page') == "add_edit_banner")
                                    class="nav-link activeNavItem"
                                @else
                                    class="nav-link notActiveNavItem"
                                @endif  
                                href="{{ url('admin/banners') }}"
                            >
                                Banners
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
            <i class="icon-columns menu-icon"></i>
            <span class="menu-title">Form elements</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
            <i class="icon-bar-graph menu-icon"></i>
            <span class="menu-title">Charts</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
            <i class="icon-grid-2 menu-icon"></i>
            <span class="menu-title">Tables</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
            <i class="icon-contract menu-icon"></i>
            <span class="menu-title">Icons</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="icon-head menu-icon"></i>
            <span class="menu-title">User Pages</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
            <i class="icon-ban menu-icon"></i>
            <span class="menu-title">Error pages</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Documentation</span>
            </a>
        </li>
    </ul>
</nav>
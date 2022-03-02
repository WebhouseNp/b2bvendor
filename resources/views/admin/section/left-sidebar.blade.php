@php
$user = auth()->user();
@endphp
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{asset('/assets/admin/images/admin-avatar.png')}}" width="45px" />
            </div>
            <div class="admin-info align-self-center">
                <div class="font-strong">{{ is_alternative_login() ? alt_usr()->name : Auth::user()->name }}</div>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('dashboard')}}"><i class="sidebar-item-icon fa fa-tachometer"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li class="heading">Store</li>

            @if(auth()->user()->hasRole('vendor'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user-circle"></i>
                    <span class="nav-label"> Profile</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    @if(!is_alternative_login())
                    <li>
                        <a href="{{route('editVendorProfile',$user->id)}}">
                            <span class="fa fa-edit"></span>
                            Edit Profile
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{route('vendor.profile')}}">
                            <span class="fa fa-eye"></span>
                            View Profile
                        </a>
                    </li>
                </ul>
            </li>

            @can('accessChat')
            <li>
                <a href="/chat" target="_blank"><i class="sidebar-item-icon fa fa-comments"></i>
                    <span class="nav-label">Chat</span>
                </a>
            </li>
            @endcan
            @endif
            @can('manageDeals')
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-handshake-o"></i>
                    <span class="nav-label">Deals</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    @if(auth()->user()->hasRole('vendor'))
                    <li>
                        <a href="{{route('deals.create')}}">
                            <span class="fa fa-plus"></span>
                            Create New Deal
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->hasAnyRole('admin|super_admin|vendor'))
                    <li>
                        <a href="{{route('deals.index')}}">
                            <span class="fa fa-eye"></span>
                            All Deals
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endcan

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user-circle"></i>
                    <span class="nav-label">Vendor Management</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('vendor.getApprovedVendors')}}">
                            <span class="fa fa-eye"></span>
                            Approved Vendors
                        </a>
                    </li>

                    <li>
                        <a href="{{route('vendor.getNewVendors')}}">
                            <span class="fa fa-eye"></span>
                            Vendor Request
                        </a>
                    </li>

                    <li>
                        <a href="{{route('vendor.getSuspendedVendors')}}">
                            <span class="fa fa-eye"></span>
                            Suspended Vendors
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="{{route('allquotations')}}">
                    <i class="sidebar-item-icon fa fa-quote-left"></i>
                    <span class="nav-label">All Quotations</span>
                </a>
            </li>
            @endif

            @can('viewSalesReport')
            <li>
                <a href="{{route('salesReport')}}">
                    <i class="sidebar-item-icon fa fa-bar-chart"></i>
                    <span class="nav-label">Sales Report</span>
                </a>
            </li>
            @endcan

            @can('manageOrders')
            <li>
                <a href="{{ route('orders.index') }}">
                    <i class="sidebar-item-icon fa fa-first-order"></i>
                    <span class="nav-label">Orders</span>
                </a>
            </li>
            @endcan

            @if(auth()->user()->hasRole('vendor'))
            @can('viewTransactions')
            <li>
                <a href="/transactions/{{ auth()->id() }}">
                    <i class="sidebar-item-icon fa fa-credit-card "></i>
                    <span class="nav-label">Transactions</span>
                </a>
            </li>
            @endcan
            @endif

            @can('manageProducts')
            <li>
                @if( auth()->user()->hasRole('vendor'))
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-product-hunt"></i>
                    <span class="nav-label">Product</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                @endif
                @if( auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="{{route('product.index')}}">
                    <i class="sidebar-item-icon fa fa-product-hunt "></i>
                    <span class="nav-label">Products</span>
                </a>
            </li>
            @endif
            @if( auth()->user()->hasRole('vendor'))
            <ul class="nav-2-level collapse">
                <li>
                    <a href="{{route('product.create')}}">
                        <span class="fa fa-plus"></span>
                        Add Product
                    </a>
                </li>
                <li>
                    <a href="{{route('product.index')}}">
                        <span class="fa fa-circle-o"></span>
                        All Products
                    </a>
                </li>
            </ul>
            @endif
            </li>
            @endcan

            <li class="heading">Categories</li>

            @can('manageCategories')
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-list-alt"></i>
                    <span class="nav-label">Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('category.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Category
                        </a>
                    </li>

                    <li>
                        <a href="{{route('category.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Category
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-sort-amount-desc"></i>
                    <span class="nav-label">Sub Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('subcategory.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Subcategory
                        </a>
                    </li>

                    <li>
                        <a href="{{route('subcategory.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All SubCategories
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-cube"></i>
                    <span class="nav-label">Product Categories</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('product-category.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New
                        </a>
                    </li>

                    <li>
                        <a href="{{route('product-category.index')}}">
                            <span class="fa fa-circle-o"></span>
                            List All
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="heading">CMS</li>

            @if(auth()->user()->hasAnyRole(['vendor']))
            <li>
                <a href="{{ route('getShippingInfo') }}">
                    <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                    <span class="nav-label">Shipping Info</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('admin|super_admin'))
            <li>
                <a href="{{route('review.index')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Reviews</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-flag"></i>
                    <span class="nav-label">Country</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('country.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Country
                        </a>
                    </li>

                    <li>
                        <a href="{{route('country.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Countries Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-flag"></i>
                    <span class="nav-label">Blogs</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('blog.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Blog
                        </a>
                    </li>

                    <li>
                        <a href="{{route('blog.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Blogs
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-flag"></i>
                    <span class="nav-label">FAQ</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('faq.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New FAQ
                        </a>
                    </li>

                    <li>
                        <a href="{{route('faq.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All FAQS
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-address-card"></i>
                    <span class="nav-label">Partner</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('partner-type.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Partner Type
                        </a>
                    </li>

                    <li>
                        <a href="{{route('partner-type.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Partner Types Lists
                        </a>
                    </li>
                    <li>
                        <a href="{{route('partner.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New Partner
                        </a>
                    </li>

                    <li>
                        <a href="{{route('partner.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Partners Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="{{route('subscriber.index')}}">
                    <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                    <span class="nav-label">Subscribers</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-file"></i>
                    <span class="nav-label">Sliders</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">

                    <li>
                        <a href="{{route('slider.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Slider
                        </a>
                    </li>

                    <li>
                        <a href="{{route('slider.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Slider
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user"></i>
                    <span class="nav-label">All Users</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('user.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All User Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('admin|super_admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-tasks"></i>
                    <span class="nav-label">Roles</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <!-- <li>
                        <a href="{{route('role.create')}}">
                            <span class="fa fa-plus"></span>
                            Add Role
                        </a>
                    </li> -->
                    <li>
                        <a href="{{route('role.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Roles
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['vendor']) && !is_alternative_login())
            <li>
                <a href="{{ route('alternative-users.index') }}">
                    <i class="sidebar-item-icon fa fa-users"></i>
                    <span class="nav-label">Users</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('admin|super_admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-adn"></i>
                    <span class="nav-label">Advertise</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('advertisement.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="{{route('advertisement.index')}}">
                            <span class="fa fa-circle-o"></span>
                            All Lists
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-adn"></i>
                    <span class="nav-label">Settings</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{ route('settings.sastowholesale-mall.index') }}">
                            <span class="fa fa-circle-o"></span>
                            Sasto Wholesale Mall
                        </a>
                    </li>
                    @if(auth()->user()->hasAnyRole('super_admin'))
                    <li>
                        <a href="{{ route('settings.notification.index') }}">
                            <span class="fa fa-circle-o"></span>
                            <span>Test Notifications</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

        </ul>
    </div>
</nav>

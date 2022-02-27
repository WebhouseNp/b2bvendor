@php
$user = Auth::user();
$roles = [];
foreach($user->roles as $role){
$slug = $role->slug;
array_push($roles,$slug);
}
$user_access = json_decode($user->access_level);
@endphp


<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{asset('/assets/admin/images/admin-avatar.png')}}" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong">{{ is_alternative_login() ? alt_usr()->name : Auth::user()->name }}</div>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('dashboard')}}"><i class="sidebar-item-icon fa fa-tachometer"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">Menu</li>

            @if(in_array('vendor' ,$roles))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-user-circle"></i>
                    <span class="nav-label"> Profile</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('editVendorProfile',$user->id)}}">
                            <span class="fa fa-edit"></span>
                            Edit Profile
                        </a>
                    </li>
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
            @if(in_array('vendor' ,$roles) || in_array('admin' ,$roles) || in_array('super_admin' ,$roles))
            <li>
                <a href="javascript:;">
                    <i class="sidebar-item-icon fa fa-handshake-o"></i>
                    <span class="nav-label">Deals</span>
                    <i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    @if(in_array('vendor' ,$roles))
                    <li>
                        <a href="{{route('deals.create')}}">
                            <span class="fa fa-plus"></span>
                            Create New Deal
                        </a>
                    </li>
                    @endif
                    @if(in_array('vendor' ,$roles) || in_array('admin' ,$roles) || in_array('super_admin' ,$roles))
                    <li>
                        <a href="{{route('deals.index')}}">
                            <span class="fa fa-eye"></span>
                            All Deals
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(in_array('super_admin' ,$roles))
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
            @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles) && in_array('quotation', $user_access)))
            <li>
                <a href="{{route('allquotations')}}">
                    <i class="sidebar-item-icon fa fa-quote-left"></i>
                    <span class="nav-label">All Quotations</span>
                </a>
            </li>
            @endif

            @can('manageOrders')
            <li>
                <a href="{{ route('orders.index') }}">
                    <i class="sidebar-item-icon fa fa-first-order"></i>
                    <span class="nav-label">Orders</span>
                </a>
            </li>
            @endcan

            <li>
                <a href="{{ route('salesReport') }}">
                    <i class="sidebar-item-icon fa fa-bar-chart "></i>
                    <span class="nav-label">Sales Report</span>
                    {{-- <i class="fa fa-angle-left arrow"></i> --}}
                </a>
                {{-- <ul class="nav-2-level collapse">
                @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles) || (in_array('vendor' , $roles))))
                    <li>
                        <a href="{{route('salesReport')}}">
                <span class="fa fa-circle-o"></span>
                All Sales Reports
                </a>
            </li>
            @endif
            <!-- @if( in_array('vendor' ,$roles)) -->
            <!-- <li>
                        <a href="{{route('getVendorPaymentReport')}}">
                            <span class="fa fa-circle-o"></span>
                            Payment Report
                        </a>
                    </li> -->
            <!-- @endif -->
        </ul> --}}
        </li>

        {{-- @if (auth()->user()->hasRole('vendor')) --}}
        @can('viewTransactions')
        <li>
            <a href="/transactions/{{ auth()->id() }}">
                <i class="sidebar-item-icon fa fa-credit-card "></i>
                <span class="nav-label">Transactions</span>
                <i class="fa fa-angle-left arrow"></i>
            </a>
        </li>
        @endcan
        {{-- @endif --}}

        @can('manageProducts')
        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon fa fa-product-hunt"></i>
                <span class="nav-label">Product</span>
                <i class="fa fa-angle-left arrow"></i>
            </a>
            <ul class="nav-2-level collapse">
                @if(in_array('super_admin' ,$roles) || in_array('vendor' ,$roles) || (in_array('admin' ,$roles) && in_array('product', $user_access)))
                <li>
                    <a href="{{route('product.create')}}">
                        <span class="fa fa-plus"></span>
                        Add Product
                    </a>
                </li>
                @endif
                @if(in_array('super_admin' ,$roles) || in_array('vendor' ,$roles) || (in_array('admin' ,$roles) && in_array('product', $user_access)))
                <li>
                    <a href="{{route('product.index',['type'=>'all'])}}">
                        <span class="fa fa-circle-o"></span>
                        All Products
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endcan

        @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles) && in_array('roles', $user_access)))
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

        @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles) && in_array('slider', $user_access)))
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

        @if(auth()->user()->hasAnyrole('super_admin|admin|vendor'))
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
        @endif

        @if(auth()->user()->hasAnyrole('super_admin|admin|vendor'))
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
        @endif

        @if(auth()->user()->hasAnyrole('super_admin|admin|vendor'))
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
        @endif

        @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles) && in_array('advertisement', $user_access)))
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

        @if(in_array('super_admin' ,$roles) || (in_array('admin' ,$roles)))
        <li>
            <a href="{{route('review.index')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                <span class="nav-label">Reviews</span>
                <i class="fa fa-angle-left arrow"></i>
            </a>
        </li>
        @endif

        @if(in_array('super_admin' ,$roles))
        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon fa fa-user"></i>
                <span class="nav-label">All Users</span>
                <i class="fa fa-angle-left arrow"></i>
            </a>
            <ul class="nav-2-level collapse">

                <!-- <li>
                        <a href="{{route('user.create')}}">
                            <span class="fa fa-plus"></span>
                            Add New
                        </a>
                    </li> -->

                <li>
                    <a href="{{route('user.index')}}">
                        <span class="fa fa-circle-o"></span>
                        All User Lists
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(in_array('super_admin' ,$roles))
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

        @if(in_array('super_admin' ,$roles))
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

        @if(in_array('super_admin' ,$roles))
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

        @if(in_array('super_admin' ,$roles))
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

        @if(in_array('super_admin' ,$roles))
        <li>
            <a href="{{route('subscriber.index')}}">
                <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                <span class="nav-label">Subscribers</span>
                <i class="fa fa-angle-left arrow"></i>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasAnyRole(['super_admin', 'admin']))
        <li>
            <a href="{{ route('settings.sastowholesale-mall.index') }}">
                <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                <span class="nav-label">Sasto Wholesale Mall</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasAnyRole(['vendor']))
        <li>
            <a href="{{ route('alternative-users.index') }}">
                <i class="sidebar-item-icon fa fa-thumbs-up"></i>
                <span class="nav-label">Alternative Users</span>
            </a>
        </li>
        @endif
        </ul>
    </div>
</nav>
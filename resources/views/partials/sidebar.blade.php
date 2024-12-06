<aside class="left-sidebar">
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('user.dashboard') }}" class="text-nowrap logo-img">
            <img width="152px" src="{{ asset('assets/images/logos/logo.png') }}" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    @if (auth()->check())
    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
        <ul id="sidebarnav">
            <!-- Link Dashboard -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('user.dashboard') }}" aria-expanded="false">
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Admin Specified Dashboard-->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                <iconify-icon icon="ri:admin-fill"></iconify-icon>
                    <span class="hide-menu">Admin Dashboard</span>
                </a>
            </li>
            @endif

            <!-- Link Profile -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('profile') }}" aria-expanded="false">
                <iconify-icon icon="mdi:account"></iconify-icon>
                    <span class="hide-menu">Your Profile</span>
                </a>
            </li>
            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Profile Manager-->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.profile_manager') }}" aria-expanded="false">
                <iconify-icon icon="mdi:account-cog"></iconify-icon>
                    <span class="hide-menu">Profile Manager</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Bank Accounts -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('bank_accounts.index') }}" aria-expanded="false">
                    <iconify-icon icon="solar:file-text-line-duotone"></iconify-icon>
                    <span class="hide-menu">Bank Accounts</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'vendor')
            <!-- Link Bank Accounts -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('vendor.groups.index') }}" aria-expanded="false">
                    <iconify-icon icon="eos-icons:products-outlined"></iconify-icon>
                    <span class="hide-menu">Make Product Group</span>
                </a>
            </li>
            @endif
            
            @if (auth()->check() && auth()->user()->role === 'vendor')
            <!-- Link My Services -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('vendor.services.index') }}" aria-expanded="false">
                <iconify-icon icon="hugeicons:new-job"></iconify-icon>
                    <span class="hide-menu">My Services</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Vendor's Services -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.services.index') }}" aria-expanded="false">
                <iconify-icon icon="hugeicons:new-job"></iconify-icon>
                    <span class="hide-menu">Manage Vendor Service</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Discounts -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.discounts.index') }}" aria-expanded="false">
                <iconify-icon icon="ic:outline-discount"></iconify-icon>
                    <span class="hide-menu">Manage Discount</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.purchases.index') }}" aria-expanded="false">
                <iconify-icon icon="mdi:invoice-text-edit-outline"></iconify-icon>
                    <span class="hide-menu">Manage Invoices</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'user')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('affiliate.request.create') }}" aria-expanded="false">
                <iconify-icon icon="fluent-mdl2:team-favorite"></iconify-icon>
                    <span class="hide-menu">Request Affiliate</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'affiliator')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('affiliate.purchases.index') }}" aria-expanded="false">
                <iconify-icon icon="tabler:affiliate" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">See Affiliated Purchases</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'affiliator')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('affiliate.services.index') }}" aria-expanded="false">
                <iconify-icon icon="fluent-mdl2:product-variant" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">See Affiliated Services</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'affiliator')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('affiliate.balance') }}" aria-expanded="false">
                <iconify-icon icon="mdi:gift-outline" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">See Your Rewards</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'installer')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('installer.balance') }}" aria-expanded="false">
                <iconify-icon icon="mdi:gift-outline" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">See Your Balance</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'vendor')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('vendor.balance') }}" aria-expanded="false">
                <iconify-icon icon="mdi:gift-outline" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">See Your Balance</span>
                </a>
            </li>
            @endif

            @if (auth()->check())
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('withdraw.index') }}" aria-expanded="false">
                <iconify-icon icon="uil:money-withdraw" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Request Withdrawal</span>
                </a>
            </li>
            @endif
            

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.withdraws.index') }}" aria-expanded="false">
                <iconify-icon icon="solar:hand-money-broken" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Withdrawal Requests</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.affiliate.requests.index') }}" aria-expanded="false">
                <iconify-icon icon="fluent-mdl2:team-favorite"></iconify-icon>
                    <span class="hide-menu">Manage Request Affiliate</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.project_requests.index') }}" aria-expanded="false">
                <iconify-icon icon="ix:project" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Manage Request Project</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.projects.index') }}" aria-expanded="false">
                <iconify-icon icon="ph:cube-focus" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Manage Projects</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'installer')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('project.requests.index') }}" aria-expanded="false">
                <iconify-icon icon="ix:project" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Find a Project</span>
                </a>
            </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'installer')
            <!-- Link Invoices -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('project.progress.index') }}" aria-expanded="false">
                <iconify-icon icon="line-md:document-report" width="24" height="24"></iconify-icon>
                    <span class="hide-menu">Project Progress</span>
                </a>
            </li>
            @endif

            <!-- Link Purchases -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('user.invoices.index') }}" aria-expanded="false">
                <iconify-icon icon="tdesign:shop"></iconify-icon>
                    <span class="hide-menu">My Purchases</span>
                </a>
            </li>
            
        </ul>
    </nav>
    @endif
</aside>

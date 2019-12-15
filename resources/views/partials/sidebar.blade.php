@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<div class="app-sidebar sidebar-shadow bg-focus sidebar-text-light">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                        data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">
                    <p class="text-center">
                        <i class="fas fa-user-astronaut fa-4x"></i>
                    </p>
                    <p class="text-center">{{Auth::user()->name}} ({{ App\User::getRole() }})</p>
                    <hr>
                </li>
                <li>
                    <a href="{{ url('/') }}" class="{{ $request->segment(2) == 'home' ? 'mm-active' : '' }}">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        @lang('quickadmin.qa_dashboard')
                    </a>
                </li>
                @can('user_management_access')
                    <li>
                        <a href="#" class="{{ $request->segment(2) == 'roles' || $request->segment(2) == 'users' ? 'mm-active' : '' }}" aria-expanded="{{ $request->segment(2) == 'roles' || $request->segment(2) == 'users' ? 'true' : 'false' }}">
                            <i class="metismenu-icon pe-7s-users"></i>
                            @lang('quickadmin.user-management.title')
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            @can('role_access')
                                <li>
                                    <a class="{{ $request->segment(2) == 'roles' ? 'mm-active' : '' }}" href="{{ route('admin.roles.index') }}">
                                        <i class="metismenu-icon"></i>
                                        @lang('quickadmin.roles.title')
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li>
                                    <a class="{{ $request->segment(2) == 'users' ? 'mm-active' : '' }}" href="{{ route('admin.users.index') }}">
                                        <i class="metismenu-icon"></i>
                                        @lang('quickadmin.users.title')
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('expense_management_access')
                    <li>
                        <a href="#" class="{{ in_array($request->segment(2), ['expense_categories', 'income_categories', 'incomes', 'expenses', 'monthly_reports', 'currencies']) ? 'mm-active' : '' }}">
                            <i class="metismenu-icon pe-7s-cash"></i>
                            @lang('quickadmin.expense-management.title')
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            @can('expense_category_access')
                                <li>
                                    <a class="{{ $request->segment(2) == 'expense_categories' ? 'mm-active' : '' }}" href="{{ route('admin.expense_categories.index') }}">
                                        <i class="metismenu-icon"></i>
                                        @lang('quickadmin.expense-category.title')
                                    </a>
                                </li>
                            @endcan
                            @can('expense_access')
                                <li>
                                    <a class="{{ $request->segment(2) == 'expenses' ? 'mm-active' : '' }}" href="{{ route('admin.expenses.index') }}">
                                        <i class="metismenu-icon"></i>
                                        @lang('quickadmin.expense.title')
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>

@php
    $user = auth()->user();
@endphp
<div class="dashboard-header mb-30">
    <div class="dashboard-header__items d-flex justify-content-between align-items-center flex-wrap">
        <div class="dashboard-menu">
            <ul class=" dashboard-menu__items d-flex flex-wrap">
                <li><a href="{{ route('user.home') }}"></span>@lang('Dashboard')</a></li>
                <li><a href="survey-list.html">@lang('Survey List')</a></li>
                <li><a href="survey-activity.html">@lang('Survey Activity')</a></li>
                <li><a href="pricing.html">Pricing</a></li>
                <li><a href="subscription.html">Subscription</a></li>
                <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw')</a></li>
                <li><a href="{{ route('user.deposit') }}">@lang('Deposit')</a></li>
                <li><a href="{{ route('user.deposit.history') }}">@lang('Payment History')</a></li>
                <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                <li><a href="{{ route('ticket') }}">@lang('Support Tickets')</a></li>
            </ul>
        </div>
        <div class="profile-info d-flex gap--20">
            <div class="dropdown">
                <button class="notification-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <ul class="dropdown-menu p-2 notification__drop">
                    <li>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="fs-14 text--black fw--600">@lang('Notifications')</p>
                            <p class="fs-12 badge badge--base custom-badge">12 unread</p>
                        </div>
                    </li>
                    <li><a class="dropdown-item notification" href="#">
                            <p class="notification-title fs--14">Lorem ipsum, dolor sit...</p>
                            <p class="notification-time fs-12">26 minutes ago</p>
                        </a></li>
                    <li><a class="dropdown-item notification" href="#">
                            <p class="notification-title fs--14">Lorem ipsum, dolor sit...</p>
                            <p class="notification-time fs-12">26 minutes ago</p>
                        </a></li>
                    <li><a class="dropdown-item notification" href="#">
                            <p class="notification-title fs--14">Lorem ipsum, dolor sit...</p>
                            <p class="notification-time fs-12">26 minutes ago</p>
                        </a></li>
                    <li><a class="dropdown-item notification" href="#">
                            <p class="notification-title fs--14">Lorem ipsum, dolor sit...</p>
                            <p class="notification-time fs-12">26 minutes ago</p>
                        </a></li>
                    <li><a href="#" class="btn view-all btn--base w-100">View all</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="dropdown-toggle d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="profile__dropdown">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                            alt="@lang('image')">
                        <span class="profile-title">{{ $user->fullname ?? '' }}</span>
                    </span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

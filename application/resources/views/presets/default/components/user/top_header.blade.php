@php
    $user = auth()->user();
    $userNotifications = \App\Models\UserNotification::where('user_id', $user->id)->orderBy('id', 'desc')->get();
    $userNotificationUnreadCount = \App\Models\UserNotification::where('user_id', $user->id)
        ->where('read_status', 1)
        ->count();
@endphp

<div class="dashboard-header mb-30">
    <div class="dashboard-header__items ">
        <div class="dashboard-menu order-1 order-xxl-0">
            <ul class=" dashboard-menu__items d-flex flex-wrap">
                <li><a href="{{ route('user.home') }}"
                        class="{{ Route::is('user.home') ? 'active' : '' }}"></span>@lang('Dashboard')</a></li>
                <li><a href="{{ route('user.survey.all.survey') }}"
                        class="{{ Route::is('user.survey.all.survey') || Route::is('user.survey.details') ? 'active' : '' }} ? 'active' : '' }}">@lang('All Survey')</a></li>
                <li><a href="{{ route('user.survey.index') }}"
                        class="{{ Route::is('user.survey.index') ? 'active' : '' }}">@lang('Survey List')</a></li>
                <li><a href="{{ route('user.survey.submission') }}"
                        class="{{ Route::is('user.survey.submission') ? 'active' : '' }}">@lang('Survey Submission')</a></li>
                <li><a href="{{ route('user.withdraw.history') }}"
                        class="{{ Route::is('user.withdraw.history') ? 'active' : '' }}">@lang('Withdrawals')</a></li>
                <li><a href="{{ route('user.deposit.history') }}"
                        class="{{ Route::is('user.deposit.history') || Route::is('user.deposit') ? 'active' : '' }}">@lang('Payment History')</a></li>
                <li><a href="{{ route('user.transactions') }}"
                        class="{{ Route::is('user.transactions') ? 'active' : '' }}">@lang('Transactions')</a></li>
                <li><a href="{{ route('ticket') }}"
                        class="{{ Route::is('ticket') ? 'active' : '' }}">@lang('Support Tickets')</a></li>
                <li><a href="{{ route('user.credit.purchase') }}"
                        class="{{ Route::is('user.credit.purchase') ? 'active' : '' }}">@lang('Credit Purchase')</a></li>
            </ul>
        </div>
        <div class="profile-info d-flex gap--20">
            <div class="dropdown">
                <button class="notification-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($userNotificationUnreadCount)
                         <div class="blob white notification-dot"></div>
                    @endif
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="dropdown-menu p-2 notification__drop">
                    <ul class="dropdown-menu__inner">
                        <li>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fs-14 text--black fw--600">@lang('Notifications')</p>
                                <p class="fs-12 badge badge--base custom-badge">{{ $userNotificationUnreadCount }}
                                    @lang('unread')</p>
                            </div>
                        </li>
                        @foreach ($userNotifications ?? [] as $item)
                            <li>
                                <a class="dropdown-item notification {{$item->read_status ? 'un-read' :''}}"
                                    href="{{ route('user.read.notification', $item->id) }}">
                                    <p class="notification-title fs--14">{{ __(strLimit($item->title, 30)) }}</p>
                                    <p class="notification-time fs-12">{{ diffForHumans($item->created_at) }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div><a href="{{ route('user.notification.all') }}"
                            class="btn view-all btn--base w-100">@lang('View all')</a></div>
                </div>

            </div>
            <div class="dropdown">
                <button class="dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
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

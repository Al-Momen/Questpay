@php
    $languages = App\Models\Language::all();
    $socialIcons = getContent('social_icon.element', false);
    $currentLang = $languages->firstWhere('code', session('lang', 'en'));
    $pages = App\Models\Menu::with(['items', 'menuItems'])
        ->where('code', 'header_menu')
        ->first();
@endphp


<!-- ==================== Scroll to Top Start ==================== -->
<a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
<!-- ==================== Scroll to Top End ==================== -->

<!--==========================  Overlay Start  ==========================-->
<div class="overlay"></div>
<!--==========================  Overlay End  ==========================-->

<!--==========================  Offcanvas Section Start  ==========================-->
<div class="offcanvas__area">
    <div class="offcanvas__topbar">
        <a href="{{ route('home') }}">
            <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}" alt="@lang('logo')">
        </a>
        <span class="menu__close"><i class="las la-times"></i></span>
    </div>
    <div class="offcanvas__main">
        <div class="offcanvas__widgets">
            <div class="offcanvas__language">
                <div class="dropdown">
                    <div role="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="language__item">
                            <img src="{{ getImage(getFilePath('language') . '/' . $currentLang->image ?? '', getFileSize('language')) }}"
                                alt="@lang('image')">
                            <p>{{ ucfirst($currentLang->name) }}</p>
                        </div>
                    </div>
                    <ul class="dropdown-menu">
                        @foreach ($languages as $language)
                            <li>
                                <div class="language__item dropdown-item lang-change">
                                    <img src="{{ getImage(getFilePath('language') . '/' . $language->image ?? '', getFileSize('language')) }}"
                                        alt="@lang('flag-image')">
                                    <p>{{ ucfirst($language->name) }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="offcanvas__login">
                @auth
                    <a href="{{ route('user.home') }}" class="btn btn--base sign-in--btn">@lang('Dashboard')</a>
                    <a href="{{ route('user.logout') }}" class="btn btn--base sign-in--btn">@lang('Logout')</a>
                @endauth
                @guest
                    <a href="{{ route('user.login') }}" class="btn btn--base sign-in--btn">@lang('Sign in')</a>
                @endguest
            </div>
        </div>
        <div class="offcanvas__menu">
            <ul>
                @foreach ($pages->items as $k => $data)
                    @if ($data->link_type == 2)
                        <li>
                            <a href="{{ $data->url ?? '' }}" target="_blank">{{ __($data->title) }}</a>
                        </li>
                    @else
                        <li class="{{ route('pages', [$data->url]) == url()->current() ? 'active' : null }}">
                            <a href="{{ route('pages', [$data->url]) }}"
                                class="{{ Request::url() == url($data->url) ? 'active' : '' }}">{{ __($data->title) }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!--==========================  Offcanvas Section End  ==========================-->


<!-- ==================== Header Start Here ==================== -->
<header class="header__area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header__main">
                    <div class="header__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                                alt="@lang('logo')">
                        </a>
                    </div>
                    <div class="header__menu">
                        <ul>
                            @foreach ($pages->items as $k => $data)
                                @if ($data->link_type == 2)
                                    <li>
                                        <a href="{{ $data->url ?? '' }}" target="_blank">{{ __($data->title) }}</a>
                                    </li>
                                @else
                                    <li
                                        class="{{ route('pages', [$data->url]) == url()->current() ? 'active' : null }}">
                                        <a href="{{ route('pages', [$data->url]) }}"
                                            class="{{ Request::url() == url($data->url) ? 'active' : '' }}">{{ __($data->title) }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="header__widgets">
                        <div class="dropdown">
                            <div role="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="language__item">
                                    <img src="{{ getImage(getFilePath('language') . '/' . $currentLang->image ?? '', getFileSize('language')) }}"
                                        alt="@lang('image')">
                                    <p>{{ ucfirst($currentLang->name) }}</p>
                                </div>
                            </div>
                            <ul class="dropdown-menu">
                                @foreach ($languages as $language)
                                    <li>
                                        <div class="language__item dropdown-item lang-change">
                                            <img src="{{ getImage(getFilePath('language') . '/' . $language->image ?? '', getFileSize('language')) }}"
                                                alt="@lang('flag-image')">
                                            <p>{{ ucfirst($language->name) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="header__login">
                            @auth
                                <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                <a href="{{ route('user.logout') }}">@lang('Logout')</a>
                            @endauth
                            @guest
                                <a href="{{ route('user.login') }}">@lang('Sign in')</a>
                            @endguest
                        </div>
                    </div>
                    <span class="menu__open"><i class="fa-solid fa-bars"></i></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ==================== Header End Here ==================== -->

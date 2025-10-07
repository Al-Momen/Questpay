@php
    $contactSection = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $companyLinks = App\Models\Menu::with(['items', 'menuItems'])
        ->where('code', 'company_link')
        ->first();
    $quickLinks = App\Models\Menu::with(['items', 'menuItems'])
        ->where('code', 'quick_link')
        ->first();
    $policyLinks = getContent('policy_pages.element', false, null, true);
    $subscriptionSectionContent = getContent('subscribe.content', true);
@endphp

<!--================================= footer section start =================================-->
<footer class="footer mt-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="footer-items">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                            alt="@lang('logo')"></a>
                    <p class="footer-desc">{{ __($contactSection->data_values->short_details) }}</p>
                    <ul class="social-list mb-4 z--9 position-relative social__icon">
                        @foreach ($socialIcons as $item)
                            <li>
                                <a href="{{ $item->data_values->url }}" class="social-list__link icon-wrapper">
                                    @php echo $item->data_values->social_icon; @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="footer-menu">
                    <h4 class="footer-menu__title">@lang('Company links')</h4>
                    <div class="footer-menu__items">
                        <ul>
                            @foreach ($companyLinks->items as $k => $data)
                                @if ($data->link_type == 2)
                                    <li>
                                        <a href="{{ $data->url ?? '' }}" target="_blank">{{ __($data->title) }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('pages', [$data->url]) }}"
                                            class="footer-menu__links {{ Request::url() == url($data->url) ? 'active' : '' }}">
                                            <span class="text--base me-2">
                                                <i class="fa-solid fa-angle-right"></i>
                                            </span>
                                            {{ __(ucfirst(strtolower($data->title)) ?? '') }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="footer-menu">
                    <h4 class="footer-menu__title">@lang('Quick Links')</h4>
                    <div class="footer-menu__items">
                        <ul>
                            @foreach ($quickLinks->items as $k => $data)
                                @if ($data->link_type == 2)
                                    <li>
                                        <a href="{{ $data->url ?? '' }}" target="_blank">{{ __($data->title) }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('pages', [$data->url]) }}"
                                            class="footer-menu__links {{ Request::url() == url($data->url) ? 'active' : '' }}">
                                            <span class="text--base me-2">
                                                <i class="fa-solid fa-angle-right"></i>
                                            </span>
                                            {{ __(ucfirst(strtolower($data->title ?? ''))) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            <li>
                                <a class="footer-menu__links" href="{{ url('/') . '/policy/terms-of-service/42' }}">
                                    @lang('Privacy Policy')
                                </a>
                            </li>
                            <li>
                                <a class="footer-menu__links" href="{{ url('/') . '/policy/terms-of-service/43' }}">
                                    @lang('Terms And Conditions')
                                </a>
                            </li>
                            <li>
                                <a class="footer-menu__links" href="{{ url('/') . '/cookie-policy' }}">
                                    @lang('Cookie Policy')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="footer-menu">
                    <h4 class="footer-menu__title">@lang('Newsletter')</h4>
                    <p class="footer-newslater__desc">{{ __($subscriptionSectionContent->data_values->heading) }}</p>
                    <div class="footer__newsletter position-relative">
                        <form action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <input type="email" name="email" class="form-control input-newsletter" placeholder="@lang('Your email please')">
                        <button class="text--base input-newsletter__button" type="submit">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="text-center fs--16 text--white mt-60">@php echo $contactSection->data_values->website_footer; @endphp</p>
        </div>
    </div>
</footer>
<!--================================= footer section ends =================================-->

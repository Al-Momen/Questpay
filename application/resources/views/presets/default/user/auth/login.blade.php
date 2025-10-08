@php
    $credentials = $general->socialite_credentials;
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- sign-up section start -->
    <div class="sign-in">
        <div class="sign-up d-flex">
            <div class="sign-up__thumb">
                <a class="index-logo" href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}" alt="@lang('logo')">
                </a>
                <div class="position-relative">
                    <img class="signup-new__shape signin-new__shape"
                        src="{{ getImage(getFilePath('shape') . 'signup-new-shape.png') }}" alt="@lang('signup-new-shape')">
                    <img class="signup-new__image" src="{{ getImage(getFilePath('shape') . 'sign--in.png') }}"
                        alt="@lang('signup-new')">
                </div>
            </div>
            <div class="sign-up__items">
                <div class="wrap mt-5">
                    <div class="section-heading">
                        <p class="section-heading__subtitle title-animation">@lang('Welcome back!')</p>
                        <h2 class="section-heading__title sign-up__title title-animation">@lang('Sign in your account')</h2>
                        <p class="section-heading__desc title-animation">@lang('It only takes a minute to start earning with surveys you’ll actually enjoy.')</p>
                    </div>
                </div>

                <div class="sign-up__forms">
                    <div class="sign-up__shape">
                        <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                    </div>
                    <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-12 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="usernameInput" name="username" value="{{ old('username') }}"
                                            placeholder="@lang('Enter your username')">
                                    <label for="usernameInput">@lang('Username')</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control custom-passwoard" id="passwordInput"
                                        name="password" placeholder="@lang('Enter your password')" type="password">
                                    <label for="passwordInput">@lang('Password')</label>
                                    <div class="password-show-hide">
                                        <i class="fa-solid fa-eye close-eye-icon"></i>
                                        <i class="fa-solid fa-eye-slash open-eye-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6 col-sm-6 recap">
                                <x-captcha></x-captcha>
                            </div>
                        </div>
                        <div class="form-check form--check d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap--12">
                                <input class="form-check-input" type="checkbox" value="" name="remember" id="remember" 
                                {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    @lang('Remember Me')
                                </label>
                            </div>
                            <a class="text--base fs--14 text--underline" href="{{ route('user.password.request') }}">
                                @lang('Forgot Password?')
                            </a>
                        </div>
                        <div class="form--check__btn">
                            <button class="hero-button btn btn--base w--100" type="submit"
                                id="recaptcha">@lang('Sign in')</button>
                        </div>
                    </form>
                    @if ($credentials->google->status == 1 || $credentials->facebook->status == 1)
                        <p class="or-btn text-center mb-3">@lang('OR')</p>
                        <ul class="justify-content-center z--9 position-relative social__icon sign-up__social">
                            @if ($credentials->google->status == 1)
                                <li>
                                    <a href="{{ route('user.social.login', 'google') }}"
                                        class="social-list__link icon-wrapper">
                                        <div class="icon"><i class="fa-brands fa-google"></i></div>
                                    </a>
                                </li>
                            @endif
                            @if ($credentials->facebook->status == 1)
                                <li>
                                    <a href="{{ route('user.social.login', 'facebook') }}"
                                        class="social-list__link icon-wrapper">
                                        <div class="icon"><i class="fa-brands fa-facebook-f"></i></div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                    <p class="sign-up__links mt-4">@lang('Don’t have an account? ')
                        <a class=" sign-in__text text--base text--underline" href="{{ route('user.register') }}">@lang('Sign up')</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <!-- sign-up section start -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            'use strict';
            $('.recap').each(function() {
                if ($(this).children().length === 0) {
                    console.log($(this).children().length);
                    $(this).addClass('d-none');
                } else {
                    $(this).removeClass('d-none');
                }
            });
        });
    </script>
@endpush

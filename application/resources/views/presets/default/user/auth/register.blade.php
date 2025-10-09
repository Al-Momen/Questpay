@php
    $credentials = $general->socialite_credentials;
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- sign-up section start -->
    <div class="sign-up">
        <div class="sign-up z--1 d-flex">
            <div class="sign-up__thumb">
                <a class="index-logo" href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                        alt="@lang('logo')"></a>
                <div class="position-relative">
                    <img class="signup-new__shape" src="{{ getImage(getFilePath('shape') . 'signup-new-shape.png') }}"
                        alt="@lang('signup-new-shape')">
                    <img class="signup-new__image" src="{{ getImage(getFilePath('shape') . 'signup-new.png') }}"
                        alt="@lang('signup-new')">
                </div>
            </div>
            <div class="sign-up__items">
                <div class="section-heading">
                    <p class="section-heading__subtitle title-animation">@lang('Create Your Account')</p>
                    <h2 class="section-heading__title sign-up__title title-animation">@lang('Join & Start Earning Today')</h2>
                    <p class="section-heading__desc title-animation">@lang('It only takes a minute to start earning with surveys you’ll actually enjoy.')</p>
                </div>
                <div class="sign-up__forms">
                    <div class="sign-up__shape">
                        <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('Shape Image')">
                    </div>
                    <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                        @csrf
                        <div class="row g-4">
                            <!-- Username -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control checkUser" name="username"
                                        value="{{ old('username') }}" id="usernameInput" placeholder="@lang('Username')">
                                    <label for="usernameInput">@lang('UserName')</label>
                                </div>
                                <p class="text--danger usernameExist"></p>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating ">
                                    <input type="email" class="form-control checkUser" id="emailInput"
                                        value="{{ old('email') }}" name="email" placeholder="@lang('Email Address')">
                                    <label for="emailInput">@lang('Email')</label>
                                </div>
                                <p class="text--danger mt-1 emailExist"></p>
                            </div>

                            <!-- Country -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select p-0 ps-3" name="country" required id="gateway">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->country }}" data-code="{{ $key }}">
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <div class="input-group with--text">
                                        <span class="input-group-text mobile-code border-0"></span>
                                        <input type="number" name="mobile" id="phoneInput" value=""
                                            class="form-control checkUser" required id="mobile"
                                            placeholder="@lang('Phone Number')">
                                    </div>

                                </div>
                                <p class="text--danger mobileExist"></p>
                            </div>

                            <!-- Password -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control custom-passwoard" id="passwordInput"
                                        placeholder="@lang('Password')" name="password" type="password" required>
                                    <label for="passwordInput">@lang('Password')</label>
                                    <div class="password-show-hide">
                                        <i class="fa-solid fa-eye close-eye-icon"></i>
                                        <i class="fa-solid fa-eye-slash open-eye-icon"></i>
                                    </div>
                                    @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower text--white">@lang('1 small letter minimum')</p>
                                            <p class="error capital text--white">@lang('1 capital letter minimum')</p>
                                            <p class="error number text--white">@lang('1 number minimum')</p>
                                            <p class="error special text--white">@lang('1 special character minimum')</p>
                                            <p class="error minimum text--white">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control custom-passwoard" id="confirmPasswordInput"
                                        placeholder="Confirm Password" name="password_confirmation" type="password">
                                    <label for="confirmPasswordInput">@lang('Confirm Password')</label>
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


                        @if ($general->agree)
                            <!-- Terms -->
                            <div class="form-check form--check">
                                <input class="form-check-input"type="checkbox" name="agree" @checked(old('agree'))
                                    id="checkDefault" required>
                                <label class="form-check-label" for="checkDefault">
                                    @lang('I agree with')
                                    @foreach ($policyPages as $policy)
                                        <a class="text--base"
                                            href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) ?? '' }}
                                        </a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </label>
                            </div>
                        @endif

                        <!-- Sign up button -->
                        <div class="form--check__btn">
                            <button class="hero-button btn btn--base w--100" id="recaptcha"
                                type="submit">@lang('Sign Up')</button>
                        </div>

                    </form>
                    <!-- Social login -->
                    @if ($credentials->google->status == 1 || $credentials->facebook->status == 1)
                        <p class="or-btn text-center mb-3">@lang('OR')</p>
                        <ul class="justify-content-center z--9 position-relative social__icon sign-up__social">
                            @if ($credentials->google->status == 1)
                                <li>
                                    <a href="{{ route('user.social.login', 'google') }}"
                                        class="social-list__link icon-wrapper">
                                        <div class="icon">
                                            <i class="fa-brands fa-google"></i>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($credentials->facebook->status == 1)
                                <li>
                                    <a href="{{ route('user.social.login', 'facebook') }}"
                                        class="social-list__link icon-wrapper">
                                        <div class="icon">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                    <!-- Redirect to Sign In -->
                    <p class="sign-up__links mt-4">@lang('You have any account?')
                        <a class="sign-in__text text--base text--underline"
                            href="{{ route('user.login') }}">@lang('Sign In')</a>
                            
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- sign-up section start -->


    {{-- =======-** Sign Up End **-======= --}}
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center my-4">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('user.login') }}" class="btn btn--base btn--md">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').on('focus'function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').on('focusout', function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;

                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    console.log(response.data, response.type);

                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);

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

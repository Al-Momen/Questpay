@php
    $contactSectionContent = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $user = auth()->user();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--==========================  Contact-top Section Start  ==========================-->
    <section class="contact-top-section mt-120">
        <div class="container">
            <div class="contact-main__items justify-content-between">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class=" contact-items text-center position-relative">
                            <div class="work-bg contact-bg">
                                <span>
                                    <img src="{{ getImage(getFilePath('contact') . 'phone.png') }}" alt="@lang('account-icon')">
                                </span>
                            </div>
                            <div class="contact">
                                <h3 class="contact-title fs--20 fw--600 m-0">@lang('Phone Number')</h3>
                                <a class="contact-desc fs--16 fw--400"
                                    href="tel:{{ $contactSectionContent->data_values?->contact_number ?? '' }}">
                                    {{ $contactSectionContent->data_values?->contact_number }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class=" contact-items text-center position-relative">
                            <div class="work-bg contact-bg">
                                <span>
                                    <img src="{{ getImage(getFilePath('contact') . 'email.png') }}" alt="@lang('account-image')">
                                </span>
                            </div>
                            <div class="contact">
                                <h3 class="contact-title fs--20 fw--600 m-0">@lang('Email Address')</h3>
                                <a class="contact-desc fs--16 fw--400"
                                    href="mailto:{{ $contactSectionContent->data_values?->email_address ?? '' }}">{{ $contactSectionContent->data_values?->email_address ?? '' }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class=" contact-items text-center position-relative">
                            <div class="work-bg contact-bg">
                                <span>
                                    <img src="{{ getImage(getFilePath('contact') . 'location.png') }}"
                                        alt="@lang('location-image')">
                                </span>
                            </div>
                            <div class="contact">
                                <h3 class="contact-title fs--20 fw--600 m-0">@lang('Address')</h3>
                                <p class="contact-desc fs--16 fw--400">
                                    {{ $contactSectionContent->data_values?->contact_details }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class=" contact-items text-center position-relative">
                            <div class="work-bg contact-bg">
                                <span>
                                    <img src="{{ getImage(getFilePath('contact') . 'support.png') }}"
                                        alt="@lang('support-image')">
                                </span>
                            </div>
                            <div class="contact">
                                <h3 class="contact-title fs--20 fw--600 m-0">
                                    @lang('Support Team')
                                </h3>
                                <a class="contact-desc fs--16 fw--400"
                                    href="tel:{{ $contactSectionContent->data_values?->support_number ?? '' }}">
                                    {{ $contactSectionContent->data_values?->support_number ?? '' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================  Contact-top Section End  ==========================-->
    <!--==========================  Contact-form Section Start  ==========================-->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-from pt-120">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="google-maps">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387196.07666627044!2d{{ $contactSectionContent->data_values?->longitude }}!3d{{ $contactSectionContent->data_values?->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1757239202181!5m2!1sen!2sbd"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-info">
                            <div class="section-heading">
                                <p class="section-heading__subtitle title-animation">
                                    {{ __($contactSectionContent->data_values?->top_heading) }}</p>
                                <h2 class="section-heading__title title-animation">
                                    {{ __($contactSectionContent->data_values?->heading) }}</h2>
                                <p class="section-heading__desc title-animation">
                                    {{ __($contactSectionContent->data_values?->short_description) }}</p>
                            </div>
                            <form method="post" action="#" class="verify-gcaptcha">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="userName" name="name"
                                                value="@if(auth()->user()){{ auth()->user()->fullname}}@else{{ old('name') }}@endif"
                                                @if (auth()->user()) readonly @endif required
                                                placeholder="@lang('Enter Full Name')">
                                            <label for="userName">@lang('Username')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="emailAddress"
                                                placeholder="@lang('Enter Email Address')" name="email"
                                                value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                                @if (auth()->user()) readonly @endif required>
                                            <label for="emailAddress">@lang('Email Address')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                placeholder="@lang('Subject')" value="{{ old('subject') }}"required>
                                            <label for="subject">@lang('Subject')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4">
                                            <textarea class="form-control text-area" name="message" placeholder="@lang('Enter your message here')..." id="message" required>{{ old('message') }}</textarea>
                                            <label for="message">@lang('Type Something')</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 recap">
                                        <x-captcha></x-captcha>
                                    </div>
                                    <div class="col-lg-12 m-0">
                                        <button
                                            class="btn btn--base contact-btn" id="recaptcha" >{{ __($contactSectionContent->data_values?->button_text) }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================  Contact-form Section End  ==========================-->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
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

@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <form class="register" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="profile-items">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="profile__left card p-4">
                                    <div class="profile__wr">
                                        <div class="profile__upload">
                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                                                    id="profileImage" alt="@lang('image')">
                                            <label for="profile__change">
                                                <i class="fa-solid fa-image"></i>
                                            </label>
                                            <input type="file" id="profile__change" name="image" class="upload_file">
                                        </div>
                                        <h4>{{ '@' . $user->username }}</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="profile__contact">
                                                <p><i class="fa-solid fa-envelope"></i>@lang('Email Address')</p>
                                                <a class="fw--600" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="profile__contact">
                                                <p><i class="fa-solid fa-phone"></i>@lang('Mobile Number')</p>
                                                <a class="fw--600" href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a>
                                            </div>
                                        </li>
                                        @if ($user->address)
                                            <li>
                                                <div class="profile__contact">
                                                    <p><i class="fa-solid fa-location-dot"></i>@lang('Address')</p>
                                                    <span>
                                                        @foreach (collect($user->address ?? [])->toArray() as $item)
                                                            {{ $item }}@if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="profile__wrap card p-4">
                                    <div class="row g-4">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="firstName"
                                                    placeholder="@lang('First Name')" name="firstname"
                                                    value="{{ $user->firstname }}">
                                                <label for="firstName">@lang('First Name')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="lastName"
                                                    placeholder="@lang('Last Name')" name="lastname"
                                                    value="{{ $user->lastname }}">
                                                <label for="lastName">@lang('Last Name')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select support-readonly" name="country" required id="gateway">
                                                    @foreach ($countries as $key => $country)
                                                        <option data-mobile_code="{{ $country->dial_code }}"
                                                            value="{{ $country->country }}"
                                                            data-code="{{ $key }}"
                                                            {{ $user->country_code == $key ? 'selected' : '' }}>
                                                            {{ __($country->country) }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="country" class="label-readonly">@lang('Country')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <div class="input-group">
                                                    <span class="input-group-text mobile-code bg--base text-white border-0">
                                                    </span>
                                                    <input type="number" class="form-control checkUser" name="mobile"
                                                        id="mobile" value="{{ $user->mobile }}" required>
                                                </div>
                                                <small class="text-danger mobileExist"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="address"
                                                    placeholder="@lang('Address')" name="address"
                                                    value="{{ $user->address?->address }}">
                                                <label for="address">@lang('Address')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="state"
                                                    placeholder="@lang('State')" name="state" value="{{ $user->address?->state }}">
                                                <label for="state">@lang('State')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="zipCode"
                                                    placeholder="@lang('Zip Code')" name="zip" value="{{ $user->address?->zip }}">
                                                <label for="zipCode">@lang('Zip Code')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="city"
                                                    placeholder="@lang('City')" name="city" value="{{ $user->address?->city }}">
                                                <label for="city">@lang('City')</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="profile__form">
                                                <button type="submit"
                                                    class="btn btn--base w-100">@lang('Submit')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        'use strict';
        const fileInput = document.getElementById('profile__change');
        const profileImage = document.getElementById('profileImage');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>


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
    </script>
@endpush

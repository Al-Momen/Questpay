@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="custom--card">
        <div class="sign-up__wapper">
            <div class="wrap">
                <div class="section-heading mb-2">
                    <h2 class="section-heading__title sign-up__title title-animation">@lang('Reset Password')</h2>
                    <p class="section-heading__desc title-animation">
                        @lang("Your account is verified successfully. Now you can change your password. Please enter a strong password and don't share it with anyone.")
                    </p>
                </div>
            </div>
            <div class="sign-up__forms">
                <div class="sign-up__shape">
                    <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                </div>
                <form method="POST" action="{{ route('user.password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" name="password" required id="usernameInput" required
                                placeholder="@lang('Password')">
                            <label for="usernameInput">@lang('Password')</label>
                        </div>
                    </div>
                    @if ($general->secure_password)
                        <div class="input-popup">
                            <p class="error lower">@lang('1 small letter minimum')</p>
                            <p class="error capital">@lang('1 capital letter minimum')</p>
                            <p class="error number">@lang('1 number minimum')</p>
                            <p class="error special">@lang('1 special character minimum')</p>
                            <p class="error minimum">@lang('6 character password')</p>
                        </div>
                    @endif
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password_confirmation" required
                                id="passwordInput" required placeholder="@lang('Confirm Password')">
                            <label for="passwordInput">@lang('Confirm Password')</label>
                        </div>
                    </div>
                    <div class="form--check__btn mt-4">
                        <button type="submit" class="hero-button btn btn--base w--100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush



@push('script')
<script>
    (function($) {
        "use strict";
        @if ($general->secure_password)
            $('input[name=password]').on('input', function() {
                secure_password($(this));
            });

            $('[name=password]').on('focus', function() {
                $(this).closest('.form-group').addClass('hover-input-popup');
            });

            $('[name=password]').on('focusout', function() {
                $(this).closest('.form-group').removeClass('hover-input-popup');
            });
        @endif
    })(jQuery);
</script>
@endpush

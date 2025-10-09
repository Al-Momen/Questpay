@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="custom--card">
        <div class="sign-up__wapper">
            <div class="wrap">
                <div class="section-heading mb-2">
                    <h2 class="section-heading__title sign-up__title title-animation">{{ __($pageTitle) }}</h2>
                    <p class="section-heading__desc title-animation">
                        @lang('To recover your account please provide your email or username to find your account.')
                    </p>
                </div>
            </div>
            <div class="sign-up__forms">
                <div class="sign-up__shape">
                    <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                </div>
                <form method="POST" action="{{ route('user.password.email') }}">
                    @csrf
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="value"
                                value="{{ old('value') }}" id="usernameInput" required autofocus="off" placeholder="@lang('Email or Username')">
                            <label for="usernameInput">@lang('Email or Username')</label>
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

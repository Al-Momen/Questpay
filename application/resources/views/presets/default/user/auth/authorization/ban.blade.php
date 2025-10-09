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
                <h3 class="text-center text-danger">@lang('You are banned')</h3>
                <p class="fw--500 mb-1">@lang('Reason'):</p>
                <p>{{ $user->ban_reason }}</p>
            </div>
        </div>
    </div>
@endsection

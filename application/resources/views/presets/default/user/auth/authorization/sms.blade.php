@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="custom--card">
        <div class="sign-up__wapper">
            <div class="wrap">
                <div class="section-heading mb-2">
                    <h2 class="section-heading__title sign-up__title title-animation">@lang('Verify Mobile Number')</h2>
                    <p class="section-heading__desc title-animation">
                       @lang('A 6 digit verification code sent to your mobile number') : +{{showMobileNumber(auth()->user()->mobile) }}
                    </p>
                </div>
            </div>
            <div class="sign-up__forms">
                <div class="sign-up__shape">
                    <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                </div>
                <div class="d-flex justify-content-center">

                    <div class="verification-area">
                        <form action="{{route('user.verify.mobile')}}" method="POST" class="submit-form">
                            @csrf
                            @include($activeTemplate . 'components.verification_code')
                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                            <div>
                                <p>
                                    @lang('If you don\'t get any code'), 
                                    <a href="{{ route('user.send.verify.code', 'email') }}"><u>@lang('Try again')</u></a>
                                </p>
                                @if ($errors->has('resend'))
                                    <small class="text-danger d-block">{{ $errors->first('resend') }}</small>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .verification-code input {
            letter-spacing: 76px !important;
            text-indent: 7px !important;
        }


        @media screen and (max-width: 991px) {
            .verification-code input {
                letter-spacing: 76px !important;
                text-indent: 7px !important;
            }
        }

        @media screen and (max-width: 426px) {
            .verification-code input {
                letter-spacing: 32px !important;
                text-indent: 2px !important;
            }
        }

        @media screen and (max-width: 376px) {
            .verification-code input {
                letter-spacing: 35px !important;
                text-indent: 2px !important;
            }
        }

        @media screen and (max-width: 321px) {
            .verification-code input {
                letter-spacing: 24px !important;
                text-indent: 2px !important;
            }
        }

        .verification-code::after {
            background-color: transparent;
        }

        .verification-code span {
            background: transparent !important;
            border: solid 1px #7bb5a3;
        }
    </style>
@endpush

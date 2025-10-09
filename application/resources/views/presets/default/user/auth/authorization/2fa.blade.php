@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="custom--card">
        <div class="sign-up__wapper">
            <div class="wrap">
                <div class="section-heading mb-2">
                    <h2 class="section-heading__title sign-up__title title-animation">@lang('2FA Verification')</h2>
                </div>
            </div>
            <div class="sign-up__forms">
                <div class="sign-up__shape">
                    <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                </div>
                <div class="d-flex justify-content-center">
                    <div class="verification-area">
                        <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                            @csrf
                            @include($activeTemplate . 'components.verification_code')

                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
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

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#code').on('input change', function() {
                var xx = document.getElementById('code').value;
                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)
    </script>
@endpush

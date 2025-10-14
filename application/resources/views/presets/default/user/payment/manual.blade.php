@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="profile-section">
            <div class="container">
                @include('Template::components.user.top_header')
                <div class="profile-items">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-8">
                            <div class="profile__wrap card p-4">
                                <div class="card-header card-header-bg">
                                    <h5 class="card-title">{{ __($pageTitle) }}</h5>
                                </div>
                                <div class="row g-4">
                                    <form action="{{ route('user.deposit.manual.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12 text-center">
                                            <p class="text-center mt-2">@lang('You have requested') <b
                                                    class="text-success">{{ showAmount($data['amount']) }}
                                                    {{ $general->cur_text }}</b> ,
                                                @lang('Please pay')
                                                <b class="text-success">{{ $data['method_currency'] . showAmount($data['final_amo']) }}
                                                </b> @lang('for successful payment')
                                            </p>
                                            <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                            <p class="my-4 text-center">@php echo $data->gateway->description @endphp</p>
                                        </div>

                                        <x-custom-form identifier="id"
                                            identifierValue="{{ $gateway->form_id }}"></x-custom-form>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                               
                                                @if ($data->is_credit_purchase)
                                                    <button type="submit"
                                                        class="btn btn--base btn--lg w-100">@lang('Credit Purchase')</button>
                                                @else
                                                    <button type="submit"
                                                        class="btn btn--base btn--lg w-100">@lang('Payment Now')</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

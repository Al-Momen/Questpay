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
                                <h5 class="mb-3">@lang('Flutterwave')</h5>
                                <div class="row g-4">
                                    <div class="col-sm-12">
                                        <ul class="list-group text-center">
                                            <li class="list-group-item d-flex justify-content-between">
                                                @lang('You have to pay '):
                                                <strong>{{ showAmount($deposit->final_amo) }}
                                                    {{ __($deposit->method_currency) }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                @lang('You will get '):
                                                <strong>{{ showAmount($deposit->amount) }}
                                                    {{ __($general->cur_text) }}</strong>
                                            </li>
                                        </ul>
                                        <div class="row g-4">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn--base w-100 mt-3" id="btn-confirm"
                                                    onClick="payWithRave()">@lang('Pay Now')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{ $data->API_publicKey }}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{ $data->customer_email }}",
                amount: "{{ $data->amount }}",
                customer_phone: "{{ $data->customer_phone }}",
                currency: "{{ $data->currency }}",
                txref: "{{ $data->txref }}",
                onclose: function() {},
                callback: function(response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                    // x.close(); // use this to close the modal immediately after payment.
                }
            });
        }
    </script>
@endpush

@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="survey-list pt-120">
        <div class="container">
            <div class="survey-list__main">
                @include('Template::components.user.top_header')
                <form action="">
                    <div class="row">
                        <!-- Transaction Number -->
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                                    placeholder="@lang('Search by transactions')">
                                <label class="form-label">@lang('Transaction Number')</label>
                            </div>
                        </div>
                        
                        <!-- Type -->
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select name="type" class="form-select">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                                </select>
                                <label class="form-label">@lang('Type')</label>
                            </div>
                        </div>

                        <!-- Remark -->
                        <div class="col-md-3">
                            <div class="form-floating">

                                <select class="form-select" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                            {{ __(keyToTitle($remark->remark)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <label class="form-label">@lang('Remark')</label>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-md-3">
                            <button class="btn btn--base btn--lg custom-filter-btn w-100">
                                <i class="fa-solid fa-filter"></i> @lang('Filter')
                            </button>
                        </div>
                    </div>
                </form>

                <div class="dashboard-table card mt-4">
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('Transacted')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>
                                            {{ $trx->trx }}
                                        </td>

                                        <td>
                                            {{ showDateTime($trx->created_at) }}
                                        </td>

                                        <td class="budget">
                                            <span
                                                class=" @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                {{ $general->cur_text }}
                                            </span>
                                        </td>

                                        <td class="budget">
                                            {{ showAmount($trx->post_balance) }}
                                            {{ __($general->cur_text) }}
                                        </td>

                                        <td>{{ __($trx->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            {{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($transactions->hasPages())
                        <div class="card-footer text-end">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/common/css/datepicker.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/common/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/common/js/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery)
    </script>
@endpush

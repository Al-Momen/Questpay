@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="row gy-3 gy-xl-4 justify-content-between">
                 
                    <div class="col-lg-3">
                        <form action="">
                            <div class="form-floating">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request()->search }}"
                                        placeholder="@lang('Search TRX')">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                       <div class="col-lg-3 text-end">
                        <a href="{{ route('user.withdraw') }}"
                        class="btn btn--md btn--base {{ Route::is('user.withdraw') ? 'active' : '' }}">@lang('Withdraw')</a>
                    </div>
                </div>
                <div class="dashboard-table card mt-3">
                            <h3 class="dashboard-table__title fs--16 fw--700 mb--16">@lang('Withdraw List')</h3>
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('TRX No')</th>
                                    <th class="text-center">@lang('Gateway')</th>
                                    <th class="text-center">@lang('Date')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdraws as $withdraw)
                                    <tr>
                                        <td data-label="@lang('TRX No')">
                                            {{ __($withdraw->trx) }}
                                        </td>
                                        <td data-label="@lang('Gateway')">
                                            {{ __($withdraw->method?->name ?? '') }}
                                        </td>
                                        <td class="text-center" data-label="@lang('Date')">
                                            {{ showDateTime($withdraw->created_at) }}
                                        </td>
                                        <td class="text-center" data-label="@lang('Amount')">
                                            {{ ($general->cur_sym) }}{{ showAmount($withdraw->amount) }}
                                            </span>
                                        </td>
                                        <td class="text-center" data-label="@lang('Conversion')">
                                            <span>{{ showAmount($withdraw->final_amount) }} {{$withdraw->currency }} </span>
                                          
                                        </td>
                                        <td class="text-center" data-label="@lang('Status')">
                                            @php echo $withdraw->statusBadge @endphp
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="btn btn--sm btn--base detailBtn"
                                                data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                                @if ($withdraw->status == 3) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $withdraws->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData">

                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = ``;
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });
                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

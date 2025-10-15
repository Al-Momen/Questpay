@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="survey-list pt-120">
        <div class="container">
            <div class="survey-list__main">
                @include('Template::components.user.top_header')
                <div class="row justify-content-between">
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
                        <a href="{{ route('user.survey.create') }}" class="btn btn--md btn--base">@lang('Add New')</a>
                    </div>
                </div>
                <div class="dashboard-table card mt-4">
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th class="text-center">@lang('Title')</th>
                                    <th class="text-center">@lang('Survey People')</th>
                                    <th class="text-center">@lang('Distribute Money')</th>
                                    <th class="text-center">@lang('Total Question')</th>
                                    <th class="text-center">@lang('Payment Status')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surveys as $item)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->title }}</td>
                                        <td class="text-center">{{ $item->survey_people }}</td>
                                        <td class="text-center">{{ $general->cur_sym . $item->survey_money }}</td>
                                        <td class="text-center">{{ $item->total_question }}</td>
                                        <td class="text-center">
                                            @if ($item->deposit)
                                                @php echo $item->deposit->statusBadge @endphp
                                            @elseif(!$item->deposit && $item->is_payment_balance)
                                                <span class="badge badge--success">@lang('Approved')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('N/A')</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                @if (!in_array($item->status, [Status::SURVEY_INITIAL, Status::SURVEY_REJECTED]))
                                                    <div class="form-group mb-0">
                                                        <label class="switch m-0" title="@lang($item->status ? 'Disable' : 'Enable')">
                                                            <input type="checkbox" class="toggle-switch confirmationBtn"
                                                                data-question="@lang('Are you sure to change this survey status?')"
                                                                data-action="{{ route('user.survey.status', $item->id) }}"
                                                                @checked($item->status)>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                @endif
                                                <a href="{{ route('user.survey.details', $item->id) }}"
                                                    class="btn btn--sm btn--base" title="@lang('View')">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $surveys->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

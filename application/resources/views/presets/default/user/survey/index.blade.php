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
                        <a href="{{ route('user.survey.create') }}" class="btn btn--md btn--base">@lang('Add New')</a>
                    </div>
                </div>
                <div class="dashboard-table card mt-3 mt-xl-4">
                    <h3 class="dashboard-table__title fs--16 fw--700 mb--16">@lang('Survey List')</h3>
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Image')</th>
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
                                      
                                        <td>
                                              @if ($item->pendingCount())
                                                <div class="blob white pointer-dot"></div>
                                            @endif 
                                            #{{ $loop->iteration }}
                                        </td>
                                        <td data-label="Image">
                                            <img class="rounded-3"
                                                src="{{ getImage(getFilePath('survey') . '/' . $item->image) }}"
                                                alt="@lang('Survey Image')" width="70">
                                        </td>
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
                                            <div class="dropdown">
                                                <button class="dashboard-table__btn" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.survey.view', $item->id) }}">@lang('View')</a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('user.survey.answer.user.list', $item->id) }}">@lang('Submission List')</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item copyLinkBtn" href="javascript:void(0)"
                                                            data-url="{{ route('user.survey.details', $item->id) }}">
                                                            @lang('Copy Link')
                                                        </a>
                                                    </li>
                                                    @if (!in_array($item->status, [Status::SURVEY_INITIAL, Status::SURVEY_REJECTED]))
                                                        <li>
                                                            <a class="dropdown-item confirmationBtn"
                                                                href="javascript:void(0)" title="@lang($item->status ? 'Disable' : 'Enable')"
                                                                data-question="@lang('Are you sure to change this survey status?')"
                                                                data-action="{{ route('user.survey.status', $item->id) }}">@lang('Status')
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
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

@push('script')
    <script>
        $(document).on('click', '.copyLinkBtn', function() {
            let link = $(this).data('url');

            navigator.clipboard.writeText(link)
                .then(() => {
                    notify('success', 'Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        });
    </script>
@endpush

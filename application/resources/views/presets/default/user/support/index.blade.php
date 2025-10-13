@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="survey-list pt-120">
        <div class="container">
            <div class="survey-list__main">
                @include('Template::components.user.top_header')
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h3 class="survey-list__header-title">{{ __($pageTitle) }}</h3>
                    <a href="{{ route('ticket.open') }}" class="btn btn-md btn--base mb-2"> <i class="fa fa-plus"></i>
                        @lang('New Ticket')</a>
                </div>
                <div class="dashboard-table card">
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supports as $support)
                                    <tr>
                                        <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw--500">
                                                [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                            </a></td>
                                        <td>
                                            @php echo $support->statusBadge; @endphp
                                        </td>
                                        <td>
                                            @if ($support->priority == 1)
                                                <span class="badge badge--secondary">@lang('Low')</span>
                                            @elseif($support->priority == 2)
                                                <span class="badge badge--success">@lang('Medium')</span>
                                            @elseif($support->priority == 3)
                                                <span class="badge badge--primary">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                                        <td>
                                            <a href="{{ route('ticket.view', $support->ticket) }}"
                                                class="btn btn--base btn--sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                 {{ $supports->links() }}
            </div>
        </div>
    </div>
@endsection

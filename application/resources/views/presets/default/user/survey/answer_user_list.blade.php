@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="survey-list pt-120">
        <div class="container">
            <div class="survey-list__main">
                @include('Template::components.user.top_header')
                <div class="dashboard-table card mt-4">
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th class="text-center">@lang('Username')</th>
                                    <th class="text-center">@lang('Survey Title')</th>
                                    <th class="text-center">@lang('Created-At')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surveyAnswers ?? [] as $item)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td class="text-center">{{'@'.$item?->user->username }}</td>
                                        <td class="text-center">{{ __($item?->survey->title) }}</td>
                                        <td class="text-center">{{ showDateTime($item->created_at) }}</td>
                                        <td class="text-center">
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <a href="{{ route('user.survey.answer.detail', $item->id) }}"
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
                    {{ $surveyAnswers->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

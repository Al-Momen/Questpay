@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="row justify-content-end">
                    <div class="col-lg-3">
                        <form action="">
                            <div class="form-floating">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request()->search }}"
                                        placeholder="@lang('Search Survey Name')">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="dashboard-table card mt-4">
                    <h3 class="dashboard-table__title fs--16 fw--700 mb--16">@lang('Submission List')</h3>
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
                                    <th class="text-center">@lang('Your Answer')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surveySubmissions as $item)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td data-label="Image">
                                            <img class="rounded-3"
                                                src="{{ getImage(getFilePath('survey') . '/' . $item->survey->image) }}"
                                                alt="@lang('Survey Image')" width="70">
                                        </td>
                                        <td class="text-center">{{ $item->survey->title }}</td>
                                        <td class="text-center">{{ $item->survey->survey_people }}</td>
                                        <td class="text-center">{{ $general->cur_sym . $item->survey->survey_money }}</td>
                                        <td class="text-center">{{ $item->total_question }}</td>
                                        <td class="text-center">{{ $item->total_answer }}</td>

                                        <td class="text-center">
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">

                                                <a href="{{ route('user.survey.submission.details', $item->id) }}"
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
                    {{ $surveySubmissions->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

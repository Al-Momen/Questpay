@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="profile-items">
                    <div class="text-end">
                        <div class="d-flex flex-wrap justify-content-sm-end gap-3 mb-3">
                            <a href="{{ route('user.survey.submission') }}" class="btn btn--base">@lang('Back')
                            </a>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="profile__wrap card submission-data">
                                <div class="row gy-4">
                                    <div class="col-lg-8 col-xl-9 order-1 order-lg-0">
                                        <div class="submission-data__header">
                                            <h4 class="mb-0">@lang('Survey Form Data')</h4>
                                        </div>
                                        <div class="submission-data__body">
                                            <div class="row gy-4">
                                                @foreach ($submissionSurveyAnswerDetail->answer ?? [] as $index => $q)
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">
                                                            @lang('Question'):
                                                            {{ $index + 1 < 10 ? '0' . ($index + 1) : $index + 1 }}.
                                                            {{ $q['question'] }}
                                                        </label>
                                                        <ul class="submission-question__list">
                                                            <li>
                                                                @lang('Type'):
                                                                {{ ucwords(str_replace('_', ' ', $q['type'])) }}
                                                            </li>
                                                            <li>
                                                                @lang('Quality'): {{ $q['score'] }}%
                                                            </li>
                                                            <li>
                                                                @lang('Answer'):
                                                                @if (is_array($q['answer']))
                                                                    {{ implode(', ', $q['answer']) }}
                                                                @else
                                                                    {{ $q['answer'] ?? '--' }}
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-3">
                                        <ul class="submission-data__list">
                                            <li class="mb-20">
                                                @lang('Total Questions'):
                                                {{ $submissionSurveyAnswerDetail->total_question < 10 ? '0' . $submissionSurveyAnswerDetail->total_question : $submissionSurveyAnswerDetail->total_question }}

                                            </li>
                                            <li class="mb-20">
                                                @lang('Total Answer'):
                                                {{ $submissionSurveyAnswerDetail->total_answer < 10 ? '0' . $submissionSurveyAnswerDetail->total_answer : $submissionSurveyAnswerDetail->total_answer }}
                                            </li>
                                            <li class="mb-20">
                                                @lang('Empty Answer'):
                                                {{ $submissionSurveyAnswerDetail->empty_answer < 10 ? '0' . $submissionSurveyAnswerDetail->empty_answer : $submissionSurveyAnswerDetail->empty_answer }}
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

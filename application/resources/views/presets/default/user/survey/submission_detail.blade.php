@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="profile-section">
            <div class="container">
                @include('Template::components.user.top_header')
                <div class="profile-items">
                    <div class="text-end">
                        <div class="d-flex flex-wrap justify-content-sm-end gap-3 mb-2">
                            <a href="{{ route('user.survey.submission') }}"
                                class="btn btn--base">@lang('Back')
                            </a>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="profile__wrap card p-4">
                                <div class="d-flex flex-wrap justify-content-sm-between">
                                    <div>
                                        <h5 class="mb-20">@lang('Survey Form Data')</h5>
                                    </div>
                                    <div>
                                        <p class="mb-20">
                                            @lang('Total Questions'):
                                            {{ $submissionSurveyAnswerDetail->total_question < 10 ? '0' . $submissionSurveyAnswerDetail->total_question : $submissionSurveyAnswerDetail->total_question }}
                                        </p>
                                        <p class="mb-20">
                                            @lang('Total Answer'):
                                            {{ $submissionSurveyAnswerDetail->total_answer < 10 ? '0' . $submissionSurveyAnswerDetail->total_answer : $submissionSurveyAnswerDetail->total_answer }}
                                        </p>
                                        <p class="mb-20">
                                            @lang('Empty Answer'):
                                            {{ $submissionSurveyAnswerDetail->empty_answer < 10 ? '0' . $submissionSurveyAnswerDetail->empty_answer : $submissionSurveyAnswerDetail->empty_answer }}
                                        </p>
                                     
                                    </div>
                                </div>
                                @foreach ($submissionSurveyAnswerDetail->answer ?? [] as $index => $q)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            @lang('Question'): {{ $index + 1 < 10 ? '0' . ($index + 1) : $index + 1 }}.
                                            {{ $q['question'] }}
                                        </label>
                                        <span class="d-block mb-2">
                                            @lang('Type'): {{ ucwords(str_replace('_', ' ', $q['type'])) }}
                                        </span>
                                        <span class="d-block mb-2">
                                            @lang('Quality'): {{ $q['score'] }}%
                                        </span>
                                        <span class="d-block">
                                            @lang('Answer'):
                                            @if (is_array($q['answer']))
                                                {{ implode(', ', $q['answer']) }}
                                            @else
                                                {{ $q['answer'] ?? '--' }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

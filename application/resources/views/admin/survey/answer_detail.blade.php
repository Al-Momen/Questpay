@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card br--solid radius--base bg--white mb-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <h4 class="mb-3">@lang('Survey Answer')</h4>
                                @foreach ($surveyAnswerDetail->answer ?? [] as $index => $q)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            @lang('Question'):
                                            {{ $index + 1 < 10 ? '0' . ($index + 1) : $index + 1 }}.
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
                        <div class="col-4">
                            <div class="row justify-content-end">
                                <div class="col-12 text-end">
                                    <div class="d-flex flex-wrap justify-content-end gap-3 mb-2">
                                        @if ($surveyAnswerDetail->survey->author_id == auth('admin')->id() && $surveyAnswerDetail->survey->author_type == Admin::class && $surveyAnswerDetail->status == Status::SURVEY_ANSWER_PENDING)
                                            <div>
                                                <a href="javascript:void(0)" class="btn btn--primary confirmationBtn "
                                                    data-question="@lang('Are you sure to approved this answer?')"
                                                    data-action="{{ route('admin.survey.answer.status', [1, $surveyAnswerDetail->id]) }}">
                                                    @lang('Approved')
                                                </a>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" class="btn btn--danger confirmationBtn"
                                                    data-question="@lang('Are you sure to reject this answer?')"
                                                    data-action="{{ route('admin.survey.answer.status', [3, $surveyAnswerDetail->id]) }}">
                                                    @lang('Rejected')
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="mb-20">
                                            @lang('Total Questions'):
                                            {{ $surveyAnswerDetail->total_question < 10 ? '0' . $surveyAnswerDetail->total_question : $surveyAnswerDetail->total_question }}
                                        </p>
                                        <p class="mb-20">
                                            @lang('Total Answer'):
                                            {{ $surveyAnswerDetail->total_answer < 10 ? '0' . $surveyAnswerDetail->total_answer : $surveyAnswerDetail->total_answer }}
                                        </p>
                                        <p class="mb-20">
                                            @lang('Empty Answer'):
                                            {{ $surveyAnswerDetail->empty_answer < 10 ? '0' . $surveyAnswerDetail->empty_answer : $surveyAnswerDetail->empty_answer }}
                                        </p>
                                        <p class="mb-20">
                                            @lang('Average Quality'): {{ $surveyAnswerDetail->average_quality }}%
                                        </p>
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


@push('breadcrumb-plugins')
    <a href="{{ route('admin.survey.answer.user.list', $surveyAnswerDetail->survey_id) }}" class="btn btn-sm btn--primary">
        <i class="fa-solid fa-arrow-left"></i> @lang('Back')
    </a>
@endpush


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/common/css/jquery-ui.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/jquery-ui.min.js') }}"></script>
@endpush

@push('script')
    @include('components.form_builder_js')
@endpush

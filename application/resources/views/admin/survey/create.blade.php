@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card br--solid radius--base bg--white mb-4 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">@lang('Survey Information')</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="survey_money" class="form-label">@lang('Number of People Survey Access')</label>
                                <input type="number" name="survey_people" id="survey_people"
                                    value="{{ old('survey_people') }}" class="form-control mb-4"
                                    placeholder="@lang('How many people get access to this survey question?')" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="survey_money" class="form-label">@lang('Per Question (Cent)')</label>
                                <input type="number" name="survey_money" id="survey_money" step="any" min="0"
                                    value="{{ old('survey_money') }}" class="form-control mb-4"
                                    placeholder="@lang('How many cents does a user get per question answered?')" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="total_question" class="form-label">@lang('Total Questions')</label>
                                <input type="number" name="total_question" id="total_question"
                                    value="{{ old('total_question') }}" class="form-control mb-4"
                                    placeholder="@lang('How many cents does a user get per question answered?')" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card br--solid radius--base bg--white mb-4 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">@lang('AI Survey Generator')</h4>

                    {{-- Chat-like Container --}}
                    <div class="chat-box border rounded p-3 bg-light" id="chatContainer">
                        <div id="chatMessages" class="d-flex flex-column gap-3">
                            <div class="text-muted small text-center defaultPrompt">@lang('Start by entering a prompt below...')</div>
                        </div>
                    </div>

                    {{-- Prompt Input --}}
                    <div class="mt-4">
                        <div class="form-group text-end">
                            <textarea id="prompts" class="form-control form--control" rows="3" placeholder="@lang('Write a prompt to generate survey...')"></textarea>
                            <button type="button" class="btn btn--primary mt-2" id="generateBtn">
                                <i class="fa-solid fa-paper-plane"></i> @lang('Generate')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card br--solid radius--base bg--white mb-4 p-4 shadow-sm">
                <div class="text-center defaultChatMessage">@lang('Create a set of questions')</div>
                <div id="surveyFormContainer" class="question-list"></div>

                <div class="text-end">
                    <button type="button" class="btn btn-outline-primary  w-25 mt-3" id="addQuestionBtn">
                        <i class="fa fa-plus"></i> @lang('Add Question')
                    </button>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn--primary mt-3 d-none" id="saveSurveyBtn">
                    <i class="fa fa-save"></i> @lang('Save Survey')
                </button>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.survey.index') }}" class="btn btn-sm btn--primary">
        <i class="fa-solid fa-arrow-left"></i> @lang('Back')
    </a>
@endpush


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/common/css/jquery-ui.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/jquery-ui.min.js') }}"></script>
@endpush

@push('style')
    <style>
        .chat-box::-webkit-scrollbar {
            width: 6px;
        }

        .chat-box {

            height: 400px;
            overflow-y: auto;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .drag-handle {
            cursor: move;
            color: #666;
            transition: color 0.2s ease;
        }

        .drag-handle:hover {
            color: #000;
        }

        .question-item.dragging {
            opacity: 0.6;
        }

        .sortable-placeholder {
            border: 2px dashed #999;
            background: #f8f9fa;
            height: 70px;
            margin-bottom: 10px;
            border-radius: 8px;
            animation: fadeIn 0.2s ease-in-out;
        }
    </style>
@endpush

@push('script')
    @include('components.form_builder_js')
@endpush

@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="profile-items">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="profile__wrap card p-4">
                                <div class="d-flex justify-content-between align-content-center flex-wrap gap-2 mb-3">
                                    <h4 class="mb-0">@lang('Survey Information')</h4>
                                    <div>
                                        <span class="badge badge--base total-question">@lang('Total Question')(0)</span>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <div class="logo-upload--box">
                                            <x-image-uploader name="image" :imagePath="getImage(getFilePath('survey') . '/', getFileSize('survey'))" :size="getFileSize('survey')"
                                                :isImage="true" class="w-100" id="uploadLogo3" :baseColor="true"
                                                :required="true" />
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="profile__form">
                                                    <div class="form-floating">
                                                        <select class="form-control form-select mb-4" name="category_id"
                                                            required>
                                                            <option value="0">@lang('Select category')</option>
                                                            @foreach ($categories ?? [] as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="survey_money"
                                                            class="form-label">@lang('Category')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="profile__form">
                                                    <div class="form-floating">
                                                        <input type="number" name="survey_people" id="survey_people"
                                                            value="{{ old('survey_people') }}" class="form-control mb-4"
                                                            placeholder="@lang('How many people get access to this survey question?')" required>
                                                        <label for="survey_money"
                                                            class="form-label">@lang('Number of People Survey Access')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="profile__form">
                                                    <div class="form-floating">
                                                        <input type="number" name="survey_money" id="survey_money"
                                                            step="any" min="0" value="{{ old('survey_money') }}"
                                                            class="form-control mb-4" placeholder="@lang('How many cents does a user get per question answered?')"
                                                            required>
                                                        <label for="survey_money"
                                                            class="form-label">@lang('Per Question (Cent)')</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-items mt-4">
                        <div class="row g-4 justify-content-center">
                            <div class="col-lg-6">
                                <div class="profile__wrap card p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="mb-0">@lang('AI Survey Generator')</h4>
                                        <span class="text--base">
                                            (@lang('Credit Cost per Prompt'): {{ $general->credit_cost_per_prompt }})
                                        </span>
                                    </div>
                                    <div class="mb-4">
                                        <p>@lang('Your current credit is'): {{ auth()->user()->credit }}.</p>
                                        @if ($general->credit_cost_per_prompt > auth()->user()->credit)
                                            <p class="text-danger mb-2">
                                                @lang('You do not have enough credits.')
                                            </p>
                                            <a href="{{ route('user.credit.purchase') }}" class="btn btn--base btn--sm">
                                                @lang('Buy Credits')
                                            </a>
                                        @endif
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-sm-12">
                                            <div class="chat-box border rounded p-3 bg-light" id="chatContainer">
                                                <div id="chatMessages" class="d-flex flex-column gap-3">
                                                    <div class=" small text-center defaultPrompt">@lang('Start by entering a prompt below...')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group text-end mt-4">
                                                <textarea id="prompts" class="form-control" rows="3" placeholder="@lang('Write a prompt to generate survey...')"></textarea>
                                                @if ($general->credit_cost_per_prompt <= auth()->user()->credit)
                                                    <button type="button" class="btn btn--base mt-2" id="generateBtn">
                                                        <i class="fa-solid fa-paper-plane"></i> @lang('Generate')
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="profile-items">
                                    <div class="row g-4 justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="profile__wrap card p-4">
                                                <div class="row g-4">
                                                    <div class="col-sm-12">
                                                        <div class="text-center defaultChatMessage">@lang('Create a set of questions')</div>
                                                        <div id="surveyFormContainer" class="question-list"></div>
                                                        <div class="text-end">
                                                            <button type="button"
                                                                class="btn btn-outline--base btn--md  mt-3"
                                                                id="addQuestionBtn">
                                                                <i class="fa fa-plus"></i> @lang('Add Question')
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="text-end">
                                                            <button class="btn btn--base mt-3 d-none" id="saveSurveyBtn">
                                                                <i class="fa fa-save"></i> @lang('Save Survey')
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.survey.index') }}" class="btn btn-sm btn--base">
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
        #surveyFormContainer {
            max-height: 100vh;
            overflow-y: auto;
        }

        #prompts::placeholder {
            color: hsl(var(--black) / 0.4);
        }

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

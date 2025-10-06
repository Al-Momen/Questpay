@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-5">
            <div class="card br--solid radius--base bg--white mb-4 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">@lang('AI Survey Generator')</h4>

                    {{-- Chat-like Container --}}
                    <div class="chat-box border rounded p-3 bg-light" style="height: 400px; overflow-y: auto;"
                        id="chatContainer">
                        <div id="chatMessages" class="d-flex flex-column gap-3">
                            <div class="text-muted small text-center">@lang('Start by entering a prompt below...')</div>
                        </div>
                    </div>

                    {{-- Prompt Input --}}
                    <div class="mt-4">
                        <div class="form-group position-relative">
                            <textarea id="prompts" class="form-control form--control" rows="3" placeholder="@lang('Write a prompt to generate survey...')"></textarea>
                            <button type="button" class="btn btn--primary position-absolute"
                                style="right: 10px; bottom: 10px;" id="generateBtn">
                                <i class="fa-solid fa-paper-plane"></i> @lang('Generate')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div id="surveyFormContainer" class="card br--solid radius--base bg--white mb-4 p-4 shadow-sm">
                <div class="text-center">@lang('Make a question')</div>
            </div>
            <button class="btn btn-success mt-3 d-none" id="saveSurveyBtn">
                <i class="fa fa-save"></i> @lang('Save Survey')
            </button>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.survey.index') }}" class="btn btn-sm btn--primary">
        <i class="fa-solid fa-arrow-left"></i> @lang('Back')
    </a>
@endpush

@push('script')
    <script>
        $(function() {

            // Ajax survey generate
            const chatContainer = $("#chatContainer");
            const chatMessages = $("#chatMessages");
            const generateBtn = $("#generateBtn");
            const promptInput = $("#prompts");

         
            // Append Message Function
            function appendMessage(content, type = "ai") {
                const msgClass = type === "user" ?
                    "bg-primary text-white align-self-end" :
                    "bg-white border align-self-start";
                const msg = `<div class="p-3 rounded ${msgClass}" style="max-width:80%">${content}</div>`;
                chatMessages.append(msg);
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }

         
            // Generate Survey AJAX Function
            function generateSurvey(prompt) {
                if (!prompt.trim()) return;
                appendMessage(prompt, "user");
                promptInput.val("");
                appendMessage("<i class='fa fa-spinner fa-spin'></i> AI is generating survey...", "ai");
                $.ajax({
                    url: "{{ route('admin.survey.generate') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        prompt: prompt,
                    },
                    success: function(res) {
                        chatMessages.find(".fa-spinner").closest("div").remove();

                        // Render the survey form
                        if (typeof renderSurveyForm === "function") {
                            renderSurveyForm(res.data);
                        } else {
                            console.error("renderSurveyForm is not defined!");
                        }

                        try {
                            const jsonStr = JSON.stringify(res.data || res, null, 4);
                            appendMessage(`<pre class="m-0"><code>${jsonStr}</code></pre>`, "ai");
                        } catch (e) {
                            appendMessage("Invalid JSON output received.", "ai");
                        }
                    },
                    error: function() {
                        chatMessages.find(".fa-spinner").closest("div").remove();
                        appendMessage("Something went wrong! Please try again.", "ai");
                    }
                });
            }

            //  Generate Button Click
            generateBtn.on("click", function() {
                const prompt = promptInput.val();
                generateSurvey(prompt);
            });


            //  Main Render Survey
            function renderSurveyForm(surveyData) {
                const container = $("#surveyFormContainer");
                $("#saveSurveyBtn").removeClass("d-none");
                container.empty();
                const survey = surveyData;
                if (!survey || !survey.questions) {
                    container.html("<div class='alert alert-danger'>Invalid survey data.</div>");
                    return;
                }
                container.append(renderSurveyTitle(survey.title));
                survey.questions.forEach((q, index) => {
                    container.append(renderQuestion(q, index));
                });
            }

            // Render Survey Title
            function renderSurveyTitle(title) {
                return `
                        <div class="mb-3">
                            <label class="form-label fw-bold">Survey Title</label>
                            <input type="text" class="form-control" name="survey_title" value="${title}">
                        </div>
                    `;
            }

            //  Render Single Question
            function renderQuestion(q, index) {
                const questionDiv = $(`
                    <div class="card mb-3 question-item" data-id="${q.id}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Question ${index + 1}</strong>
                                <button type="button" class="btn btn-sm btn-danger delete-question">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Question Text</label>
                                <input type="text" class="form-control question-text" value="${q.question}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Type</label>
                                <select class="form-select question-type">
                                    <option value="mcq_single" ${q.type === 'mcq_single' ? 'selected' : ''}>Single Choice</option>
                                    <option value="mcq_multiple" ${q.type === 'mcq_multiple' ? 'selected' : ''}>Multiple Choice</option>
                                    <option value="written_input" ${q.type === 'written_input' ? 'selected' : ''}>Short Answer</option>
                                    <option value="written_textarea" ${q.type === 'written_textarea' ? 'selected' : ''}>Long Answer</option>
                                </select>
                            </div>
                            <div class="options-area"></div>
                        </div>
                    </div>
                `);

                if (q.options && q.options.length) {
                    renderOptionsBlock(questionDiv.find(".options-area"), q.options);
                }
                return questionDiv;
            }

            //  Render Options Block
            function renderOptionsBlock(container, options = ["Option 1"]) {
                const optionsDiv = $('<div class="mb-2"><label class="form-label">Options</label></div>');
                const optionsList = $('<div class="options-list"></div>');

                options.forEach((opt, ind) => {
                    optionsList.append(`
                        <div class="d-flex mb-2 option-item">
                            <input type="text" class="form-control option-input" value="${opt}">
                            ${ind > 0 ? `
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                                    <i class="fa fa-times"></i>
                                </button>` : ''}
                        </div>
                    `);
                });

                optionsDiv.append(optionsList);
                optionsDiv.append(`
                    <button type="button" class="btn btn-sm btn-outline-primary add-option">
                        <i class="fa fa-plus"></i> Add Option
                    </button>
                `);

                container.append(optionsDiv);
            }


            //  Add Option Event
            $(document).on("click", ".add-option", function() {
                const list = $(this).siblings(".options-list");
                list.append(renderOptionItem());
            });


            //  Remove Option Event
            $(document).on("click", ".remove-option", function() {
                const optionsList = $(this).closest(".options-list");
                if (optionsList.find(".option-item").length <= 1) {
                    notify('error', "At least one option is required!");
                    return;
                }
                $(this).closest(".option-item").remove();
            });

            //  Delete Question Event
            $(document).on("click", ".delete-question", function() {
                $(this).closest(".question-item").remove();
            });


            //  Question Type Change Event
            $(document).on("change", ".question-type", function() {
                const selectedType = $(this).val();
                const optionsArea = $(this).closest(".question-item").find(".options-area");

                if (selectedType === "mcq_single" || selectedType === "mcq_multiple") {
                    if (!optionsArea.children().length) renderOptionsBlock(optionsArea);
                } else {
                    optionsArea.empty();
                }
            });


            //  Save Survey Event
            $("#saveSurveyBtn").on("click", function() {
                console.log(JSON.stringify(collectSurveyData(), null, 4));
            });


            //  Helper: Render Single Option Item
            function renderOptionItem() {
                return `
                    <div class="d-flex mb-2 option-item">
                        <input type="text" class="form-control option-input" placeholder="New Option">
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;
            }

            //  Helper: Collect Survey Data
            function collectSurveyData() {
                const survey = {
                    title: $("input[name='survey_title']").val(),
                    questions: []
                };

                $(".question-item").each(function(index) {
                    const q = {
                        id: index + 1,
                        type: $(this).find(".question-type").val(),
                        question: $(this).find(".question-text").val()
                    };

                    const opts = [];
                    $(this).find(".option-input").each(function() {
                        const val = $(this).val().trim();
                        if (val) opts.push(val);
                    });
                    if (opts.length) q.options = opts;
                    survey.questions.push(q);
                });

                return survey;
            }

        });
    </script>
@endpush
